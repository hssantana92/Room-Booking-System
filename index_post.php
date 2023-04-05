<?php
session_start();
// Import functions
require "php/validatePassword.php";
require "php/validateUsername.php";
require "php/db.php";
require "php/createLog.php";

// Init vars
$inputClassUN = $inputClassPW = "form-control";
$inputUN = $inputPW = "";
$errorMessages = ["", "", ""];

// Check if already logged in, if so, re-direct to interface page.
if (isset($_SESSION['username'])){
    header("Location: interface.php");
}


// If submit key exists
if (isset($_POST['submit'])) {
    
    // Store inputs in variables
    // Run password through hash
    $pword = $_POST['passwordInput'];
    $username = $_POST['username'];

    // Validate Username
    validateUsername($errorMessages, $inputClassUN, $username, $inputUN);

    // Validate Password
    validatePassword($errorMessages, $inputClassPW, $pword, $inputPW);
    
    // Validate user exists/login credentials
    // Prepare SQL Statement
    $qry = $db->prepare("SELECT * FROM user WHERE username = ?");
    $qry->execute([$username]);
    $user = $qry->fetch();

    // If user was found
    if ($user && password_verify($pword, $user['password'])){
        // Set session vars
        $_SESSION['username'] = $user['username'];
        $_SESSION['accessLevel'] = $user['accessLevel'];

        // Log event
        logEvent($db, "Login", "{$username} logged in");

        // Redirect
        header("Location: interface.php");

        exit;
    
    } else {
        // Else display error message
        $errorMessages[2] = "Invalid login credentials. Please try again.";

        // Log failed login attempt
        logEvent($db, "Login Attempt", "Failed login with username {$username}");
    }

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
    <script src="js/validatePassword.js"></script>

    <!-- VALIDATION -->
    <script>

        // Run both validators and return false if either are invalid
        function validateForm(form){
            // Validate Username
            var username = validateUsername(form.username, 'usernameFeedback');

            // Validate Password
            var password = validatePassword(form.passwordInput, 'passwordFeedback');

            if (username == false || password == false){
                return false;
            }

        }

    </script>

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
                <h1>Welcome to the Room Booking System</h1>
                <h3>Login below, or <a href="register.php">register</a> a new staff account</h3>
                
                <!-- LOGIN FORM -->
                <div class="container" style="text-align:left; width:300px; padding-top:50px;">
                    <form method="POST" name="loginForm" onsubmit="return validateForm(this)" action="index_post.php">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="name" onchange="return validateUsername(this, 'usernameFeedback')" class="<?php echo $inputClassUN;?>" name="username" value="<?php echo $inputUN;?>">
                            <div class="invalid-feedback" name="usernameFeedback"/>
                                <?php echo $errorMessages[0];?>
                            </div>

                            <label for="passwordInput">Password</label>
                            <input type="password" onchange="return validatePassword(this, 'passwordFeedback')" class="<?php echo $inputClassPW;?>" name="passwordInput" value="<?php echo $inputPW;?>">
                            <div class="invalid-feedback" name="passwordFeedback">
                                <?php echo $errorMessages[1];?>
                            </div>
                        </div>
                        <div class="invalid-feedback <?php if ($errorMessages != "") { echo 'd-block';} ?>" name="loginFeedback">
                                <?php echo $errorMessages[2];?>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary"/></div>
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