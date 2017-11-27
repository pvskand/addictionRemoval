<?php
    

/*
    This is an example file. Put in your crendentials here.
*/

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "addictionRemoval";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


?>
