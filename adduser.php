<!-- All Allison -->
<?php 

  /*
  find current user, this user must be an admin -- only accessible through users page
  which is exclusive to admin
  */
  $user_id = $_GET['userid'];

  include "db_connection.php";
  if (isset($_POST['submit'])) {

    // obtains all values for user from the form
    $supervisor = $_POST['supervisor'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // inserts into the users table
    $sql = "INSERT INTO `Users`(`supervisor`, `first_name`, `last_name`, `level`, `email`, `password`) 
           VALUES ('$supervisor', '$first_name','$last_name', '$level', '$email','$password')";
    
    $result = $conn->query($sql);
    
    if ($result == TRUE) {
      echo "New record created successfully.";

      // reroutes user back to users page with current user id stored
      header("Location: users.php?userid=$user_id");
    }else{
      echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
  } 
?> 

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="users.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Add User </h1>
    </head>
</html>
<html>
<body style="text-align: center;">
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