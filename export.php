<?php
    $str_json = file_get_contents('php://input');
    session_start();
    print $_SESSION["image"] . ":" . $str_json;
?>
