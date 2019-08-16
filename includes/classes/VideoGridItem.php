<?php
class VideoGridItem
{
    private $video, $largeMode;

    public function __construct($video, $largeMode)
    {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }
    public function create()
    {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $url = "watch.php?id=" . $this->video->getId();

        return "<a href='$url'>
                    <div class='videoGridItem'>
                        $thumbnail
                        $details
                        </div>
                    </a>";
    }

    private function createThumbnail()
    {
        $thumbnail = $this->video->getThumbnail();
        $duration = $this->video->getDuration();

        return "<div class='thumbnail'>
                    <img src='$thumbnail'>
                    <div class = 'duraation'>
                        <span>$duration</span>
                    </div>
                </div>";
    }
    private function createDetails()
    {
        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $views = $this->video->getViews();
        $description = $this->video->getDescription();
        $timestamp = $this->video->getTimeStamp();

        return "<div class='details'>
                    <h3 class='title'>$title</h3>
                    <span class='username'>$username</span>
                    <div class='status'>
                        <span class='viewCount'>$views - </span>
                        <span class='timeStamp'>$timestamp</span>
                    </div>
                    $description
                </div>";
    }
}
