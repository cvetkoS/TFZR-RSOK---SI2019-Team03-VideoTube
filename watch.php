<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfoSection.php");
require_once("includes/classes/CommentSection.php");



//taking the value from the URL
if (!isset($_GET["id"])) {
    echo "No URL passed into page";
    exit();
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();
?>

<script src="assets/js/videoPlayerActions.js"></script>
<script src="assets/js/commentActions.js"></script>


<!-- Left section (video player, video details, comment section) -->
<div class="watchLeftColumn">

    <?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true); //autoplay is set to true

    $videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
    echo $videoPlayer->create();

    $commentSection = new CommentSection($con, $video, $userLoggedInObj);
    echo $commentSection->create();

    ?>


</div>

<!-- Right section (suggestions) -->
<div class="suggestions">

</div>


<?php require_once("includes/footer.php"); ?>