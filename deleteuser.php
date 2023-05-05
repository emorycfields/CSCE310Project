<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    $user_id = $_POST['userid'];
    
    $sql = "DELETE FROM `Users` WHERE `userid`='" .$user_id. "'";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record deleted successfully.";
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  } 
?> 

<!DOCTYPE html>
<html>
<body>
<h2>Delete User</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Information:</legend>
    
    User ID:<br>
    <input type="text" name="userid">
    <br>
  </fieldset>
</form> 
</body>
</html>