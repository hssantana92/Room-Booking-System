<?php
require "db.php";

// Define Log function
function logEvent($db, $eventType, $eventDetails){

    $qry = $db->prepare("INSERT INTO log (ip_address, event_type, event_details) VALUES (?, ?, ?)");
    $qry->execute([$_SERVER['REMOTE_ADDR'], $eventType, $eventDetails]);

}






?>