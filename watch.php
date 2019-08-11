<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php"); 


//taking the value from the URL
if(!isset($_GET["id"])) {
    echo "No URL passed into page";
    exit();
} 

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();
?>

<!-- Left section (video player, video details, comment section) -->
<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true); //autoplay is set to true
?>


</div>

<!-- Right section (suggestions) -->
<div class="suggestions">
    
</div>


<?php require_once("includes/footer.php"); ?>