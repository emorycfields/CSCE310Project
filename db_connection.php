<?php
    $servername = "localhost";
    $username = "root";
    $password = "t(Ij1DXiSPW8w*SY";
    $dbname = "schedule"; 
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
        die("Connection Failed" . $conn->connect_error);
    }
?>