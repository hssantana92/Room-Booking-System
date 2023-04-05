<?php
session_start();
require "db.php";
require "createLog.php";

// If Room ID exists in GET request and username session variable exists AND access level == admin
if (isset($_GET['roomID']) && isset($_SESSION['username']) && $_SESSION['accessLevel'] == "admin"){
    $roomID = $_GET['roomID'];

    // Create Query to select room num
    $qry = $db->prepare("SELECT roomNum FROM room WHERE roomID = ?");
    $qry->execute([$roomID]);
    $roomNum = $qry->fetchColumn();
    echo $roomNum;

    // Delete all from Booking
    $qry = $db->prepare("DELETE FROM booking WHERE roomNum = ?");
    $qry->execute([$roomNum]);
    
    // Create Query
    $qry = $db->prepare("DELETE FROM room WHERE roomID = ?");
    $qry->execute([$roomID]);

    // Log delete event
    logEvent($db, "Room Deleted", "{$roomNum} deleted by {$_SESSION['username']}");


    // If no term was used
    if (isset($_GET['term'])){
        // Redirect to search page with search term
        header("Location: ../search.php?term={$_GET['term']}");
    } else {
        // Redirect to search all page
        header("Location: ../search.php?all=");
    }

    exit;
} else {
    header("location:javascript://history.go(-1)");

}


?>