<?php
// Username Validator
function validateUsername(&$errArr, &$className, $input, &$value){
    if (strlen($input) == 0){
        $errArr[0] = "Please enter a username";
        $className = "form-control is-invalid";
    } else if (strlen($input) < 5){
        $errArr[0] = "Username must be longer than 4 chars";
        $className = "form-control is-invalid";
    } else {
        $errArr[0] = "";
        $className = "form-control";
        $value = $input;
    }   
}

?>