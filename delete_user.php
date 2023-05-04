<?php 

include "db_connection.php";
  $user_id = $_GET['userid'];
  $delete_user = $_GET['todelete'];
  //if (isset($_POST['submit'])) {
    
    
    $sql = "DELETE FROM `Users` WHERE `userid`='" .$delete_user. "'";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record deleted successfully.";
      if ($user_id == $delete_user) {
        header("Location: login.php");
      } else {
        header("Location: users.php?userid=$user_id");
      }
      
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  //}

?> 

