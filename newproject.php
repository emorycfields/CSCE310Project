<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $project_name = $_POST['project_name'];
    $start_date = $_POST['start_date'];
    
    $sql = "INSERT INTO `projects`(`user_id`, `project_name`, `start_date`) 
           VALUES ('$user_id', '$project_name','$start_date')";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New project created successfully.";
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  } 
?> 

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
    <h1 align="left"> Create a New Project </h1>  
</head>

<body style="text-align: center;"> 
<form action="projects.php" method="POST">
  <fieldset>
    Project Manager ID:<br>
    <input type="text" name="user_id" >
    <br>
    Project Name:<br>
    <input type="text" name="project_name">
    <br>
    Start Date:<br>
    <input type="date" name="start_date">
    <br> 
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>