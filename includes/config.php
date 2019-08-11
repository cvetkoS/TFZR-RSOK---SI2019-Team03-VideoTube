<?php
ob_start(); //Turns on output buffering
session_start();

date_default_timezone_set("Europe/Belgrade");

try {
    $con = new PDO("mysql:dbname=VideoTube;host=localhost", "root", ""); //Connection to the Database
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Error handling and error output
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>