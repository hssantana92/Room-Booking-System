<?php
session_start();
require "db.php";
require "createLog.php";

// If form submitted AND user logged in AND user is admin
if (isset($_POST['submit']) && isset($_SESSION['username']) && $_SESSION['accessLevel'] == "admin"){

    // Create vars

    $roomName = $_POST['roomName'];
    $capacity = $_POST['capacity'];
    $whiteboard = $laptop = $teleconference = 0;
    $notes = "";

    // Check to see if checkboxes were used and notes were inserted. If not, set vars to false (0) values and an empty string.
    if (isset($_POST['whiteboard'])){
        $whiteboard = $_POST['whiteboard'];
    } 

    if (isset($_POST['laptop'])){
        $laptop = $_POST['laptop'];
    } 

    if (isset($_POST['teleconference'])){
        $teleconference = $_POST['teleconference'];
    } 

    if (isset($_POST['whiteboard'])){
        $whiteboard = $_POST['whiteboard'];
    } 

    if (isset($_POST['notes'])){
        $notes = $_POST['notes'];
    } 



    $eID;

    // Validate Form
    if (($capacity < 1 || $capacity > 500) && $roomName == ""){
        $eID = 1;

        // Redirect to add room form with error ID
        header("Location: ../add.php?errorID={$eID}");
        exit;

    } else if ($capacity < 1 || $capacity > 500){
        $eID = 2;
        
        // Redirect to add room form with error ID
        header("Location: ../add.php?errorID={$eID}");
        exit;
        
    } else if ($roomName == "") {
        $eID = 3;
        
        // Redirect to add room form with error ID
        header("Location: ../add.php?errorID={$eID}");
        exit;
        
    }

    // Basic Validation Passed. Now check if room name already exists.

    $qry = $db->prepare("SELECT * FROM room WHERE roomNum = ?");
    $qry->execute([$roomName]);
    $count = $qry->rowCount();
    
    // If query returns a row, room exists, redirect to add room page with error id.
    if ($count == 1){
        $eID = 4;
        header("Location: ../add.php?errorID={$eID}");
        exit;
    } else {
        // Insert into database
        $qry = $db->prepare("INSERT INTO room (roomNum, capacity, whiteboard, laptopConnection, teleconference, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $qry->execute([$roomName, $capacity, $whiteboard, $laptop, $teleconference, $notes]);

        // Redirect to interface page with success message
        if ($result){
            // Log add room event
            logEvent($db, "Room Added", "{$roomName} added by {$_SESSION['username']}");

            header("Location: ../interface.php?add=true");
            exit;
        }
        
        exit;

    }







} else { // Form not submitted/ user not logged in / no room number passed. Go back.
    header("location:javascript://history.go(-1)");
    exit;

}




?>