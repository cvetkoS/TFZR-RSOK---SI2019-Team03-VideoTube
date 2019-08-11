<?php
class VideoPlayer {

    //object of the video class
    private $video;
    public function __construct($video)
    {
        $this->video = $video;
    }

    public function create($autoPlay) {
        if($autoPlay) {
            $autoPlay = "autoplay";
        } else {
            $autoPlay = "";
        }

        $filePath = $this->video->getfilePath();
        return "<video class='videoPlayer' controls $autoPlay>
                    <source src='$filePath' type='video/mp4'>
                    Your browser does not support the .mp4 video format
                </video>";
    }
}

?>