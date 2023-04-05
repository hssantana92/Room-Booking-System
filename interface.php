<?php
session_start();
// Import Modules
require "php/db.php";
// Access Level

// If logged in
if (isset($_SESSION['username'])){
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- SCRIPT HERE -->
    <script>
        function confirmCancel(element){
            
            // Get parent element
            var parent = element.parentElement;

            // Get element ID
            var elementID = element.name.slice(10, element.name.length);

            // Remove cancel link
            element.remove();

            // Enable Are you sure - yes/no link
            let html = "<strong>Are you sure?</strong> <a href='php/cancel.php?bookingID=" + elementID + "'>Yes</a> / <a href=''>No</a>";

            parent.insertAdjacentHTML("beforeend", html);

            // Stop page refresh
            return false;
            
        }


        function getInput(element){
            var hiddenElement;

            if (element.name == "whiteboard"){
                hiddenElement = document.getElementById("hiddenWB");
            } else if (element.name == "laptop"){
                hiddenElement = document.getElementById("hiddenLT");
            } else {
                hiddenElement = document.getElementById("hiddenTS");
            }

            if (element.checked){
                hiddenElement.value = 1;
                hiddenElement.removeAttribute("disabled");
            } else {
                hiddenElement.value = 0;
                hiddenElement.disabled = "disabled";
            }
        }
    </script>

</head>
<style>

</style>

<body class="d-flex flex-column h-100">
<?php

// If Room successfuly inserted, show success message
if (isset($_GET['add']) && $_SESSION['accessLevel'] == "admin" && $_GET['add'] == "true"){
   
    //echo "<script>alert('Success! Room successfuly added')</script>";

    ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Room successfully added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
  
}

?>


<!-- HEADER/NAV -->
    <nav style="text-align:center; background:#343a40">
        <a class="navbar-brand" style="text-align:center" href="#">
            <img src="img/logo.png" height="100" class="d-inline-block align-center" alt="">
        </a>
        
        <?php 
        if ($_SESSION['accessLevel'] == "admin"){
        ?>
       
        <ul class="nav justify-content-center bg-light">
            <li class="nav-item">
                <a class="nav-link active" href="interface.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logs.php">Event Log</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sitestats.php">Site Stats</a>
            </li>
        </ul>
        
        <?php
        }
        ?>
    </nav>


    <!-- MAIN BODY/CONTENT -->
        <div class="container" style="text-align: center;">
                <h1>Room Booking System - <?php echo $_SESSION['accessLevel']; ?> Interface</h1>
                <h3>Welcome, <?php echo $_SESSION['username']; ?>. (<a href="php/logout.php">log out</a>)</h3>
                
                <!-- SEARCH TERM FORM / BUTTON -->
                <div class="container" style="text-align:left; width:500; padding-top:50px;">
                    <form method="GET" name="roomSearch" style="display:inline;" action="search.php">
                        <div class="form-group">
                            <label for="term">Search</label>
                            <input type="text" class="form-control" name="term">
                            <input type="hidden" value="1" disabled="disabled" id="hiddenWB" name="whiteboard"/>
                            <input type="hidden" value="1" disabled="disabled" id="hiddenLT" name="laptop" />
                            <input type="hidden" value="1" disabled="disabled" id="hiddenTS" name="teleconference" />

                        </div>
                            <input type="submit" value="Submit" class="btn btn-primary"/>                        
                    </form>

                    <!-- SEARCH ALL ROOMS & EQUIPMENT DROP DOWN -->
                    <form method="GET" name="allSearch" style="display:inline;" action="search.php">
                        <input type="hidden" name="all" value="all"/>
                        <input type="submit" value="Search all rooms" class="btn btn-primary"/>
                        
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Equipment Search
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <label style="padding-left:22px;"><input type="checkbox" onchange="getInput(this)" name="whiteboard" value="1"/> Whiteboard</label></br>
                                        <label style="padding-left:22px;"><input type="checkbox" onchange="getInput(this)" name="laptop" value="1"> Laptop Connection</label></br>
                                        <label style="padding-left:22px;"><input type="checkbox" onchange="getInput(this)" name="teleconference" value="1"/> Teleconferencing System</label></br>
                                    </div>
                                </div>
                    </form>

                    <?php 
                            // If user is admin, show add room button
                            if ($_SESSION['accessLevel'] == "admin"){

                                ?>

                                <a href="add.php" value="add" class="btn btn-info">Add Room</a>

                                <?php
                            }
                            ?>
                </div>
                
                
                            <?php 

                                // If admin account display ALL bookings 
                                if ($_SESSION['accessLevel'] == "admin"){
                                    echo "<div class='container' style='text-align:left; width:500; padding-top: 20px;'>";
                                    echo "<div class='card'>";
                                    echo "<h5 class='card-header'>My Upcoming Bookings</h5>";
                                    echo "<div class='card-body'>";

                                    $qry = $db->prepare("SELECT * FROM booking WHERE username = ? AND endTime > CURRENT_TIMESTAMP ORDER BY startTime");
                                    $qry->execute([$_SESSION['username']]);
                                    
                                    // If bookings exist iteratre through returned array and display each booking with a cancel link
                                    if ($qry->rowCount()){
                                        foreach ($qry as $row){
                                            echo "<p class='card-text'><strong>{$row['startTime']} - {$row['endTime']}, Room {$row['roomNum']} - </strong><a href='' type='button' name='cancelLink{$row['bookingID']}' onclick='return confirmCancel(this)'>Cancel</a></p>";
                                        }
                                    } else {
                                        // Else display no bookings messages
                                        echo "<p class='card-text'>No upcoming bookings</p>";
                                    }


                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class='container' style='text-align:left; width:500; padding-top: 20px;'>";
                                    echo "<div class='card'>";
                                    echo "<h5 class='card-header'>All Other Bookings</h5>";
                                    echo "<div class='card-body'>";
                                    $qry = $db->prepare("SELECT * FROM booking WHERE NOT username = ? AND endTime > CURRENT_TIMESTAMP ORDER BY startTime");
                                    $qry->execute([$_SESSION['username']]);
                                    
                                    // If bookings exist iteratre through returned array and display each booking with a cancel link
                                    if ($qry->rowCount()){
                                        foreach ($qry as $row){
                                            echo "<p class='card-text'><strong>{$row['startTime']} - {$row['endTime']}, Room {$row['roomNum']} - </strong><a href='' type='button' name='cancelLink{$row['bookingID']}' onclick='return confirmCancel(this)'>Cancel</a></p>";
                                        }
                                    } else {
                                        // Else display no bookings messages
                                        echo "<p class='card-text'>No upcoming bookings</p>";
                                    }

                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    
                                } else { // Else only display USER bookings if staff account
                                    echo "<div class='container' style='text-align:left; width:500; padding-top: 20px;'>";
                                    echo "<div class='card'>";
                                    echo "<h5 class='card-header'>My Upcoming Bookings</h5>";
                                    echo "<div class='card-body'>";

                                    // SQL Query
                                    $qry = $db->prepare("SELECT * FROM booking WHERE username = ? AND endTime > CURRENT_TIMESTAMP ORDER BY startTime");
                                    $qry->execute([$_SESSION['username']]);
                                    
                                    // If bookings exist iteratre through returned array and display each booking with a cancel link
                                    if ($qry->rowCount()){
                                        foreach ($qry as $row){
                                            echo "<p class='card-text'><strong>{$row['startTime']} - {$row['endTime']}, Room {$row['roomNum']} - </strong><a href='' type='button' name='cancelLink{$row['bookingID']}' onclick='return confirmCancel(this)'>Cancel</a></p>";
                                        }
                                    } else {
                                        // Else display no bookings messages
                                        echo "<p class='card-text'>No upcoming bookings</p>";
                                    }

                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            ?>
        </div>
    <!-- END MAIN BODY/CONTENT -->

    <!-- FOOTER -->
    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
        <span class="text-light">Santana 2022</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php
} else {
    // Redirect to index page
    header("Location: index.php");
    exit;
}
?>