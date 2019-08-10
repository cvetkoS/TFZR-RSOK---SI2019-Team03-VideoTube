<?php
class VideoProcessor
{

    private $con;
    private $sizeLimit = 500000000; //calculated in bytes so 0.5gb.
    private $allowedFileTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
    private $ffmpegPath;
    private $ffprobePath;

    //Constructor that initializes con variable along with ffmpeg and ffprobe variables
    //ffmpeg is needed to convert videos from different formats to .mp4
    //ffprobe is needed to generate thumbnails for videos
    public function __construct($con)
    {
        $this->con = $con;
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe");
    }

    public function upload($videoUploadData)
    {

        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->getVideoData();

        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
        //uploads/videos/5aa3e9343c9ffdogs_playing.flv

        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);

        if (!$isValidData) {
            return false;
        }

        if (move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {

            $finalFilePath = $targetDir . uniqid() . ".mp4";

            if (!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "Insert query failed";
                return false;
            }

            if (!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
                echo "Upload failed";
                return false;
            }



            return true;
        }
    }

    private function processData($videoData, $filePath)
    {
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);

        if (!$this->isValidSize($videoData)) {
            echo "File cannot be bigger than " . $this->sizeLimit . " bytes";
            return false;
        } else if (!$this->isValidType($videoType)) {
            echo "Invalid file type";
            return false;
        } else if ($this->hasError($videoData)) {
            echo "Error code: " . $videoData["error"];
            return false;
        }

        return true;
    }

    private function isValidSize($data)
    {
        return $data["size"] <= $this->sizeLimit;
    }

    private function isValidType($type)
    {
        $lovercased = strtolower($type);
        return in_array($lovercased, $this->allowedFileTypes);
    }

    private function hasError($data)
    {
        return $data["error"] != 0;
    }

    private function insertVideoData($uploadData, $filePath)
    {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindValue(":title", $uploadData->getTitle());
        $query->bindValue(":uploadedBy", $uploadData->getUploadedBy());
        $query->bindValue(":description", $uploadData->getDescription());
        $query->bindValue(":privacy", $uploadData->getPrivacy());
        $query->bindValue(":category", $uploadData->getCategory());
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    public function convertVideoToMp4($tempFilePath, $finalFilePath)
    {
        //Command for converting video to mp4
        // 2>&1 outputs errors on the screen
        $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

        //if there is an error it will be in this variable
        $outputLog = array();
        //executing $cmd, $outputLog is where the output is going to go. $returnCode will tell if it was successful or not (0, 1)
        exec($cmd, $outputLog, $returnCode);

        if ($returnCode != 0) {
            //Command failed
            foreach ($outputLog as $line) {
                echo $line . "<br />";
            }
            return false;
        }
        return true;
    }
}
