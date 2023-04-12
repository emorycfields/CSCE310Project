<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT `password` FROM `Users` WHERE `email`='" .$email. "' LIMIT 1";

    $password_check = $conn->query($sql);
    
    if ($password_check == FALSE) {
        echo "Error:". $sql . "<br>". $conn->error;
    }
    
    $conn->close();
    $row = mysqli_fetch_array($password_check);
    

    if ($row['password'] === $password) {
      echo "\nCorrect password";
      header("Location: register.php");
    }else{
      echo "\nIncorrect password. Please try again";
    }
    
  } 
?> 

<!DOCTYPE html>
<html>
<body>
<h2>Login Form</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Login:</legend>
    
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