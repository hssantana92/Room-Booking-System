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
                            <input type="name" onchange="return validateUsername(this, 'usernameFeedback')" class="form-control" name="username">
                            <div class="invalid-feedback" name="usernameFeedback"/></div>

                            <label for="fName">First Name</label>
                            <input type="name" onchange="return validateName(this, 'nameFeedback')" class="form-control" name="fName">
                            <div class="invalid-feedback" name="nameFeedback"/></div>

                            <label for="surname">Surname</label>
                            <input type="name" onchange="return validateSurname(this, 'surnameFeedback')" class="form-control" name="surname">
                            <div class="invalid-feedback" name="surnameFeedback"/></div>

                            <label for="extNum">Phone Extension</label>
                            <input type="text" pattern="\d{4}" onchange="return validateExtension(this, 'extensionFeedback')" maxlength="4" placeholder="0000" class="form-control" name="extension">
                            <div class="invalid-feedback" name="extensionFeedback"/></div>

                            <label for="passwordInput">Password</label>
                            <input type="password" onchange="return validatePassword(this, 'passwordFeedback')" class="form-control" name="passwordInput">
                            <div class="invalid-feedback" name="passwordFeedback"/></div>

                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" onchange="return validateConfirmPassword(this.parentElement.parentElement, 'confirmFeedback')" class="form-control" name="confirmPassword">
                            <div class="invalid-feedback" name="confirmFeedback"/></div>
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