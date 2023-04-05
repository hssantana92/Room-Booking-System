<?php


function existingBooking($roomNum, $db){
    $qry = $db->prepare("SELECT DATE_FORMAT(startTime, '%Y-%m-%d %H:%i') AS startTime, DATE_FORMAT(endTime, '%Y-%m-%d %H:%i') AS endTime, username, bookingID, roomNum FROM booking WHERE roomNum = ?");
    $qry->execute([$roomNum]);

    return $qry;
}

?>