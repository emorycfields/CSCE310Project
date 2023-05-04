<?php 
  $user_id = $_GET['userid'];
  // JOHN: (obtains the monday of this week to send to the schedule page)
  date_default_timezone_set('America/Chicago');

  $weekStart = date('Y-m-d', strtotime('last monday', strtotime('next monday')));
  $mondayTS = strtotime($weekStart);
  // END JOHN
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <h1 align="left"> Home </h1>  
</head>
</html>
<div class="d-flex flex-grow-1 justify-content-center align-items-center">
  <div class="container py-4 ">
      <div class="card-deck-wrapper">
          <div class="card-deck ">
              <div class="card  bg-light" style = "width: 30rem; height: 10rem ">
                  <a class="card-block stretched-link text-decoration-none" href = "projects.php" style="color:black">
                      <h3 align="center">Projects</h3>
                  </a>
              </div>
              <div class="card bg-light" style = "width: 30rem; height: 10rem ">
                  <a class="card-block stretched-link text-decoration-none" href= "schedule.php?userid=<?php echo $user_id; ?>&monday=<?php echo $mondayTS; ?>" style="color:black">
                      <h3 align="center">Schedule</h3>
                  </a>
              </div>
              <div class="card bg-light" style = "width: 30rem; height: 10rem ">
                  <a class="card-block stretched-link text-decoration-none" href = "adduser.php?userid=".$user_id style="color:black">
                      <h3 align="center" >Add User</h3>
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>