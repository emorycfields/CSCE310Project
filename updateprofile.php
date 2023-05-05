<?php 
$user_id = $_GET['userid'];

include "db_connection.php";
    $sql_grab_current = "SELECT * FROM `Users` WHERE `user_id`='" .$user_id. "'";
    $result_current = $conn->query($sql_grab_current);
    $row = mysqli_fetch_array($result_current);
  if (isset($_POST['submit'])) {

    $new_supervisor = $_POST['supervisor'];
    $new_first_name = $_POST['firstname'];
    $new_last_name = $_POST['lastname'];
    $new_level = $_POST['level'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    
    $sql = "UPDATE `Users` SET 
                `supervisor` = '$new_supervisor',
                `first_name` = '$new_first_name',
                `last_name` = '$new_last_name',
                `level` = '$new_level',
                `email` = '$new_email',
                `password` = '$new_password'
            WHERE `user_id` = $user_id;";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record created successfully.";
      
      header("Location: home.php?userid=$user_id");
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  } 
?> 



<!DOCTYPE html>
<html>
<body>
<a href="delete_user.php?userid=<?php echo $user_id?>&todelete=<?php echo $user_id?>">
    <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
        DELETE PROFILE
    </button>
</a>
<h2>Update Profile</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Information:</legend>
    Supervisor:<br>
    <input type="text" name="supervisor" value="<?php echo $row['supervisor'];?>">
    <br>
    First name:<br>
    <input type="text" name="firstname" value="<?php echo $row['first_name'];?>">
    <br>
    Last name:<br>
    <input type="text" name="lastname" value="<?php echo $row['last_name'];?>">
    <br>
    Level:<br>
    <input type="text" name="level" value="<?php echo $row['level'];?>">
    <br>
    Email:<br>
    <input type="email" name="email" value="<?php echo $row['email'];?>">
    <br>
    Password:<br>
    <input type="password" name="password" value="<?php echo $row['password'];?>">
    <br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>