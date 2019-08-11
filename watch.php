<?php
require_once("includes/header.php");
require_once("includes/classes/Video.php"); 

//taking the value from the URL
if(!isset($_GET["id"])) {
    echo "No URL passed into page";
    exit();
} 

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();
?>



<?php require_once("includes/footer.php"); ?>