<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    $supervisor = $_POST['supervisor'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "INSERT INTO `Users`(`supervisor`, `first_name`, `last_name`, `level`, `email`, `password`) 
           VALUES ('$supervisor', '$first_name','$last_name', '$level', '$email','$password')";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record created successfully.";
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
    <input type="text" name="supervisor">
    <br>
    First name:<br>
    <input type="text" name="firstname">
    <br>
    Last name:<br>
    <input type="text" name="lastname">
    <br>
    Level:<br>
    <input type="text" name="level">
    <br>
    Email:<br>
    <input type="email" name="email">
    <br>
    Password:<br>
    <input type="password" name="password">
    <br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>
</html>