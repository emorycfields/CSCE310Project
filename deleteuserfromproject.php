<!-- EMORY -->
<?php 

  include "db_connection.php";
  $user_id = $_GET['todelete'];
  $proj_id = $_GET['proj_id'];
  $userid = $_GET['userid'];
  
  // delete the corresponding assignment from the project assignments table
  $sql = "DELETE FROM `project assignments` WHERE `user_id`= $user_id and `project_id` = $proj_id LIMIT 1";
  
  $result = $conn->query($sql);
  
  // navigate back to the projectdetails page
  if ($result == TRUE) {
    header("Location: projectdetails.php?proj_id=$proj_id&userid=$userid");
  }
  $conn->close();
?> 