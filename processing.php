<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");


//uploadButton matches the name in the createUploadButton() function in VideoDetailsFormProvider.php
//if someone went manually to this page, it will show this error.
//User should be accessing this page only when submitting video upload form
if (!isset($_POST["uploadButton"])) {
    echo "No file sent";
    exit();
}

// 1. ------------------Create file upload data
//parameters are name labels from the VideoDetailsFormProvider form
$videoUploadData = new VideoUploadData($_FILES["fileInput"],
                                       $_POST["titleInput"],
                                       $_POST["descriptionInput"],
                                       $_POST["privacyInput"],
                                       $_POST["categoryInput"],
                                       "REPLACE-THIS");

// 2. ------------------Process video data(upload)
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);

// 3. ------------------Check if upload was successful
if($wasSuccessful) {
    echo "Upload successful";
}
?>



<?php require_once("includes/footer.php"); ?>

