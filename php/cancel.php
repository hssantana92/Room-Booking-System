<?php
session_start();
require "db.php";
require "createLog.php";

// If Booking ID exists in GET request and username session variable exists
if (isset($_GET['bookingID']) && isset($_SESSION['username'])){
    $bookingID = $_GET['bookingID'];


    // TODO (Optional) HANDLE INVALID GETBOOKINGID
    // Select booking details for event log
    $booking = $db->prepare("SELECT * FROM booking WHERE bookingID = ?");
    $booking->execute([$bookingID]);
    $booking = $booking->fetch(); // Return single row

    if (isset($booking['bookingID'])){
        $startTime = $booking['startTime'];
        $endTime = $booking['endTime'];
        $roomNum = $booking['roomNum'];
    } else {
        header("location:javascript://history.go(-1)");
        exit;
    }


    // If admin, delete ANY booking where booking ID provided
    if ($_SESSION['accessLevel'] == "admin"){
        // Create Query
        $qry = $db->prepare("DELETE FROM booking WHERE bookingID = ?");
        $qry->execute([$bookingID]);

        // Log event
        logEvent($db, "Booking Cancelled", "{$_SESSION['username']} cancelled a booking for {$roomNum} from {$startTime} until {$endTime}");

        // Redirect to interface.php
        header("Location: ../interface.php");

        exit;
    } else { // Else delete booking where booking id and username matches
        $qry = $db->prepare("DELETE FROM booking WHERE bookingID = ? AND username = ?");
        $qry->execute([$bookingID, $_SESSION['username']]);

        // Log event
        logEvent($db, "Booking Cancelled", "{$_SESSION['username']} cancelled a booking for {$roomNum} from {$startTime} until {$endTime}");

        // Redirect to interface.php
        header("Location: ../interface.php");

        exit;        
    } 

} else {
    header("location:javascript://history.go(-1)");
    exit;
}


?>