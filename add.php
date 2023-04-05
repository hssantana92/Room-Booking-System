<?php
session_start();
require "php/db.php";

// Check if user is admin/logged in
if (isset($_SESSION['username']) && $_SESSION['accessLevel'] == "admin"){



    $capacityClass = $roomNameClass = "form-control";
    $errorMessages = ["",""];

    // If error ID retrieved via GET, update error messages
    if (isset($_GET['errorID'])){

        $errorID = $_GET['errorID'];

        if ($errorID == 3){
            $errorMessages[0] = "Room name must not be blank";
            $roomNameClass = "form-control is-invalid";
        } else if ($errorID == 2){
            $errorMessages[1] = "Capacity must be between 1 and 500";
            $capacityClass = "form-control is-invalid";
        } else if ($errorID == 4){
            $errorMessages[0] = "Room name already taken. Please try again";
            $roomNameClass = "form-control is-invalid";

        } else {
            $errorMessages[0] = "Room name must not be blank";
            $errorMessages[1] = "Capacity must be between 1 and 500";

            $roomNameClass = "form-control is-invalid";
            $capacityClass = "form-control is-invalid";
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

    
        <!-- VALIDATION -->
        <script>
    
    
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
            <h1>Room Booking System - <?php echo $_SESSION['accessLevel']; ?> Interface</h1>
            <h3>Welcome, <?php echo $_SESSION['username']; ?>. (<a href="php/logout.php">log out</a>)</h3>
    
    
            <!-- NEW ROOM -->       
            <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                <div class="card">
                    <h5 class="card-header">Add New Room</h5>
                    <div class="card-body">
    
                            <!-- ROOM OPTIONS/VALUES FORM -->     
                            <form method="POST" name="add" action="php/addRoom.php">
                                <div class="form-group">
                                    <label for="roomName">Room Name</label>
                                    <input type="name" style="width:300px;" required="true" class="<?php echo $roomNameClass; ?>" name="roomName">
    
                                    <div class="invalid-feedback" name="roomNameFeedback"/>
                                        <?php echo $errorMessages[0];?>
                                    </div>
    
                                    <label for="capacity">Capacity</label>
                                    <input type="number" required="true" style="width:100px;" class="<?php echo $capacityClass; ?>" name="capacity" min="0" max="500"/>

                                    <label><input type="checkbox" name="whiteboard" value="1"/> Whiteboard</label></br>
                                    <label><input type="checkbox" name="laptop" value="1"> Laptop Connection</label></br>
                                    <label><input type="checkbox" name="teleconference" value="1"/> Teleconferencing System</label></br>

                                    <!-- Notes -->
                                    <label for="notes" class="col-form-label"><strong>Notes:</strong></label>
                                    <textarea class="form-control" name="notes" rows="2"></textarea>

                                    <!-- Error Message -->
                                    <div class="invalid-feedback" name="capacityFeedback"/>
                                        <?php echo $errorMessages[1];?>
                                    </div>
    
                                </div>
                                    <input type="submit" name="submit" class="btn btn-primary"/>
                            </form>
                    </div>
                </div>
            </div>
            <a href="javascript:history.back()">Back</a>
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
<?php


} else {
    // Redirect to index page
    header("Location: index.php");
    exit;
}



