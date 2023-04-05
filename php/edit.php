<?php
session_start();
require "db.php";

// If form submitted AND user logged in AND user is admin AND room num passed via GET
if (isset($_POST['submit']) && isset($_SESSION['username']) && $_SESSION['accessLevel'] == "admin" && isset($_GET['roomNum'])){


    // Create vars
    $newCapacity = $_POST['newCapacity'];
    $roomNum = $_GET['roomNum'];

    if ($newCapacity > 0 && $newCapacity < 2001){
        

        // Update room capacity
        $qry = $db->prepare("UPDATE room SET capacity=? WHERE roomNum=?");
        $result = $qry->execute([$newCapacity, $_GET['roomNum']]);

/*         if ($result){ // Success, redirect to room page.
            header("Location: ../room.php?roomNum={$_GET['roomNum']}");
            exit;
        } */


    } else {
        header("location:javascript://history.go(-1)");
        exit;
    }

    // Whiteboard was checked
    if (isset($_POST['whiteboard'])){

        $whiteboard  = $_POST['whiteboard'];
        // Update whiteboard bool
        $qry = $db->prepare("UPDATE room SET whiteboard=? WHERE roomNum=?");
        $result = $qry->execute([1, $roomNum]);

    } else { // Check whiteboard value in DB, if true, update to false.
        $qry = $db->prepare("SELECT * FROM room WHERE whiteboard=? AND roomNum=?");
        $result = $qry->execute([1, $roomNum]);

        if ($result){
            $qry = $db->prepare("UPDATE room SET whiteboard=? WHERE roomNum=?");
            $result = $qry->execute([0, $roomNum]); 
        }

    }

    // If Laptop was checked
    if (isset($_POST['laptopConnection'])){
        $laptop = $_POST['laptopConnection'];

        // Update laptop bool
        $qry = $db->prepare("UPDATE room SET laptopConnection=? WHERE roomNum=?");
        $result = $qry->execute([1, $roomNum]);

    } else { // Check laptop value in DB, if true, update to false.
        $qry = $db->prepare("SELECT * FROM room WHERE laptopConnection=? AND roomNum=?");
        $result = $qry->execute([1, $roomNum]);

        if ($result){
            $qry = $db->prepare("UPDATE room SET laptopConnection=? WHERE roomNum=?");
            $result = $qry->execute([0, $roomNum]); 
        }

    }

    // If conference was checked
    if (isset($_POST['teleconference'])){
        $conference = $_POST['teleconference'];

        // Update conference bool
        $qry = $db->prepare("UPDATE room SET teleconference=? WHERE roomNum=?");
        $result = $qry->execute([1, $roomNum]);

    } else { // Check conference value in DB, if true, update to false.
        $qry = $db->prepare("SELECT * FROM room WHERE teleconference=? AND roomNum=?");
        $result = $qry->execute([1, $roomNum]);

        if ($result){
            $qry = $db->prepare("UPDATE room SET teleconference=? WHERE roomNum=?");
            $result = $qry->execute([0, $roomNum]); 
        }

    }

    if (isset($_POST['notes'])){
        $notes = $_POST['notes'];

        // Update notes
        $qry = $db->prepare("UPDATE room SET notes=? WHERE roomNum=?");
        $result = $qry->execute([$notes, $roomNum]);

    }

    header("Location: ../room.php?roomNum={$_GET['roomNum']}");
    exit;


} else { // Form not submitted/ user not logged in / no room number passed. Go back.
    header("location:javascript://history.go(-1)");
    exit;

}




?>