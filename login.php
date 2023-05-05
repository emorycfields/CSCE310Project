<!-- All Allison -->
<?php 

include "db_connection.php";
  if (isset($_POST['submit'])) {
    
    // obtains entered email and password
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // checks to make sure that the user exists
    $user_sql = "SELECT * FROM `Users` WHERE `email`='" .$email. "'";
    $user_check = $conn->query($user_sql);



    if ($user_check == FALSE) {
        echo "Error:". $user_sql . "<br>". $conn->error;
    } 

    // pulls the user id and password information associated with the email
    $password_sql = "SELECT `password`,`user_id` FROM `Users` WHERE `email`='" .$email. "' LIMIT 1";
    $password_check = $conn->query($password_sql);
    

    // checks if the credentials are valid
    if ($password_check == FALSE) {
        echo "Error:". $password_sql . "<br>". $conn->error;
    }
    
    $conn->close();
    $row = mysqli_fetch_array($password_check);
    

    if (mysqli_num_rows($user_check) > 0 and $row['password'] == $password) {
        echo "Correct password";
        //redirects user to home with user id stored
        header("Location: home.php?userid=".$row['user_id']);
        
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