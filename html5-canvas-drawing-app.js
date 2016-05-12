// Copyright 2010 William Malone (www.williammalone.com)
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

/*jslint browser: true */
/*global G_vmlCanvasManager */

$( function() {
  $("#timeSetter tr").click( function() {
    $("#timeSetter tr").removeClass("selected");
    $(this).toggleClass("selected");
  } );
} );

var annotationApp = (function () {

    "use strict";

    var canvas,
            context,
            curPeriod,
            canvasWidth,
            canvasHeight,
            currentRadius = 20,
            clickX = [],
            clickY = [],
            clickPeriod = [],
            clickSize = [],
            clickDrag = [],
            paint = false,
            curPeriod = "min",
            totalLoadResources = 1, // only background
            curLoadResNum = 0,
            alphaChannel = 0.5,
    // Clears the canvas.
    clearCanvas = function () {
        context.clearRect(0, 0, canvasWidth, canvasHeight);
    },
    clearAll = function () {
        context.clearRect(0, 0, canvasWidth, canvasHeight);
        clickX = [];
        clickY = [];
        clickPeriod = [];
        clickSize = [];
        clickDrag = [];
        paint = false;
    },            // Redraws the canvas.
            redraw = function () {

                var radius,i;

                // Make sure required resources are loaded before redrawing
                if (curLoadResNum < totalLoadResources) {
                    return;
                }

                clearCanvas();

                // Keep the drawing in the drawing area
                context.save();
                context.beginPath();
                context.rect(0, 0, canvasWidth, canvasHeight);
                context.clip();

                // For each point drawn
                for (i = 0; i < clickX.length; i += 1) {

                    radius = clickSize[i];

                    // Set the drawing path
                    context.beginPath();
                    // If dragging then draw a line between the two points
                    if (clickDrag[i] && i) {
                        context.moveTo(clickX[i - 1], clickY[i - 1]);
                    } else {
                        // The x position is moved over one pixel so a circle even if not dragging
                        context.moveTo(clickX[i] - 1, clickY[i]);
                    }
                    context.lineTo(clickX[i], clickY[i]);

                    context.strokeStyle = periodToColor(clickPeriod[i]);
                    context.lineCap = "round";
                    context.lineJoin = "round";
                    context.lineWidth = radius;
                    context.stroke();
                }
                context.closePath();
                //context.globalCompositeOperation = "source-over";
                context.restore();

                context.globalAlpha = 1; // No IE support
            },
            // Adds a point to the drawing array.
            // @param x
            // @param y
            // @param dragging
            addClick = function (x, y, dragging) {

                clickX.push(x);
                clickY.push(y);
                clickPeriod.push(curPeriod);
                clickSize.push(currentRadius);
                clickDrag.push(dragging);
            },
            periodToColor = function(period) {
                switch(period) {
                    case "min" : return "rgba(255, 105, 97, " + alphaChannel + ")";
                    case "hour" : return "rgba(244, 154, 194, " + alphaChannel + ")";
                    case "day" : return "rgba(203, 153, 201, " + alphaChannel + ")";
                    case "month" : return "rgba(174, 198, 207, " + alphaChannel + ")";
                    case "year" : return "rgba(119, 158, 203, " + alphaChannel + ")";
                }
            },
            // Add mouse and touch event listeners to the canvas
            createUserEvents = function () {

                var press = function (e) {
                    // Mouse down location
                    var rect = this.getBoundingClientRect();
                    var mouseX = (e.changedTouches ? e.changedTouches[0].clientX : e.clientX) - this.offsetLeft - rect.left,
                            mouseY = (e.changedTouches ? e.changedTouches[0].clientY : e.clientY) - this.offsetTop - rect.top;

                    paint = true;
                    addClick(mouseX, mouseY, false);
                    redraw();
                },
                        drag = function (e) {
                            var rect = this.getBoundingClientRect();
                            var mouseX = (e.changedTouches ? e.changedTouches[0].clientX : e.clientX) - this.offsetLeft - rect.left,
                                    mouseY = (e.changedTouches ? e.changedTouches[0].clientY : e.clientY) - this.offsetTop - rect.top;
                            
                            if (paint) {
                                addClick(mouseX, mouseY, true);
                                redraw();
                            }
                            // Prevent the whole page from dragging if on mobile
                            e.preventDefault();
                        },
                        release = function () {
                            paint = false;
                            redraw();
                        },
                        cancel = function () {
                            paint = false;
                        };

                // Add mouse event listeners to canvas element
                canvas.addEventListener("mousedown", press, false);
                canvas.addEventListener("mousemove", drag, false);
                canvas.addEventListener("mouseup", release);
                canvas.addEventListener("mouseout", cancel, false);

                // Add touch event listeners to canvas element
                canvas.addEventListener("touchstart", press, false);
                canvas.addEventListener("touchmove", drag, false);
                canvas.addEventListener("touchend", release, false);
                canvas.addEventListener("touchcancel", cancel, false);
            },
            // Calls the redraw function after all neccessary resources are loaded.
            resourceLoaded = function () {
                curLoadResNum += 1;
                if (curLoadResNum === totalLoadResources) {
                    redraw();
                    createUserEvents();
                }
            },
            // Creates a canvas element, loads images, adds events, and draws the canvas for the first time.
            init = function (backgroundImagePath, w, h) {

                canvasWidth = w;
                canvasHeight = h;

                // Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
                canvas = document.createElement('canvas');
                canvas.setAttribute('width', canvasWidth);
                canvas.setAttribute('height', canvasHeight);
                canvas.setAttribute('id', 'canvas');
                canvas.setAttribute('style', "background-image: URL(" + backgroundImagePath + ")");
                document.getElementById('canvasDivWithImage').appendChild(canvas);
                if (typeof G_vmlCanvasManager !== "undefined") {
                    canvas = G_vmlCanvasManager.initElement(canvas);
                }
                context = canvas.getContext("2d"); // Grab the 2d canvas context
                // Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
                //     context = document.getElementById('canvas').getContext("2d");

                // Load images
                resourceLoaded();
            },
            setPeriod = function(length) {
                curPeriod = length;
            },
            updateRadius = function(delta) {
                currentRadius = Math.max(1, currentRadius + delta);
            },
            exportAnn = function() {
                var data = {
                    "x": clickX,
                    "y": clickY,
                    "period": clickPeriod,
                    "radius": clickSize,
                    "isDrag": clickDrag
                };
                var jsonData = JSON.stringify(data);
                alert(jsonData);
                var request = new XMLHttpRequest();
                var url = "export.php";
                request.open("POST", url, true);
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                request.setRequestHeader("Content-Length", jsonData.length);

                request.onreadystatechange = function() { //Call a function when the state changes.
                    if(request.readyState === 4 && request.status === 200) { // complete and no errors
                        //alert(request.responseText); // some processing here, or whatever you want to do with the response
                    }
                };
                request.send(jsonData);
            };
    return {
        init: init,
        setPeriod: setPeriod,
        clear: clearAll,
        updateRadius: updateRadius,
        export: exportAnn
    };
}());