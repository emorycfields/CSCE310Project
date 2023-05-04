<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    echo "logging in";
    
    $user_sql = "SELECT * FROM `Users` WHERE `email`='" .$email. "'";
    $user_check = $conn->query($user_sql);

    echo "user check complete";

    if ($user_check == FALSE) {
        echo "Error:". $user_sql . "<br>". $conn->error;
    } 

    $password_sql = "SELECT `password`,`userid` FROM `Users` WHERE `email`='" .$email. "' LIMIT 1";
    $password_check = $conn->query($password_sql);
    
    echo "password query";

    if ($password_check == FALSE) {
        echo "Error:". $password_sql . "<br>". $conn->error;
    }
    
    $conn->close();
    $row = mysqli_fetch_array($password_check);
    

    if (mysqli_num_rows($user_check) > 0 and $row['password'] == $password) {
        echo "Correct password";
        //echo $row['userid'];
        header("Location: home.php?userid=".$row['userid']);
        
    }else{
        echo "Incorrect email or password. Try again.";
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