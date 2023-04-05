<?php
// Name Validator
function validateName(&$errArr, &$className, $input, &$value){

    if (strlen($input) == 0){
        $className = "form-control is-invalid";
        $errArr[4] = "Please enter a first name";
    } else if (strlen($input) > 50){
        $className = "form-control is-invalid";
        $errArr[4] = "First Name must not be more than 50 chars";
    } else {
        $className = "form-control";
        $errArr[4] = "";
        $value = $input;
    }
}

?>