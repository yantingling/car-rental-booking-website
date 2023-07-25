<?php

    $host="localhost";
    $username="root";
    $password="";
    $db="geeklords";

    $connection= mysqli_connect($host, $username, $password, $db);

    if(!$connection)
    {
        die ("Unable to connect: ". mysqli_connect_error());
    }
    
    global $connection;

?>