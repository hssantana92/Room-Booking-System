<?php
session_start();
// Import Modules
require "php/db.php";
include "php/equipmentqry.php";

function str_contains(string $ogstring, string $contains){
    return empty($contains) || strpos($ogstring, $contains) !== false;
}



// If user logged in AND submit key OR all key exists display page, else return to index.
if ($_SESSION['username'] && (isset($_GET['term']) || isset($_GET['all']))){


        ?>

            <!DOCTYPE html>
            <html lang="en" class="h-100">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="css/bootstrap.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

                <script>
                    function confirmCancel(element, term){       
                        
                        // Get parent element
                        var parent = element.parentElement;

                        // Get element ID
                        var elementID = element.name.slice(10, element.name.length);

                        // Remove cancel link
                        element.remove();

                        var html = "";

                        // Enable Are you sure - yes/no link
                        if (term === ""){
                            html = "<strong>Are you sure?</strong> <a href='php/delete.php?roomID=" + elementID + "'>Yes</a> / <a href=''>No</a>";
                        } else {
                            html = "<strong>Are you sure?</strong> <a href='php/delete.php?roomID=" + elementID + "&term=" + term + "'>Yes</a> / <a href=''>No</a>";
                        }


                        parent.insertAdjacentHTML("beforeend", html);

                        // Stop page refresh
                        return false;
                        
                    }
                </script>

            </head>
            <style>

            </style>

            <body class="d-flex flex-column h-100">

            <!-- HEADER/NAV -->
                <nav style="text-align:center; background:#343a40">
                    <a class="navbar-brand" style="text-align:center" href="#">
                        <img src="img/logo.png" height="100" class="d-inline-block align-center" alt="">
                    </a>
                </nav>

                <!-- MAIN BODY/CONTENT -->
                    <div class="container" style="text-align: center;">
                            <h1>Room Booking System - <?php echo $_SESSION['accessLevel']; ?> Interface</h1>
                            <h3>Welcome, <?php echo $_SESSION['username']; ?>. (<a href="php/logout.php">log out</a>)</h3>
            
                            <!-- SEARCH RESULTS -->
                            <div class="container" style="text-align:left; width:500; padding-top: 20px;">
                                <div class="card">


                                    <?php
                                
                                    // Init qry var
                                    $qry;

                                    // IF SEARCH ALL 
                                    if (isset($_GET['all'])){


                                        // Set base card header
                                        $searchText = "Search all results.";
                                        
                                        // Check if any equipment checkboxes were checked. If so the function runs the appropriate query
                                        equipmentSearch($qry, $searchText, $db, "");

                                        
                                        ?>

                                        <h5 class="card-header"><?php echo $searchText; ?></h5>
                                        <div class="card-body">

                                        <?php
                                        
                                        // If rooms exists
                                        if ($qry->rowCount()){

                                            $term = "";

                                            // If logged in as admin show delete and edit link
                                            if ($_SESSION['accessLevel'] == "admin"){
                                                foreach ($qry as $row){
                                                    ?>
                                                    <p class='card-text'><strong><?php echo $row['roomNum']; ?></strong> - <a href='room.php?roomNum=<?php echo $row['roomNum']; ?>'>View/Book</a> - <a href='room.php?roomNum=<?php echo $row['roomNum']; ?>&edit=yes'>Edit</a> - <a name='deleteLink<?php echo $row['roomID']; ?>' onclick='return confirmCancel(this, "<?php echo $term; ?>")' href=''>Delete</a></p>
                                                <?php
                                                
                                                }
                                            } else { // Logged in as staff - only display View/Book link
                                                foreach ($qry as $row){
                                                    echo "<p class='card-text'><strong>{$row['roomNum']}</strong> - <a href='room.php?roomNum={$row['roomNum']}'>View/Book</a></p>";
                                                }
                                            }

                                        } else { // Else display no rooms exist message
                                            echo "<p class='card-text'>No rooms exist in database</p>";
                                        }

                                    // Else SEARCH TERM USED 
                                    } else if (isset($_GET['term'])){

                                        
                                        $room = trim($_GET['term']);

                                        $term = (string) $_GET['term'];

                                    
                                        // If room is blank, return to interface.
                                        if (!$room){
                                            header("Location: interface.php");
                                        }
                                        
                                        // Create room search variable.
                                        $room = "%{$room}%";

                                        // Init card search text
                                        $searchText = "Search for '{$term}' results.";

                                        // Check if any of the equipment checkboxes were ticked.
                                        // Define and execute query
                                        equipmentSearch($qry, $searchText, $db, $room);


                                        ?>

                                        <!-- <h5 class="card-header">Search for "<?php //echo $_GET['term']; ?>" returned <?php //echo $qry->rowCount(); ?> results</h5> -->
                                        <h5 class="card-header"><?php echo $searchText; ?></h5>
                                        <div class="card-body">

                                        <?php

                                        // If room(s) exist
                                        if ($qry->rowCount()){

                                            // If logged in as admin, display edit and delete link
                                            if ($_SESSION['accessLevel'] == "admin"){
                                                foreach ($qry as $row){
                                                    ?>
                                                        <p class='card-text'><strong><?php echo $row['roomNum']; ?></strong> - <a href='room.php?roomNum=<?php echo $row['roomNum']; ?>'>View/Book</a> - <a href='room.php?roomNum=<?php echo $row['roomNum']; ?>&edit=yes'>Edit</a> - <a name='deleteLink<?php echo $row['roomID']; ?>' onclick='return confirmCancel(this, "<?php echo $term; ?>")' href=''>Delete</a></p>
                                                    <?php
                                                }
                                            } else { // Logged in as staff. Only display View/Book link
                                                foreach ($qry as $row){
                                                    echo "<p class='card-text'><strong>{$row['roomNum']}</strong> - <a href='room.php?roomNum={$row['roomNum']}'>View/Book</a></p>";
                                                }
                                            }


                                        } else {
                                            // Else display no rooms exist message
                                            echo "<p class='card-text'>No rooms exist in database</p>";
                                        }                                        

                                    }

                                    ?>
                                    </div>
                                </div>
                            </div>
                            <a href="interface.php">Back</a>
                    </div>
                <!-- END MAIN BODY/CONTENT -->

                <!-- FOOTER -->
                <footer class="footer mt-auto py-3 bg-dark">
                    <div class="container">
                    <span class="text-light">Santana 2022</span>
                    </div>
                </footer>
            </body>
            </html>


        <?php

    } else {
        // Redirect to index
        header("Location: index.php");
    }


?>

