<?php
require_once("includes/classes/ButtonProvider.php");
    class VideoInfoControls{

        private $video, $userLoggedInObj;
        public function __construct($video, $userLoggedInObj){        
            $this->video = $video;
            $this->userLoggedInObj = $userLoggedInObj;
        }

/* ------------- Creating like/dislike buttons ---------------*/ 

        public function create() {

            $likeButton = $this->createLikeButton();
            $dislikeButton = $this->createDislikeButton();
        
            return "<div class='controls'>
                        $likeButton  
                        $dislikeButton 
                    </div>";
        }
        
        private function createLikeButton(){
            $text = $this->video->getLikes();
            $videoId = $this->video->getId();       //used for actions
            $action = "likeVideo(this, $videoId)";  //this-for button that is pressed
            $class = "likeButton";

            $imageSrc = "assets/images/icons/thumb-up.png";

            if($this->video->wasLikedBy()) {
                $imageSrc = "assets/images/icons/thumb-up-active.png";  
            }

            return ButtonProvider::createButton($text, $imageSrc, $action, $class); //static

        }

        private function createDislikeButton(){
            $text = $this->video->getDislikes();
            $videoId = $this->video->getId();       //used for actions
            $action = "dislikeVideo(this, $videoId)";  //this-for button that is pressed
            $class = "dislikeButton";

            $imageSrc = "assets/images/icons/thumb-down.png";

            if($this->video->wasDislikedBy()) {
                $imageSrc = "assets/images/icons/thumb-down-active.png";  
            }

            return ButtonProvider::createButton($text, $imageSrc, $action, $class); //static
        }
    }
?>