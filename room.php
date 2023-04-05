<?php
session_start();
// Import Modules
require "php/db.php";

// If user logged in AND submit key OR all key exists display page, else return to index.
if ($_SESSION['username'] && isset($_GET['roomNum'])){

    // Init error message array
    $errorMessages = ["","", ""];

    $startTimeClass = "form-control";
    $endTimeClass = "form-control";
    $noteClass = $capacityClass = "form-control";

    // If error id is retrieved via GET
    if (isset($_GET['errorID'])){

        // #1 == Overlap exists 
        // Edit error array and change start time field class
        if ($_GET['errorID'] == 1) {
            $errorMessages[0] = "Overlap exists. Booking not made.";        
        }

        if ($_GET['errorID'] == 2) {
            $errorMessages[1] = "Enter a valid start datetime";
            $startTimeClass = "form-control is-invalid";       
        }

        if ($_GET['errorID'] == 3) {
            $errorMessages[2] = "Enter a valid end datetime";
            $endTimeClass = "form-control is-invalid";         
        }

        if ($_GET['errorID'] == 4) {
            $errorMessages[1] = "Enter a valid start datetime";
            $errorMessages[2] = "Enter a valid end datetime";
            $startTimeClass = "fomr-control is-invalid";
            $endTimeClass = "form-control is-invalid";         
        }

        if ($_GET['errorID'] == 5) {
            $errorMessages[0] = "Field must not be blank";        
        }

        if ($_GET['errorID'] == 6) {
            $errorMessages[0] = "Start time must not be greater than end time";        
        }

        if ($_GET['errorID'] == 7) {
            $errorMessages[0] = "Start time must not be before current time.";        
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

                <script>
                    function confirmCancel(element, term){
            
                        // Get parent element
                        var parent = element.parentElement;

                        // Get element ID
                        var elementID = element.name.slice(10, element.name.length);

                        // Remove cancel link
                        element.remove();

                        // Enable Are you sure - yes/no link
                        let html = "<strong>Are you sure?</strong> <a href='php/delete.php?roomID=" + elementID + "&term=" + term + "'>Yes</a> / <a href=''>No</a>";

                        parent.insertAdjacentHTML("beforeend", html);

                        // Stop page refresh
                        return false;
                        
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
                            <h1>Room Booking System - <?php echo $_SESSION['accessLevel']; ?> Interface</h1>
                            <h3>Welcome, <?php echo $_SESSION['username']; ?>. (<a href="php/logout.php">log out</a>)</h3>


                                <?php 

                                // Get Room details
                                $qry = $db->prepare("SELECT * FROM room WHERE roomNum = ?");
                                $qry->execute([$_GET['roomNum']]);
                                $result = $qry->fetch();

                                if ($result){ // If valid room ID, show room details, booking form, and existing room bookings.         

                                    // If edit data was sent with URL AND user is admin, display edit form.
                                    if (isset($_GET['edit']) && $_GET['edit'] == "yes" && $_SESSION['accessLevel'] == "admin"){

                                        ?>
                                        <!-- ROOM DETAILS & EDIT -->
                                        <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                                            <div class="card">
                                                <h5 class="card-header">Details of <?php echo $result['roomNum']; ?></h5>
                                                <div class="card-body">
        
                                                    <!-- Edit Capacity -->
                                                    <form method="POST" name="editRoom" action="php/edit.php?roomNum=<?php echo $result['roomNum'] ?>">
                                                            <div class="form-group row">
                                                                <label for="capacity" class="col-form-label" style="padding-left: 15px;"><strong>Capacity:</strong></label>
                                                                <div class="col-auto">
                                                                    <input type="number" required="true" style="width: 100px;" class="<?php echo $capacityClass; ?>" value="<?php echo $result['capacity'];?>" name="newCapacity" min="0" max="1000"/>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Whiteboard -->
                                                            <div class="form-group row">
                                                                <label for="capacity" class="form-check-label" style="padding-right: 15px; padding-left: 15px;"><strong>Whiteboard:</strong></label>
                                                                <div class="col-auto">
                                                                    <input class="form-check-input" type="checkbox" name="whiteboard" 
                                                                    <?php echo ($result['whiteboard']) ? "checked" : ""; ?>
                                                                    >
                                                                </div>
                                                            </div>

                                                            <!-- Laptop Connection -->
                                                            <div class="form-group row">
                                                                <label for="capacity" class="form-check-label" style="padding-right: 15px; padding-left: 15px;"><strong>Laptop Connection:</strong></label>
                                                                <div class="col-auto">
                                                                    <input class="form-check-input" type="checkbox" value="1" name="laptopConnection" 
                                                                    <?php echo ($result['laptopConnection']) ? "checked" : ""; ?>
                                                                    >
                                                                </div>
                                                            </div>

                                                            <!-- Teleconferencing -->
                                                            <div class="form-group row">
                                                                <label for="capacity" class="form-check-label" style="padding-right: 15px; padding-left: 15px;"><strong>Teleconferencing System:</strong></label>
                                                                <div class="col-auto">
                                                                    <input class="form-check-input" type="checkbox" name="teleconference" 
                                                                    <?php echo ($result['teleconference']) ? "checked" : ""; ?>
                                                                    >
                                                                </div>
                                                            </div>

                                                            <!-- Notes -->
                                                            <div class="form-group row">
                                                                <label for="notes" class="col-form-label" style="padding-left: 15px;"><strong>Notes:</strong></label>
                                                                <div class="col-auto">
                                                                    <textarea class="<?php echo $noteClass; ?>" name="notes" rows="2"><?php echo $result['notes'];?></textarea>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <input type="submit" name="submit" value="Edit" class="btn btn-primary"/>
                                                                <a class="btn btn-primary" href="room.php?roomNum=<?php echo $result['roomNum']; ?>">Cancel</a>
                                                            </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
        
                                        <?php
        
        
                                        } else { // Only display capacity
    
                                            ?>
        
                                            <!-- ROOM DETAILS ONLY -->
                                            <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                                                <div class="card">
                                                    <h5 class="card-header">Details of <?php echo $result['roomNum']; ?></h5>
                                                    <div class="card-body">

                                                        
                                                        <!-- Whiteboard -->
                                                        <p class='card-text'><strong>Capacity:</strong> <?php echo $result['capacity']; ?></p>

                                                        <!-- Whiteboard -->
                                                        <p class='card-text'><strong>Whiteboard:</strong> <?php echo ($result['whiteboard']) ? "Yes" : "No"; ?></p>

                                                        <!-- Laptop Connection -->
                                                        <p class='card-text'><strong>Laptop Connection:</strong> <?php echo ($result['laptopConnection']) ? "Yes" : "No"; ?></p>

                                                        <!-- Teleconference -->
                                                        <p class='card-text'><strong>Teleconferencing System:</strong> <?php echo ($result['teleconference']) ? "Yes" : "No"; ?></p>

                                                        <!-- Notes -->
                                                        <p class='card-text'><strong>Notes: </strong><?php echo $result['notes']; ?></p>

                                                        <?php

                                                        if ($_SESSION['accessLevel'] == "admin"){
                                                            // Display Edit Button
                                                            ?>

                                                            <a class="btn btn-primary" href="room.php?roomNum=<?php echo $result['roomNum']; ?>&edit=yes">Edit</a>

                                                            <?php
                                                            

                                                        }             
                                                        ?>


                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php
        
                                        }   
                                        ?> 
                            


                                <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                                    <div class="card">
                                        <h5 class="card-header">New Booking for <?php echo $result['roomNum']; ?></h5>
                                        <div class="card-body">
                                        <?php 
                                            // SQL 
                                            
                                            
                                        ?>
                                        <!-- NEW BOOKING -->
                                                <form method="POST" name="booking" action="php/booking.php?roomNum=<?php echo $result['roomNum'] ?>">
                                                    <div class="form-group">
                                                        <label for="startTime">Start Time</label>
                                                        <input type="datetime-local" style="width: 250px;" class="<?php echo $startTimeClass; ?>" name="startTime">

                                                        <div class="invalid-feedback" name="startTimeFeedback"/>
                                                            <?php echo $errorMessages[1];?>
                                                        </div>

                                                        <label for="endTime">End Time</label>
                                                        <input type="datetime-local" style="width: 250px;" class="<?php echo $endTimeClass; ?>" name="endTime">

                                                        <div class="invalid-feedback" name="endTimeFeedback"/>
                                                            <?php echo $errorMessages[0];?>
                                                        </div>

                                                        <div class="invalid-feedback <?php if ($errorMessages[0] != "") { echo 'd-block';} ?>" name="overlapFeedback">
                                                            <?php echo $errorMessages[0];?>
                                                        </div>

                                                    </div>
                                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary"/>
                                                </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                                    <div class="card">
                                        <h5 class="card-header">Upcoming Bookings for <?php echo $result['roomNum']; ?></h5>
                                        <div class="card-body">
                                        <?php 
                                            // Query database to select all bookings from the booking table where a room number matches.
                                            $bookingQry = $db->prepare("SELECT * FROM booking WHERE roomNum = ? AND endTime > CURRENT_TIMESTAMP ORDER BY startTime");
                                            $bookingQry->execute([$result['roomNum']]);

                                            if ($bookingQry->rowCount()){
                                                foreach($bookingQry as $row){
                                                    echo "<p class='card-text'>{$row['startTime']} - {$row['endTime']}, {$row['username']}</p>";                                                
                                                }
                                            } else {
                                                echo "<p class='card-text'>No upcoming bookings for this room</p>";
                                            }
                                            
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                } else { // Invalid room number
                                    echo "<p>Invalid room number</p>";
                                }
                                ?>
                            <a href="interface.php">Home</a>
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
        // Redirect to index
        header("Location: index.php");
    }


?>

