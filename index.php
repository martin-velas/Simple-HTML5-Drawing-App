<!DOCTYPE html>
<html>
  <head>
    <title>Create HTML5 Canvas JavaScript Drawing App Example</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <!--[if IE]><script type="text/javascript" src="excanvas.js"></script><![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="html5-canvas-drawing-app.js"></script>

    <?php
        function random_file_from($dir) {
            $original_dir = getcwd();
            chdir($dir);
            $files = glob('*.*');
            chdir($original_dir);
            $file = array_rand($files);
            return $files[$file];
        }
    
        $data_directory = "images_to_annotate/";
        $image = random_file_from($data_directory);
        session_start();
        $_SESSION["image"] = $image;
        $image_filename = $data_directory . $image;
        $size = getimagesize($image_filename);
        $width = $size[0];
        $height = $size[1];
    ?>
    
    <table style="float:left;">
        <tr><td><div id="canvasDivWithImage"></div></td></tr>
        <tr>
            <td>
                <div id="exportPanel" align="center" class="panel">
                    <button onclick="annotationApp.export()">Finished</button>
                    <div class="hide" id="preloader" align="center"></div>
                </div>
            </td>
        </tr>
    </table>
    
    <div id="controlPanel">
        <table>
            <tr>
                <td>
                    <div class="panel">
                        <p>Object will not be in the scene after:</p>
                        <table id="timeSetter">
                            <?php
                                function getClass($p) {
                                    if($p == "min") {
                                        return "min selected";
                                    } else {
                                        return $p;
                                    }
                                }
                                foreach (["min", "hour", "day", "month", "year"] as $p) {
                            ?>
                                    <tr class="<?php print getClass($p); ?>" onclick="annotationApp.setPeriod('<?php print $p; ?>')">
                                        <td class="palette" width="40px"></td>
                                        <td class="picker"><button>1 <?php print $p; ?></button></td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td><div class="panel"><button onclick="annotationApp.undo(10)">Undo step</button></div></td>
            </tr>
            <tr>
                <td><div class="panel"><button onclick="annotationApp.clear()">Clear all</button></div></td>
            </tr>
            <tr>
                <td>
                    <div class="panel">
                        <table>
                            <tr><td>Marker size:</td></tr>
                            <tr>
                                <td>
                                    <input onchange="annotationApp.updateRadiusTo(this.value)" type="range" min="3" max="80" value="20"/>
                                    <div id="radiusMarker"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <script type="text/javascript">
        ["min", "hour", "day", "month", "year"].forEach(function(p){
            $("#timeSetter tr." + p + " td.palette").css("background-color", annotationApp.periodToColor(p));
        });
    	annotationApp.init(<?php print '"'.$image_filename.'"' . "," . $width . "," . $height; ?>);
    </script>
  </body>
</html>