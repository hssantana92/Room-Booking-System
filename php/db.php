<?php

require '../../cg.php';

echo $dbname;

try{
    $db = new PDO('mysql:
        host=localhost;
        port=6033;
        dbname='.$dbname,
        $un,$pw);
} catch (PDOException $e){
    echo 'Error connecting to the database server: <br/>';
    echo $e->getMessage();
    exit;
}

?>