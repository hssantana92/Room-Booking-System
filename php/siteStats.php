<?php


function siteStats(&$db){
    
    // Init array
    $siteStatsArray = array();
    
    // Return number of bookings
    $qry = $db->query("SELECT COUNT(bookingID) FROM booking");
    $siteStatsArray[] = $qry->fetchColumn();

    // Return number of rooms
    $qry = $db->query("SELECT COUNT(roomID) FROM room");
    $siteStatsArray[] = $qry->fetchColumn();

    // Return number of staff
    $qry = $db->query("SELECT COUNT(userID) FROM user WHERE accessLevel = 'staff'");
    $siteStatsArray[] = $qry->fetchColumn();

    // Return number of admins
    $qry = $db->query("SELECT COUNT(userID) FROM user WHERE accessLevel = 'admin'");
    $siteStatsArray[] = $qry->fetchColumn();

    // Average number of bookings per room
    $qry = $db->query("SELECT ROUND(AVG(roomCount)) AS roomAverage
    FROM 	(SELECT COUNT(*) AS roomCount FROM booking
            GROUP BY roomNum) AS countQuery");
    $siteStatsArray[] = $qry->fetchColumn();

    // Return most bookings by user
    $qry = $db->query("SELECT CONCAT(firstName, ' ', surname) AS name, booking.username, COUNT(*) AS bookingCount FROM booking INNER JOIN user ON booking.username = user.username GROUP BY username ORDER BY bookingCount DESC LIMIT 1");
    $siteStatsArray[] = $qry->fetch();

    return $siteStatsArray;

}

?>