<!-- All Allison -->
<?php 

include "db_connection.php";

  // obtains which user is currently logged in and which user is to be deleted
  $user_id = $_GET['userid'];
  $delete_user = $_GET['todelete'];
  
  // deletes delete user from users table
  $sql = "DELETE FROM `Users` WHERE `user_id`='" .$delete_user. "'";
  
  $result = $conn->query($sql);
  
  if ($result == TRUE) {
    echo "New record deleted successfully.";
    if ($user_id == $delete_user) {
      // reroutes to the login page because the user deleted themselves
      header("Location: login.php");
    } else {
      // rereoutes to the users page because the admin deleted another user
      header("Location: users.php?userid=$user_id");
    }
    
  }else{
    echo "Error:". $sql . "<br>". $conn->error;
  }
  $conn->close();
?> 

