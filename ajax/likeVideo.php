<?php
require_once("../includes/config.php"); //../because config.php isn't in the ajax folder
require_once("../includes/classes/Video.php");
require_once("../includes/classes/User.php");

$username = $_SESSION["userLoggedIn"];
$videoId = $_POST["videoId"];

$userLoggedInObj = new User($con, $username);
$video = new Video($con, $videoId, $userLoggedInObj);

echo $video->like();

?>