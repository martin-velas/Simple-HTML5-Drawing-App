<?php
    $str_json = file_get_contents('php://input');
    session_start();
    $image = $_SESSION["image"];
    $data = "{\"image\":\"$image\",\"annotation\":$str_json}\n";
    
    $file = "output/annotations.json";
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
?>
