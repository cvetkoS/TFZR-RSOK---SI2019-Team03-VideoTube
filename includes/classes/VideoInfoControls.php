<?php
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
            return "<button>Like</button>";
        }

        private function createDislikeButton(){
            return "<button>Dislike</button>";
        }
    }
?>