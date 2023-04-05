<?php
function validateConfirmPassword(&$errArr, &$className, $inputCP, $input, &$value){
    // Create shortcut var

    if ($input != $inputCP){
        $className = "form-control is-invalid";
        $errArr[5] = "Passwords do not match";
        $value = "";           
    } else if (strlen($inputCP) == 0){
        $className = "form-control is-invalid";
        $errArr[5] = "Please confirm password";
        $value = "";        
    } else if (strlen($inputCP) < 5){
        $className = "form-control is-invalid";
        $errArr[5] = "Password must be more than 4 chars";
        $value = "";        
    } else {
        $className = "form-control";
        $errArr[5] = "";
        $value = $inputCP;
    }

}

?>