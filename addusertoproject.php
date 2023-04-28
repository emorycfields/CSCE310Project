<?php 
  $project_id = $_GET['proj_id'];
  $userid = $_GET['userid'];

  include "db_connection.php";
  if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    
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
  } 
?> 

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?project_id=<?php echo $project_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Add User to Project </h1>
        <br>
    </head>
</html>


<html>
    
<body style="text-align: center;">
<form action="" method="POST">
  <fieldset>
    User ID:
    <input type="text" name="user_id">
    <br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>