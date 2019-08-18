<?php
class ProfileData {

    private $con, $profileUserObj;

    public function __construct($con, $profileUsername) {
        $this->con = $con;        
        $this->profileUserObj = new User($con, $profileUsername);
    }

    public function getProfileUsername() {
        return $this->profileUserObj->getUserName();
    }

    public function userExists() {
        $profileUsername = $this->getProfileUsername();
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(":username", $profileUsername);
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function getCoverPhoto() {
        return "assets/images/coverPhotos/default-cover-photo.jpg";   
    }
}
?>