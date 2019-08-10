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

            if (!$this->deleteFIle($tempFilePath)) {
                echo "Upload failed";
                return false;
            }

            if (!$this->generateThumbnails($finalFilePath)) {
                echo "Upload failed - Could not generate thumbnails\n";
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

    private function deleteFile($filePath) {
        //unlink function deletes a file at the provided location
        if(!unlink($filePath)) {
            echo "Could not delete filse\n";
            return false;
        }

        return true;
    }

    public function generateThumbnails($filePath) {
        $thumbnailSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";
        
        $duration = $this->getVideoDuration($filePath);

        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration, $videoId);

        for($num = 1; $num <=$numThumbnails; $num++) {
            $imageName = uniqid() . ".jpg";
            $interval = ($duration * 0.8) / $numThumbnails * $num;
            /* ($duration * 0.8) ignores first few seconds from the beginning and end of the video */
            $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";

            $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

            $outputLog = array();
            exec($cmd, $outputLog, $returnCode);

            if($returnCode != 0) {
                //Command failed
                foreach($outputLog as $line) {
                    echo $line . "<br />";
                }
            }
            $selected = $num == 1 ? 1 : 0;

            $query = $this->con->prepare("INSERT INTO thumbnails(videoId, filePath, selected)
                                        VALUES(:videoId, :filePath, :selected)");
            $query->bindParam(":videoId", $videoId);
            $query->bindParam(":filePath", $fullThumbnailPath);
            $query->bindParam(":selected", $selected);

            $success = $query->execute();

            if(!$success) {
                echo "Error inserting thumbnail \n";
                return false;
            }
        }
        return true;
    }

    private function getVideoDuration($filePath) {
        return (int)shell_exec("$this->ffprobePath -v error -select_streams v:0 -show_entries stream=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    private function updateDuration($duration, $videoId) {
        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours/3600)) / 60); //takes away all hours that are in.
        $secs = floor($duration % 60); //moduo, all that's left from the duration

        $hours = ($hours < 1) ? "" : $hours . ":";
        $mins = ($hours < 10) ? "0" . $mins . ":" : $mins . ":"; //if less then 10 secs append 0 in front
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $duration = $hours.$mins.$secs;

        $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");

        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);

        $query->execute();
    }
}
