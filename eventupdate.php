<!-- ALL JOHN -->
<?php 
include "db_connection.php";
  $user_id = $_GET['userid'];
  $event_id = $_GET['event_id'];

  date_default_timezone_set('America/Chicago');

  // Get data regarding monday in order to send back to schedule page once finished adding the event
  $weekStart = date('Y-m-d', strtotime('last monday', strtotime('next monday')));
  $mondayTS = strtotime($weekStart);

  if (isset($_POST['submit'])) {
    // Get data from the various inputs
    $project = $_POST['project'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    
    // Update the event table
    $sql = "UPDATE `events` SET 
    `event_id`= '$event_id',
    `project_id`= '$project',
    `user_id`= '$user_id',
    `time`= '$time',
    `date`= '$date',
    `location`= '$location',
    `name`= '$name' 
    WHERE `event_id` = $event_id";
    
    $result = $conn->query($sql);
    if ($result) {
      $event = $conn->insert_id;
    }
    
    // Update the event_attendee table
    // As a bridge entity, this table utilizes a delete/insert functionality to mimic update functionality
    // It doesn't make sense to update specific entries bc the number of entries related to an event may have changed
    if(!empty($_POST["attendees"])) {
      // Deletes the previous instances associated with the event
      $deleteSQL = "DELETE FROM `event_attendee` WHERE `event_id` = $event_id";
      $deleteResult = $conn->query($deleteSQL);
      foreach($_POST['attendees'] as $key) {
        // Creates new instances based on the new selection
        $bridgeSQL = "INSERT INTO `event_attendee`(`event_id`, `user_id`) 
              VALUES ('$event_id', '$key')";
        $bridgeResult = $conn->query($bridgeSQL);

        if ($bridgeResult != TRUE) {
          echo "Error:". $bridgeSQL . "<br>". $conn->error;
        }
      }   
    }

    if ($result == TRUE) {
      echo "New record created successfully.";
      header("Location: schedule.php?userid=$user_id&monday=$mondayTS");
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    
    $conn->close();
  } 
?> 

<!DOCTYPE html>
<html>
<body>
<!-- Utilizes the same logic as the event.php page -->
<h2>Update Event</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Information:</legend>
    Name:<br>
    <input type="text" name="name">
    <br>
    Location:<br>
    <input type="text" name="location">
    <br>
    Project:<br>
    <select name="project">
      <?php 
      $sql = mysqli_query($conn, "SELECT project_name, project_id FROM projects");
      while ($row = $sql->fetch_assoc()){
        unset($project_name, $project_id);
        $id = $row['project_id'];
        $name = $row['project_name']; 
        echo '<option value="'.$id.'">'.$name.'</option>';
      }
      ?>
    </select>
    <br>
    Attendees:<br>
    <select name="attendees[]" multiple="multiple">
      <?php 
      $sql = mysqli_query($conn, "SELECT first_name, last_name, user_id FROM users");
      while ($row = $sql->fetch_assoc()){
        unset($first_name, $last_name, $user_id);
        $id = $row['user_id'];
        $last_name = $row['last_name'];  
        $first_name = $row['first_name']; 
        echo '<option value="'.$id.'">'.$first_name. " " . $last_name .'</option>';
      }
      ?>
    </select>
    <br>
    Date:<br>
    <input type="date" name="date">
    <br>
    Time:<br>
    <input type="time" name="time">
    <br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>