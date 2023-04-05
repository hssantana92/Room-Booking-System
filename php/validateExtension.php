<?php
// Extension Validator
function validateExtension(&$errArr, &$className, $input, &$value){

    if (strlen($input) == 0){
        $className = "form-control is-invalid";
        $errArr[3] = "Please enter an extension";
    } else if (!is_numeric($input)){
        $className = "form-control is-invalid";
        $errArr[3] = "Must be a number";
    } else if (strlen($input) > 4){
        $className = "form-control is-invalid";
        $errArr[3] = "Extension must not be more than 4 digits";
    } else if (strlen($input) < 4){
        $className = "form-control is-invalid";
        $errArr[3] = "Extension must be 4 digits";
    } else {
        $className = "form-control";
        $errArr[3] = "";
        $value = $input;
    }

}


?>