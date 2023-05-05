<!-- ALL JOHN -->
<?php 

include "db_connection.php";

$user_id = $_GET['userid'];
$event_id = $_GET['event_id'];

date_default_timezone_set('America/Chicago');

// Get data regarding monday in order to send back to schedule page once finished adding the event
$weekStart = date('Y-m-d', strtotime('last monday', strtotime('next monday')));
$mondayTS = strtotime($weekStart);
    
// Deletes an event from the events table
$sql = "DELETE FROM `events` WHERE `event_id` = $event_id";
$result = $conn->query($sql);

// Deletes all associated entries in the event attendee table
$deleteBridge = "DELETE FROM `event attendee` WHERE `event_id` = $event_id";
$bridgeResult = $conn->query($deleteBridge);

if ($bridgeResult != TRUE) {
    echo "Error:". $bridgeSQL . "<br>". $conn->error;
}

if ($result == TRUE) {
    echo "New record created successfully.";
    // Reloads the page
    header("Location: schedule.php?userid=$user_id&monday=$mondayTS");
  }else{
    echo "Error:". $sql . "<br>". $conn->error;
  }
  
  $conn->close();

?>