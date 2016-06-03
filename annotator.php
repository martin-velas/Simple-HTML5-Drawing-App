<?php header("Content-Type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic objects annotator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
  </head>
  <body>
    <!--[if IE]><script type="text/javascript" src="excanvas.js"></script><![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="html5-canvas-drawing-app.js"></script>

    <?php
        if(!isset($_GET["lang"])) {
            $lang = "en";
        } else {
            $lang = $_GET["lang"];
        }
        
        $dictionary = array(
            "sk" => array(
                "title" => "Prosím, označte objekty, ktoré pravdepodobne zo scény zmiznú za",
                "min" => "minútu",
                "hour" => "hodinu",
                "day" => "ďeň",
                "month" => "mesiac",
                "year" => "rok alebo neskôr",
                "marker-size" => "Veľkosť štetca",
                "undo" => "Vráť posledný ťah",
                "clear" => "Vymaž všetko",
                "done" => "Hotovo"
            ), 
            "en" => array(
                "title" => "Please mark all the objects that are likely to disappear from the scene before",
                "min" => "minute",
                "hour" => "hour",
                "day" => "day",
                "month" => "month",
                "year" => "year or longer",
                "marker-size" => "Marker size",
                "undo" => "Undo step",
                "clear" => "Clear all",
                "done" => "Finished"
            )
        );
    
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
                <table>
                    <tr>
                        <td>
                            <a href="?lang=en" title="English"><img width="30" src="en_flag.png"></a>
                            <a href="?lang=sk" title="Slovensky"><img width="30" src="sk_flag.png"></a>
                        </td>
                    </tr>
                    <tr><td><div id="canvasDivWithImage"></div></td></tr>
                    <tr>
                        <td>
                            <div id="exportPanel" align="center" class="panel">
                                <button onclick="annotationApp.export()"><?php print($dictionary[$lang]["done"]); ?></button>
                                <div class="hide" id="preloader" align="center"></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <div id="controlPanel">
                    <table>
                        <tr>
                            <td>
                                <div class="panel">
                                    <p><?php print($dictionary[$lang]["title"]); ?>:</p>
                                    <table id="timeSetter">
                                        <?php
                                            function getClass($p) {
                                                if($p == "min") {
                                                    return "min selected";
                                                } else {
                                                    return $p;
                                                }
                                            }

                                            function getButtonTitle($p) {
                                                if($p == "erase") {
                                                    return "Erase";
                                                } else if($p == "min") {
                                                    return "1 minute";
                                                } else {
                                                    return "1 " . $p;
                                                }
                                            }

                                            foreach (array("min", "hour", "day", "month", "year"/*, "erase"*/) as $p) {
                                        ?>
                                                <tr class="<?php print getClass($p); ?>" onclick="annotationApp.setPeriod('<?php print $p; ?>')">
                                                    <td class="palette" width="40px"></td>
                                                    <td class="picker"><button><?php print $dictionary[$lang][$p]; ?></button></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="panel">
                                    <table>
                                        <tr><td><?php print $dictionary[$lang]["marker-size"]; ?></td></tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <?php
                                                foreach (array("Tiny", "Small", "Normal", "Big") as $scale) {
                                                ?>
                                                    <td>
                                                        <div id="radiusMarker<?php print $scale; ?>" 
                                                             onclick="annotationApp.updateRadiusTo('<?php print $scale; ?>')">
                                                        </div>
                                                    </td>
                                                <?php
                                                }
                                            ?>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="panel"><button onclick="annotationApp.undo(10)"><?php print $dictionary[$lang]["undo"]; ?></button></div></td>
                        </tr>
                        <tr>
                            <td><div class="panel"><button onclick="annotationApp.clear()"><?php print $dictionary[$lang]["clear"]; ?></button></div></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        ["min", "hour", "day", "month", "year"].forEach(function(p){
            $("#timeSetter tr." + p + " td.palette").css("background-color", annotationApp.periodToColor(p));
        });
    	annotationApp.init(<?php print '"'.$image_filename.'"' . "," . $width . "," . $height; ?>);
    </script>
  </body>
</html>