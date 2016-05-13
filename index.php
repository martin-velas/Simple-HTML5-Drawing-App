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
    
    <table>
        <tr>
            <td>
                <div id="canvasDivWithImage"></div>
            </td>
            <td>
                <div id="timeSetter">
                    <table border="1">
                        <tr class="selected" onclick="annotationApp.setPeriod('min')"><td>1 minute</td></tr>
                        <tr onclick="annotationApp.setPeriod('hour')"><td>1 hour</td></tr>
                        <tr onclick="annotationApp.setPeriod('day')"><td>1 day</td></tr>
                        <tr onclick="annotationApp.setPeriod('month')"><td>1 month</td></tr>
                        <tr onclick="annotationApp.setPeriod('year')"><td>1 year</td></tr>
                    </table>
                </div>
            </td>
            <td>
                <div id="radiusSetter">
                    <table border="1">
                        <tr><td onclick="annotationApp.updateRadius(5)">++ ++</td></tr>
                        <tr><td onclick="annotationApp.updateRadius(-5)">-- --</td></tr>
                    </table>
                </div>
            </td>
            <td onclick="annotationApp.clear()">Clear</td>
        </tr>
    </table>
    <button onclick="annotationApp.export()">Save</button>
    <script type="text/javascript">
    	 annotationApp.init(<?php print '"'.$image_filename.'"' . "," . $width . "," . $height; ?>);
    </script>
  </body>
</html>