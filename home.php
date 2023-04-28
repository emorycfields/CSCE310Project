<?php 
  $user_id = $_GET['userid'];
  include "db_connection.php";

  $sql = "SELECT `level` FROM `Users` WHERE `user_id`='".$user_id."'";

  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <h1 align="center"> Home </h1>  
</head>
</html>

<a href="login.php">
    <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
        Logout
    </button>
</a>

<div class="d-flex flex-grow-1 justify-content-center align-items-center">
  <div class="container py-4 ">
      <div class="card-deck-wrapper">
          <div class="card-deck ">
              <div class="card  bg-light" style = "width: 30rem; height: 7rem ">
                  <a class="card-block stretched-link text-decoration-none" href = "projects.php?userid=<?php echo $user_id ?>" style="color:black">
                      <h3 align="center">Projects</h3>
                  </a>
              </div>
              <div class="card bg-light" style = "width: 30rem; height: 7rem ">
                  <a class="card-block stretched-link text-decoration-none" href="schedule.php?userid=<?php echo $user_id ?>" style="color:black">
                      <h3 align="center">Schedule</h3>
                  </a>
              </div>
              <?php if ($row['level'] == 1){?>
              <div class="card bg-light" style = "width: 30rem; height: 7rem ">
                  <a class="card-block stretched-link text-decoration-none" href = "users.php?userid=<?php echo $user_id ?>" style="color:black">
                      <h3 align="center" >Users</h3>
                  </a>
              </div>
              <?php }?>
          </div>
      </div>
  </div>
</div>
