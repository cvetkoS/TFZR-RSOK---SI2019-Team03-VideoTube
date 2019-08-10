<?php 

class FormSanitizer { //Sanitizing Form Input
    //Strings
    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","", $inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
    }
    //Username
    public static function sanitizeFormUsername($inputText) { 
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","", $inputText);
        return $inputText;
    }
    //Password
    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }
    //Email
    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","", $inputText);
        return $inputText;
    }
}
?>