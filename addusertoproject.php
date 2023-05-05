<!-- EMORY --> 
<?php 
  $project_id = $_GET['proj_id'];
  $userid = $_GET['userid'];

  include "db_connection.php";
  $user_id = $_GET['user_id'];
  
  // input new project assignment row when a user is added to a project on the project details page
  $sql = "INSERT INTO `project assignments`(`project_id`, `user_id`) 
          VALUES ('$project_id', '$user_id')";
  
  $result = $conn->query($sql);
  
  // navigate back to the projectdetails page
  if ($result == TRUE) {
    header("Location: projectdetails.php?userid=$userid&proj_id=$project_id");
  }
  $conn->close();
?> 