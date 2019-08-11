<?php require_once("includes/header.php"); 

//taking the value from the URL
if(!isset($_GET["id"])) {
    echo "No URL passed into page";
    exit();
} 

?>



<?php require_once("includes/footer.php"); ?>