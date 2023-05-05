<?php 

  include "db_connection.php";
  $user_id = $_GET['todelete'];
  $proj_id = $_GET['proj_id'];
  $userid = $_GET['userid'];
  
  $sql = "DELETE FROM `project assignments` WHERE `user_id`= $user_id and `project_id` = $proj_id LIMIT 1";
  
  $result = $conn->query($sql);
  
  if ($result == TRUE) {
    echo "New record deleted successfully.";
    header("Location: projectdetails.php?proj_id=$proj_id&userid=$userid");
  }else{
    echo "Error:". $sql . "<br>". $conn->error;
  }
  $conn->close();
?> 