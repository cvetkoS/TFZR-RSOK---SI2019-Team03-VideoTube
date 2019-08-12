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
            return ButtonProvider::createButton("Like", "", "", ""); //static
        }

        private function createDislikeButton(){
            return "<button>Dislike</button>";
        }
    }
?>