<!-- EMORY -->
<!-- This file allows users to add a new project to the database --> 
<?php 

  include "db_connection.php";
  $userid = $_GET['userid'];

  // insert new project into projects table when form is submitted
  if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $project_name = $_POST['project_name'];
    $start_date = $_POST['start_date'];
    
    $sql = "INSERT INTO `projects`(`user_id`, `project_name`, `start_date`) 
           VALUES ('$user_id', '$project_name','$start_date')";
    
    $result = $conn->query($sql);
    
    // navigate back to the projects page 
    if ($result == TRUE) {
      header("Location: projects.php?userid=$userid");
    }
    $conn->close();
  } 
?> 

<!-- basic header -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $userid?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
    <h1 align="left"> Create a New Project </h1>  
</head>

<!-- form for inputting a new project -->
<body style="text-align: center;"> 
  <form action="" method="POST">
    <fieldset>
      Project Manager:<br>
        <select name="user_id">
          <!-- Queries the database for available users, displaying all in a dropdown -->
          <?php 
          $sql = mysqli_query($conn, "SELECT first_name, last_name, user_id FROM users");
          while ($row = $sql->fetch_assoc()){
            unset($first_name, $last_name, $user_id);
            $id = $row['user_id'];
            $first_name = $row['first_name']; 
            $last_name = $row['last_name']; 
            // Displays the user name but stores the user id when selected
            echo '<option value="'.$id.'">'.$first_name.' '.$last_name.'</option>';
          }
          ?>
        </select>
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