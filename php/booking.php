<?php
session_start();
require "db.php";
require "existingBooking.php";
require "overlapDateTime.php";
require "validateDate.php";
require "createLog.php";


// If form submitted AND user logged in AND room num passed via GET
if (isset($_POST['submit']) && isset($_SESSION['username']) && isset($_GET['roomNum'])){
    // Create Vars
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $currentTime = time();
    $eID;

    if ($startTime == "" || $endTime == ""){
        // Error found redirect to room page with error id
        $eID = 5;
        header("Location: ../room.php?roomNum={$_GET['roomNum']}&errorID={$eID}");
        exit;
    }

    if (strtotime($startTime) < $currentTime){
        // Error found redirect to room page with error id
        $eID = 7;
        header("Location: ../room.php?roomNum={$_GET['roomNum']}&errorID={$eID}");
        exit;            
    }
    
    if (strtotime($startTime) > strtotime($endTime)){
        // Error found redirect to room page with error id
        $eID = 6;
        header("Location: ../room.php?roomNum={$_GET['roomNum']}&errorID={$eID}");
        exit;        
    }

    if (!validateDate($startTime, $endTime, $eID)){
        // Error found redirect to room page with error id
        header("Location: ../room.php?roomNum={$_GET['roomNum']}&errorID={$eID}");
        exit;
    }

    // Create array of existing bookings
    $bookings = existingBooking($_GET['roomNum'], $db);

    // Validate overlap date/time
    if (overlapDateTime($startTime, $endTime, $bookings)){
        // Insert booking into database
        $qry = $db->prepare("INSERT INTO booking (username, roomNum, startTime, endTime) VALUES (?, ?, ?, ?)");
        $result = $qry->execute([$_SESSION['username'], $_GET['roomNum'], $startTime, $endTime]);

        // Log event
        logEvent($db, "Booking Made", "{$_SESSION['username']} booked {$_GET['roomNum']} from {$startTime} until {$endTime}");

        // Booking inserted, redirect to room page with room num
        header("Location: ../room.php?roomNum={$_GET['roomNum']}");
        exit;


    } else { // Overlap found, redirect back to room page with error ID
        header("Location: ../room.php?roomNum={$_GET['roomNum']}&errorID=1");
        exit;

    }
    


} else { // Form not submitted/ user not logged in / no room number passed. Go back.
    header("location:javascript://history.go(-1)");

}


?>