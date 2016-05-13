<?php
    $str_json = file_get_contents('php://input');
    session_start();
    $image = $_SESSION["image"];
    //print strlen($str_json);
?>
