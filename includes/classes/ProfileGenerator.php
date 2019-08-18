<?php
require_once("ProfileData.php");
class ProfileGenerator {

    private $con, $userLoggedInObj, $profileData;

    public function __construct($con, $userLoggedInObj, $profileUsername) {
        $this->con = $con;
        $this->userLoggedInObjn = $userLoggedInObj;
        $this->profileData = new ProfileData($con, $profileUsername);
    }

    public function create() {
        $profileUsername = $this->profileData->getProfileUsername();
        
        if(!$this->profileData->userExists()) {
            return "User does not exist";
        }

        $coverPhotoSection = $this->createCoverPhotoSection();
        $headerSection = $this->createHeaderSection();
        $tabsSection = $this->createTabsSection();
        $contentSection = $this->createContentSection();
        return "<div class='profileContainer'>
                    $coverPhotoSection
                    $headerSection
                    $tabsSection
                    $contentSection
                </div>";
    }

    public function createCoverPhotoSection() {
        $coverPhotoSrc = $this->profileData->getCoverPhoto();
        $name = $this->profileData->getProfileUserFullName(); //function call
        return "<div class='coverPhotoContainer'>
                    <img src='$coverPhotoSrc' class='coverPhoto'>
                    <span class='channelName'>$name</span>
                </div>";
    }

    public function createHeaderSection() {
         $profileImage = $this->profileData->getProfilePic();
         $name = $this->profileData->getProfileUserFullName();
         $subCount = $this->profileData->getSubscriberCount();

         return "<div class='profileHeader'>
                    <div class='userInfoContainer'>
                        <img class='profileImage' src='$profileImage'>
                        <div class='userInfo'>
                            <span class='title'>$name</span>
                            <span class='subscriberCount'>$subCount subscribers</span>
                        </div>
                    </div>

                    <div class='buttonContainer'>

                    </div>
                </div>";
    }

    public function createTabsSection() {
        
    }

    public function createContentSection() {
        
    }
}
?>