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
}
?>