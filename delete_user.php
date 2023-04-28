<?php 

include "db_connection.php";
  $delete_user = $_GET['todelete'];
  if (isset($_POST['submit'])) {
    
    
    $sql = "DELETE FROM `Users` WHERE `userid`='" .$delete_user. "'";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record deleted successfully.";
      header("Location: users.php");
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
    
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>