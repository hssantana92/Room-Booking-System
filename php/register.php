<?php
// Import functions
require "php/db.php";
require "php/validatePassword.php";
require "php/validateUsername.php";
require "php/validateName.php";
require "php/validateSurname.php";
require "php/validateExtension.php";
require "php/validateConfirmPassword.php";

// If post key exists
if (isset($_POST['submit'])) {
    
    // Create shortcut vars
    $username = $_POST['username'];
    $fname = $_POST['fName'];
    $surname = $_POST['surname'];
    $extension = $_POST['extension'];
    $pword = $_POST['passwordInput'];
    $cpword = $_POST['confirmPassword'];

    // Validate Username [0]
    validateUsername($errorMessages, $inputClassUN, $username, $inputUN);

    // Validate Password [1]
    validatePassword($errorMessages, $inputClassPW, $pword, $inputPW);

    // Validate First Name [4]
    validateName($errorMessages, $inputClassFN, $fname, $inputFN);

    // Validate Surname [2]
    validateSurname($errorMessages, $inputClassSN, $surname, $inputSN);

    // Validate Extension [3]
    validateExtension($errorMessages, $inputClassEX, $extension, $inputEX);

    // Validate Confirm [5]
    validateConfirmPassword($errorMessages, $inputClassCP, $cpword, $pword, $inputCP);
    
    // Validate user doesnt already exist
    // DB CODE GOES HERE
    echo count(array_filter($errorMessages));

    // If error array is empty, and user doesn't already exist. Insert user into database and re-direct to login page.
    if (count(array_filter($errorMessages)) == 0){
        header("Location: index.php");
    }
    // Else registration page will be displayed with error messages and pre-filled information for valid fields.
}


    ?>