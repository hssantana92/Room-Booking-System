<?php
function overlapDateTime($start, $end, &$existingBookings){
    $startB = strtotime($start);
    $endB = strtotime($end);
    
    // DEBUG: $count = 0;

    // Loop through existing bookings
    foreach ($existingBookings as $row){
        // DEBUG: echo "</br> Count: {$count} </br>";
        // DEBUG: $count++;

        $startA = strtotime($row['startTime']);
        $endA = strtotime($row['endTime']);

        // DEBUG: echo "</br>LOGIC: </br> Start A: {$startA} <= End B {$endB} </br> End A: {$endA} > {$startB} </br>";

        // Overlap Logic - (StartA <= EndB) and (EndA >= StartB)
        if (($startA <= $endB) && ($endA >= $startB)){
            // If true return false (i.e. overlap exists)
            // DEBUG: echo "<strong>Overlap Found </strong> </br>";
            return false;
        } 
        
    }

    // No overlap exists, return true
    return true;
    

}
?>