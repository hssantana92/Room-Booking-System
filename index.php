<?php
session_start();

// Check if already logged in, if so, re-direct to interface page.
if (isset($_SESSION['username'])){
    header("Location: interface.php");
}

if (isset($_GET['register']) && $_GET['register'] == "true"){
    echo '<script>alert("User successfully registered!")</script>';
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
                <h3>Login below, or <a href="register.php">register</a>  a new staff account</h3>
                
                <!-- LOGIN FORM -->
                <div class="container" style="text-align:left; width:300px; padding-top:50px;">
                    <form method="POST" name="loginForm" onsubmit="return validateForm(this)" action="index_post.php">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="name" onchange="return validateUsername(this, 'usernameFeedback')" class="form-control" name="username">
                            <div class="invalid-feedback" name="usernameFeedback"/></div>

                            <label for="passwordInput">Password</label>
                            <input type="password" onchange="return validatePassword(this, 'passwordFeedback')" class="form-control" name="passwordInput">
                            <div class="invalid-feedback" name="passwordFeedback">
                            </div>
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