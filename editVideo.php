<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/SelectThumbnail.php");

if(!User::isLoggedIn()){
    header("Location: signIn.php");
}

/*prvobitno je pisalo videoId ali se ne poklapa sa klasom Video
 pa je moralo da se menja u samom URL-u u videoId, da ne bi stranica davala gresku
 da je nedefinisano*/

if(!isset($_GET["videoid"])) {
    echo "No video selected";
    exit();
}

$video = new Video($con, $_GET["videoid"], $userLoggedInObj);
if($video->getUploadedBy() !=$userLoggedInObj->getUsername()) {
    echo "Not your video";
    exit();
}

if(isset($_POST["saveButton"])) {
    $videoData = new VideoUpdateData(    
        null,                      //from VideoUploadData constructor
        $_POST["titleInput"],
        $_POST["descriptionInput"],
        $_POST["privacyInput"],
        $_POST["categoryInput"],
        $userLoggedInObj->getUsername()
    );

    if($videoData->updateDetails($con, $videoId)) {
        $detailsMessage = "<div class='alert alert-success'>
                            <strong>SUCCESS!</strong> Details updated successfully!
                            </div>";                            
    }
    else {    
        $detailsMessage = "<div class='alert alert-danger'>
                            <strong>ERROR!</strong> Something went wrong
                            </div>";   
    }
}
?>
<script src="assets/js/editVideoActions.js"></script>
<div class="editVideoContainer column">

    <div class="topSection">
       <?php
       $videoPlayer = new VideoPlayer($video);
       echo $videoPlayer->create(false);

       $selectThumbnail = new SelectThumbnail($con, $video);
       echo $selectThumbnail->create();       
       ?>
    </div>

    <div class="bottomSection">
        <?php
        $formProvider = new VideoDetailsFormProvider($con);
        echo $formProvider->createEditDetailsForm($video);
        ?>
    </div>

</div>