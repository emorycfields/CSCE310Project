<!-- ALL JOHN -->
<!-- This file inserts an event into the DB -->
<!-- The file queries the DB to get possible projects / users to associate to the event -->
<!-- The file also inserts the corresponding event attendee entries -->
<?php 
include "db_connection.php";
  $user_id = $_GET['userid'];

  // Obtain the user level to determine admin privileges
  // Can utilize the isAdmin index, which consists of level and user_id
  $user_sql = "SELECT users.level FROM users WHERE users.user_id = $user_id LIMIT 1";
  $user = $conn->query($user_sql);
  $userRow = mysqli_fetch_array($user);

  date_default_timezone_set('America/Chicago');

  // Get data regarding monday in order to send back to schedule page once finished adding the event
  $weekStart = date('Y-m-d', strtotime('last monday', strtotime('next monday')));
  $mondayTS = strtotime($weekStart);

  // Checks to see if a user is attending their own meeting
  // Only admins can create meetings they aren't attending
  if (isset($_POST['submit'])) {
  $valid = true; // assume valid for admins
    if (!($userRow["level"] == 1)) { // if not an admin, assume invalid
      $valid = false; 
      if(!empty($_POST["attendees"])) {
        foreach($_POST['attendees'] as $key) {
          // Loop through the attendees selected; if it matches the user at any point, the event becomes valid
          if ($key != $user_id) {
            continue;
          } else {
            $valid = true;
          }
        }   
      }
    }
  
    // Uses the above validation to display error message or add to database
    if (!$valid) {
      echo "Regular users must attend their own meetings";
    } else {
      // Get data from the various inputs
      $project = $_POST['project'];
      $time = $_POST['time'];
      $date = $_POST['date'];
      $name = $_POST['name'];
      $location = $_POST['location'];
      
      // Insert into the DB
      // This only inserts the event data into the events page; it does not deal with attendees yet
      $sql = "INSERT INTO `events`(`project_id`, `user_id`, `date`, `time`, `name`, `location`) 
             VALUES ('$project', '$user_id', '$date', '$time', '$name', '$location')";
      echo $sql;
      $result = $conn->query($sql);
      // Get the event_id of the new event. This is used to update the event attendee table
      if ($result) {
        $event = $conn->insert_id;
      }

      // If attendees have been selected, inserts into the DB
      if(!empty($_POST["attendees"])) {
        // Loops through each attendee and adds to the event attendee table using the new event_id
        foreach($_POST['attendees'] as $key) {
          $bridgeSQL = "INSERT INTO `event_attendee` (`event_id`, `user_id`) 
                VALUES ('$event', '$key')";
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
  } 
?> 

<!DOCTYPE html>
<html>
<body>
<h2>Add Event</h2> 
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
      <!-- Queries the database for available projects, displaying all in a dropdown -->
      <?php 
      $sql = mysqli_query($conn, "SELECT project_name, project_id FROM projects");
      while ($row = $sql->fetch_assoc()){
        unset($project_name, $project_id);
        $id = $row['project_id'];
        $name = $row['project_name']; 
        // Displays the project name but stores the project id when selected
        echo '<option value="'.$id.'">'.$name.'</option>';
      }
      ?>
    </select>
    <br>
    Attendees:<br>
    <select name="attendees[]" multiple="multiple">
      <!-- Queries the database for available users, displaying all in a list that allows multiple selections -->
      <?php 
      $sql = mysqli_query($conn, "SELECT first_name, last_name, user_id FROM users");
      while ($row = $sql->fetch_assoc()){
        unset($first_name, $last_name, $user_id);
        $id = $row['user_id'];
        $last_name = $row['last_name'];  
        $first_name = $row['first_name']; 
        // Displays the user's name but stores the user id when selected
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
