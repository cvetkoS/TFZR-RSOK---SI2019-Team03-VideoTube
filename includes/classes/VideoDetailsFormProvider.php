<?php
class VideoDetailsFormProvider {
    public function createUploadform() {
        $fileInput = $this->createFileInput();
        return "<form action='processing.php' method='POST'
                    $fileInput
                </form>";
    }

    private function createFileInput() {
     
        return "<div class='form-group'>
            <label for='exampleFormControlFile1'>Your File</label>
            <input type='file' class='form-control-file' id='exampleFormControlFile1' required>
            </div>";
            }
}

?>