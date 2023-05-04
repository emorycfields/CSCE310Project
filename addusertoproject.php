<?php 
  $project_id = $_GET['proj_id'];
  $userid = $_GET['userid'];

  include "db_connection.php";
  $user_id = $_GET['user_id'];
    
  $sql = "INSERT INTO `project assignments`(`project_id`, `user_id`) 
          VALUES ('$project_id', '$user_id')";
  
  $result = $conn->query($sql);
  
  if ($result == TRUE) {
    echo "New record created successfully.";
    header("Location: projectdetails.php?userid=$userid&proj_id=$project_id");
  }else{
    echo "Error:". $sql . "<br>". $conn->error;
  }
  $conn->close();
?> 