<?php
// Surname Validator
function validateSurname(&$errArr, &$className, $input, &$value){

    if (strlen($input) == 0){
        $className = "form-control is-invalid";
        $errArr[2] = "Please enter a surname";
    } else if (strlen($input) > 50){
        $className = "form-control is-invalid";
        $errArr[2] = "Surname must not be more than 50 chars";
    } else {
        $className = "form-control";
        $errArr[2] = "";
        $value = $input;
    }
}

?>