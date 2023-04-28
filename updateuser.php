<?php 
$user_id = $_GET['userid'];
$cur_id = $_GET['toedit'];
echo $cur_id;
echo $user_id;
include "db_connection.php";
    $sql_grab_current = "SELECT * FROM `Users` WHERE `userid`='" .$cur_id. "'";
    $result_current = $conn->query($sql_grab_current);
    echo "here";
    $row = mysqli_fetch_array($result_current);
    echo $row['firstname'];
  if (isset($_POST['submit'])) {

    $new_supervisor = $_POST['supervisor'];
    $new_first_name = $_POST['firstname'];
    $new_last_name = $_POST['lastname'];
    $new_level = $_POST['level'];
    $new_email = $_POST['email'];
    
    $sql = "UPDATE `Users` SET 
                `supervisor` = '$new_supervisor',
                `firstname` = '$new_first_name',
                `lastname` = '$new_last_name',
                `level` = '$new_level',
                `email` = '$new_email'
            WHERE `userid` = $cur_id;";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record created successfully.";
      header("Location: users.php?userid=$user_id");
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  } 
?> 


<!DOCTYPE html>
<html>
<body>
<h2>Registration Form</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Information:</legend>
    Supervisor:<br>
    <input type="text" name="supervisor" value="<?php echo $row['supervisor'];?>">
    <br>
    First name:<br>
    <input type="text" name="firstname" value="<?php echo $row['firstname'];?>">
    <br>
    Last name:<br>
    <input type="text" name="lastname" value="<?php echo $row['lastname'];?>">
    <br>
    Level:<br>
    <input type="text" name="level" value="<?php echo $row['level'];?>">
    <br>
    Email:<br>
    <input type="email" name="email" value="<?php echo $row['email'];?>">
    <br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>