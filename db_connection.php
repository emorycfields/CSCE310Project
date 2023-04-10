
<?php
/*function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "t(Ij1DXiSPW8w*SY";
 $db = "schedule";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   */
    $servername = "localhost";
    $username = "root";
    $password = "t(Ij1DXiSPW8w*SY";
    $dbname = "schedule"; 
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
        die("Connection Failed" . $conn->connect_error);
    }
?>


    