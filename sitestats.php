<?php
session_start();
// Import Modules
require "php/db.php";
include "php/siteStats.php";
// Access Level

// If logged in and admin
if (isset($_SESSION['username']) && $_SESSION['accessLevel'] == "admin"){
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
    </nav>


    <!-- MAIN BODY/CONTENT -->
        <div class="container" style="text-align: center;">
                <h1>Room Booking System - <?php echo $_SESSION['accessLevel']; ?> Interface</h1>
                <h3>Welcome, <?php echo $_SESSION['username']; ?>. (<a href="php/logout.php">log out</a>)</h3>

                <div class="card" style="margin-top:30px">
                    <div class="card-header">
                        <h5>Site Statistics</h5>
                    </div>

                    <?php
                    // Run Querys and return results

                    // This functions runs all the necesseary queries to return the desired site stats
                    // Run Site Stats Function and return array into local var
                    $siteStatsArray = siteStats($db);

                    // ARRAY POS OF EACH STAT
                    // $siteStatsArray[0] == Number of Bookings
                    // $siteStatsArray[1] == Number of Rooms
                    // $siteStatsArray[2] == Number of Staff
                    // $siteStatsArray[3] == Number of Admins
                    // $siteStatsArray[4] == Average number of bookings per room
                    // $siteStatsArray[5][0] == Most Bookings by user (USERNAME) // $siteStatsArray[5][2] == Most Bookings by user (COUNT) 

                    ?>

                    <div class="card-body">
                        <strong style="padding:20px">Bookings: </strong><?php echo $siteStatsArray[0]; ?>
                        <strong style="padding:20px">Rooms: </strong><?php echo $siteStatsArray[1]; ?>
                        <strong style="padding:20px">Staff: </strong><?php echo $siteStatsArray[2]; ?>
                        <strong style="padding:20px">Admins: </strong><?php echo $siteStatsArray[3]; ?>
                        </br></br>
                        <p>
                            <strong style="padding:20px">Average Bookings per room: </strong><?php echo $siteStatsArray[4]; ?>
                        </p>
                        <p>
                            <strong style="padding:20px">Most Bookings: </strong><?php echo $siteStatsArray[5][0]; ?> (<?php echo $siteStatsArray[5][2]; ?> bookings)
                        </p>
                    </div>
                </div>
                

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