<!-- This class will hold the data for the video -->
<?php
class VideoUploadData
{
    // These will come from the html form in VideoDetailsFormProvider.php class
    private $videoDataArray; //video data containing the right file format etc.
    private $title;          //video title
    private $description;    //video desc
    private $privacy;        //public or private
    private $category;       //video category
    private $uploadedBy;     //user that uploaded the video

    public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploadedBy)
    {
        $this->videoDataArray = $videoDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->privacy = $privacy;
        $this->category = $category;
        $this->uploadedBy = $uploadedBy;
    }

    public function updateDetails($con, $videoId) {
        $query = $con->prepare("UPDATE videos SET title=:title, description=:description, privacy=:privacy,
                                    category=:category WHERE id=:videoId");
        $query->bindParam(":title", $this->title);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":privacy", $this->privacy);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":videoId", $videoId);

        return $query->execute();

    }

    public function getVideoData()
    {
        return $this->videoDataArray;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrivacy()
    {
        return $this->privacy;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }
}
?>