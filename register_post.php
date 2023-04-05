<?php
// Import functions
require "php/db.php";
require "php/createLog.php";
require "php/validatePassword.php";
require "php/validateUsername.php";
require "php/validateName.php";
require "php/validateSurname.php";
require "php/validateExtension.php";
require "php/validateConfirmPassword.php";

// Init vars
$inputClassCP = $inputClassEX = $inputClassSN = $inputClassFN = $inputClassUN = $inputClassPW = "form-control";
$inputCP = $inputEX = $inputSN = $inputFN = $inputUN = $inputPW = "";
$errorMessages = array_fill(0,6, "");


// If post key exists
if (isset($_POST['submit'])) {
    
    // Create shortcut vars
    $username = $_POST['username'];
    $fname = $_POST['fName'];
    $surname = $_POST['surname'];
    $extension = $_POST['extension'];

    // Run passwords through hash
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
    
    // Check user doesnt already exist
    $qry = $db->prepare("SELECT * FROM user WHERE username = ?");
    $result = $qry->execute([$username]);
    $count = $qry->rowCount();

    if ($count > 0){
        // Set Username error and invalid class
        $errorMessages[0] = "Username already exists. Please choose another username.";
        $inputClassUN = "form-control is-invalid";

    }

    // If error array is empty, and user doesn't already exist. Insert user into database and re-direct to login page.
    if (count(array_filter($errorMessages)) == 0 && $count == 0){

        // Hash Password
        $pword = password_hash($pword, PASSWORD_DEFAULT);

        // Insert user into database
        $qry = $db->prepare("INSERT INTO user (username, firstName, surname, extension, password, accessLevel) VALUES (?,?,?,?,?,?)");
        $result = $qry->execute([$username, $fname, $surname, $extension, $pword, "staff"]);

        if ($result){
            // Log user registration
            logEvent($db, "Registration", "{$username} registered");
            header("Location: index.php?register=true");

        }
    } 
    // Else registration page will be displayed with error messages and pre-filled information for valid fields.




}



?>


<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="js/validateUsername.js"></script>
    <script src="js/validateName.js"></script>
    <script src="js/validateSurname.js"></script>
    <script src="js/validateExtension.js"></script>
    <script src="js/validatePassword.js"></script>
    <script src="js/validateConfirmPassword.js"></script>
    <script src="js/validateForm.js"></script>

</head>
<style>

</style>

<body class="d-flex flex-column h-100">

<!-- HEADER/NAV -->
        <nav style="text-align:center; background:#343a40">
            <a class="navbar-brand" style="text-align:center" href="#">
                <img src="img/logo.png" height="100" class="d-inline-block align-center" alt="">
            </a>
        </nav>

    <!-- MAIN BODY/CONTENT -->
        <div class="container" style="text-align: center;">
                <a href="javascript:history.back()"><label><i class="bi bi-arrow-return-left"></i> Go Back</label></a>
                <h1>Registration Form</h1>
                <h3>Please fill out the following details</h3>
                
                <!-- LOGIN FORM -->
                <div class="container" style="text-align:left; width:300px; padding-top:25px;">
                    <form method="POST" name="registerForm" onsubmit="return validateForm(this)" action="register_post.php">
                        <div class="form-group">
                            <label for="userName">Username</label>
                            <input type="name" onchange="return validateUsername(this, 'usernameFeedback')" class="<?php echo $inputClassUN;?>" value="<?php echo $inputUN;?>" name="username">
                            <div class="invalid-feedback" name="usernameFeedback"/>
                                <?php echo $errorMessages[0];?>
                            </div>

                            <label for="fName">First Name</label>
                            <input type="name" onchange="return validateName(this, 'nameFeedback')" class="<?php echo $inputClassFN;?>" value="<?php echo $inputFN;?>" name="fName">
                            <div class="invalid-feedback" name="nameFeedback"/>
                                <?php echo $errorMessages[4];?>
                            </div>

                            <label for="surname">Surname</label>
                            <input type="name" onchange="return validateSurname(this, 'surnameFeedback')" class="<?php echo $inputClassSN;?>" value="<?php echo $inputSN;?>" name="surname">
                            <div class="invalid-feedback" name="surnameFeedback"/>
                                <?php echo $errorMessages[2];?>
                            </div>

                            <label for="extNum">Phone Extension</label>
                            <input type="text" pattern="\d{4}" onchange="return validateExtension(this, 'extensionFeedback')" maxlength="4" placeholder="0000" class="<?php echo $inputClassEX;?>" value="<?php echo $inputEX;?>" name="extension">
                            <div class="invalid-feedback" name="extensionFeedback"/>
                                <?php echo $errorMessages[3];?>
                            </div>

                            <label for="passwordInput">Password</label>
                            <input type="password" onchange="return validatePassword(this, 'passwordFeedback')" class="<?php echo $inputClassPW;?>" value="<?php echo $inputPW;?>" name="passwordInput">
                            <div class="invalid-feedback" name="passwordFeedback"/>
                                <?php echo $errorMessages[1];?>
                            </div>

                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" onchange="return validateConfirmPassword(this.parentElement.parentElement, 'confirmFeedback')" class="<?php echo $inputClassCP;?>" value="<?php echo $inputCP;?>" name="confirmPassword">
                            <div class="invalid-feedback" name="confirmFeedback"/>
                                <?php echo $errorMessages[5];?>
                            </div>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary"/></div>
                    </form>
                </div>
        </div>
    <!-- END MAIN BODY/CONTENT -->

    <!-- FOOTER -->
    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
        <span class="text-light">Santana 2022</span>
        </div>
    </footer>
</body>
</html>