<?php require_once("includes/header.php"); ?>

<?php
if(isset($_SESSION["userLoggedIn"])) {
    //userLoggedInObj variable is comming from header.php
    echo "user is logged in as " . $userLoggedInObj->getUsername();
}
else {
    echo "not logged in";
}
?>

<?php require_once("includes/footer.php"); ?>