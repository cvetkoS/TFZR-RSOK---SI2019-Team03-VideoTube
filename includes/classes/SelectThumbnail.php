<?php
class SelectThumbnail {
 
    private $con, $video;

    public function __construct($con, $video) {
        $this->con = $con;
        $this->video = $video;
    }

    public function create() {
        $thumbnailData = $this->getThumbnailData();
    }

    private function getThumbnailData(){
        $data = array();

        $videoId = $this->video->getId();
        $query = $this->con->prepare("SELECT * FROM thumbnails WHERE videoId=:videoId");
        $query->bindParam(":videoId", $videoId);
        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}
?>