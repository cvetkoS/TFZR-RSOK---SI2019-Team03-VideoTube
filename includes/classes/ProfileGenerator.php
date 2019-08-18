<?php
class ProfileGenerator {

    private $con, $userLoggedInObj, $profileUsername;

    public function __construct($con, $userLoggedInObj, $profileUsername) {
        $this->con = $con;
        $this->userLoggedInObjn = $userLoggedInObj;
        $this->profileUsername = $profileUsername;
    }

    public function create() {

    }
}
?>