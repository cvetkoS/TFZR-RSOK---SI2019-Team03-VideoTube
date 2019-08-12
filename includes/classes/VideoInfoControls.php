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

            return ButtonProvider::createButton($text, $imageSrc, $action, $class); //static

        }

        private function createDislikeButton(){
            return "<button>Dislike</button>";
        }
    }
?>