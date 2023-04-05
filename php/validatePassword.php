<?php
// Password Validator
function validatePassword(&$errArr, &$className, $input, &$value){
    if (strlen($input) == 0){
        $errArr[1] = "Please enter a password";
        $className = "form-control is-invalid";
    } else if (strlen($input) < 5){
        $errArr[1] = "Password must be longer than 4 chars";
        $className = "form-control is-invalid";
    } else {
        $errArr[1] = "";
        $className = "form-control";
        $value = $input;
    } 
}

?>