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

$(function () {
    $("#timeSetter tr").click(function () {
        $("#timeSetter tr").removeClass("selected");
        $(this).toggleClass("selected");
    });
});

var Line = (function(x1, y1, x2, y2) {
    var line = function(x1, y1, x2, y2) {
        var a = y2-y1;
        var b = -x2+x1;
        var c = -(x1*a + y1*b);
        this.distanceFromPt = function(x, y) {
            return Math.abs(a*x+b*y+c)/Math.sqrt(a*a+b*b);
        };
    };
    return line;
})();

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
            alphaChannel = 1.0,
            compressionIdx = 0,
            clickIndex = 0,
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
            },
            // Redraws the canvas.
            redraw = function () {
                var radius;
                
                // Make sure required resources are loaded before redrawing
                if (curLoadResNum < totalLoadResources) {
                    return;
                }
                
                // Keep the drawing in the drawing area
                context.save();
                context.beginPath();
                context.rect(0, 0, canvasWidth, canvasHeight);
                context.clip();

                // For each point drawn
                for (; clickIndex < clickX.length; clickIndex += 1) {

                    radius = clickSize[clickIndex];

                    // Set the drawing path
                    context.beginPath();
                    // If dragging then draw a line between the two points
                    if (clickDrag[clickIndex] && clickIndex) {
                        context.moveTo(clickX[clickIndex - 1], clickY[clickIndex - 1]);
                    } else {
                        // The x position is moved over one pixel so a circle even if not dragging
                        context.moveTo(clickX[clickIndex] - 1, clickY[clickIndex]);
                    }
                    context.lineTo(clickX[clickIndex], clickY[clickIndex]);

                    context.strokeStyle = periodToColor(clickPeriod[clickIndex]);
                    context.lineCap = "round";
                    context.lineJoin = "round";
                    context.lineWidth = radius;
                    context.stroke();
                }
                clickIndex -= 2;
                context.closePath();
                //context.globalCompositeOperation = "source-over";
                context.restore();

                context.globalAlpha = 1; // No IE support
            },
            compress = function() {
                var minNewPts = 50;
                if(clickX.length - compressionIdx < minNewPts)
                    return;
                while(compressionIdx < clickX.length-2) {
                    var skip;
                    for(skip = 1; compressionIdx+skip+1 < clickX.length; skip++) {
                        if(!isWithinSameDrag(compressionIdx, compressionIdx+skip+1)) {
                            skip -= 1;
                            break;
                        }
                        var line = new Line(clickX[compressionIdx], clickY[compressionIdx],
                                            clickX[compressionIdx+skip+1], clickY[compressionIdx+skip+1]);
                        var threshold = clickSize[compressionIdx]/4;
                        var checked;
                        for(checked = 1; checked <= skip; checked++) {
                            var distance = line.distanceFromPt(clickX[compressionIdx+checked], clickY[compressionIdx+checked]);
                            if(distance > threshold) {
                                break;
                            }
                        }
                        if(checked <= skip) {
                            skip = checked-1;
                            break;
                        }
                    }
                    if(skip > 1) {
                        skipPoints(compressionIdx+1, skip);
                        compressionIdx += skip+1;
                    } else {
                        compressionIdx += 1;
                    }
                }
            },
            isWithinSameDrag = function(i, j) {
                return clickSize[i] === clickSize[j] &&
                        clickPeriod[i] === clickPeriod[j] &&
                        clickDrag[i] && clickDrag[j];
            },
            skipPoints = function(from, howMuch) {
                console.log("skipping: " + howMuch);
                clickX.splice(from, howMuch);
                clickY.splice(from, howMuch);
                clickDrag.splice(from, howMuch);
                clickPeriod.splice(from, howMuch);
                clickSize.splice(from, howMuch);
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
            periodToColor = function (period) {
                switch (period) {
                    case "min" :
                        return "rgba(255, 105, 97, " + alphaChannel + ")";
                    case "hour" :
                        return "rgba(244, 154, 194, " + alphaChannel + ")";
                    case "day" :
                        return "rgba(203, 153, 201, " + alphaChannel + ")";
                    case "month" :
                        return "rgba(174, 198, 207, " + alphaChannel + ")";
                    case "year" :
                        return "rgba(119, 158, 203, " + alphaChannel + ")";
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
            setPeriod = function (length) {
                curPeriod = length;
            },
            updateRadius = function (delta) {
                currentRadius = Math.max(1, currentRadius + delta);
            },
            exportAnn = function () {
                var data = {
                    "x": clickX,
                    "y": clickY,
                    "period": clickPeriod,
                    "radius": clickSize,
                    "isDrag": clickDrag
                };
                var jsonData = JSON.stringify(data);
                var request = new XMLHttpRequest();
                var url = "export.php";
                request.open("POST", url, true);
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                request.setRequestHeader("Content-Length", jsonData.length);

                request.onreadystatechange = function () { //Call a function when the state changes.
                    if (request.readyState === 4 && request.status === 200) { // complete and no errors
                        alert(request.responseText); // some processing here, or whatever you want to do with the response
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