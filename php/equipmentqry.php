<?php


function equipmentSearch(&$qry, &$searchText, &$db, $room){

    if ($room != ""){
        $qryString = "SELECT * FROM room WHERE roomNum LIKE ?";
    } else {
        $qryString = "SELECT * FROM room";
    }

    // If any of the equipment options where selected, create query and execute. If not, execute base query.
    if (isset($_GET['whiteboard']) || isset($_GET['laptop']) || isset($_GET['teleconference'])){
        $whiteboard = $laptop = $teleconference = "";
        $selections = $qryArr = array();

        if ($room == ""){ // Search ALL query, append WHERE to query
            $qry = $qryString . " WHERE ";

        } else { // Search TERM query, append AND to query, and add room to execute array
            $qry = $qryString . " AND ";
            $qryArr[] = $room;
        }
            
        // Check if any equipment was checked and set vars
    
        // If whiteboard was selected, insert into query.
        if (isset($_GET['whiteboard'])){
            $whiteboard = $_GET['whiteboard'];
    
            $qry .= "whiteboard = ? ";
            $qryArr[] = $whiteboard;
            $selections[] = "Whiteboard";
        }
        
        // If laptop was selected, insert into query.
        if (isset($_GET['laptop'])){
            $laptop = $_GET['laptop'];
            
    
            if (str_contains($qry, "whiteboard")){
                $qry .= "AND laptopConnection = ? ";
            } else {
                $qry .= "laptopConnection = ? ";
            }

            $qryArr[] = $laptop;
            $selections[] = "Laptop Connection";
        }
        
        // If teleconfence was selected, insert into query
        if (isset($_GET['teleconference'])){
            $teleconference = $_GET['teleconference'];
            if (str_contains($qry, "laptop") || str_contains($qry, "whiteboard")){
                $qry .= "AND teleconference = ? ";
            } else {
                $qry .= "teleconference = ? ";
            }
            $qryArr[] = $teleconference;
            $selections[] = "Teleconference System";
    
        }
        $qry = $db->prepare($qry);
        $qry->execute($qryArr);
    
        // Split array into string seperated by ", & "
        $selections = implode(", & ", $selections);
    
        $searchText .= " {$qry->rowCount()} room(s) found containing {$selections}";
        
    } else {
        // Else just select everything from the room table
        $qry = $db->query($qryString);
        if ($room == ""){
            $qry = $db->query($qryString);
        } else {
            $qry = $db->prepare($qryString);
            $qry->execute([$room]);
        }
        $searchText .= " {$qry->rowCount()} rooms found.";
        
    }
}




?>