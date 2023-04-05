<?php
session_start();
// Import Modules
require "php/db.php";
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
                <a class="nav-link" href="interface.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="logs.php">Event Log</a>
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
                        <h5>Event Log</h5>
                    </div>

                    <?php
                
                    // Run query to return all events
                    $qry = $db->query("SELECT * FROM log ");

                    ?>

                    <div >
                    <div class="container" style="background:#343a40; color:white; padding-bottom:0;">
                                <div class="row g-0">

                                    <div class="col-sm" style="text-align:left">
                                        <strong>DATE</strong>
                                    </div>

                                    <div class="col-sm" style="text-align:left">
                                        <strong>IP ADDRESS</strong>
                                    </div>

                                    <div class="col-sm" style="text-align:left">
                                    <strong>EVENT TYPE</strong>
                                    </div>

                                    <div class="col-5" style="text-align:left">
                                        <strong>EVENT DESCRIPTION</strong>
                                    </div>
                                </div>
                            </div>


                        <?php
                        foreach($qry as $row){
                            ?>

                            <div class="container">
                                <div class="row g-0">

                                    <div class="col-sm" style="text-align:left">
                                        <strong><?php echo $row['log_date']; ?></strong>
                                    </div>

                                    <div class="col-sm" style="text-align:left">
                                        <strong><?php echo $row['ip_address']; ?></strong>
                                    </div>

                                    <div class="col-sm" style="text-align:left">
                                    <strong><?php echo $row['event_type']; ?></strong>
                                    </div>

                                    <div class="col-5" style="text-align:left">
                                        <?php echo $row['event_details']; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }

                        ?>
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