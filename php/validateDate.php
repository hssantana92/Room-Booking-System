<?php

function validateDate($start, $end, &$eID){

    $date = date_parse($start);
    $edate = date_parse($end);

    $warning = "The parsed date was invalid";

    // EID 4 = Both dates invalid
    // EID 3 = End Date invalid
    // EID 2 = Start date invalid
    if (in_array($warning, $date['warnings']) && in_array($warning, $edate['warnings'])){
        echo "test";
        $eID = 4;
        return false;
    } else if (in_array($warning, $edate['warnings'])){
        $eID = 3;
        return false;
    } else if (in_array($warning, $date['warnings'])){
        $eID = 2;
        return false;
    }

    return true;

}

?>