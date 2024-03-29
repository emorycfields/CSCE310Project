<!-- Allison and Emory -->
<!-- This file allows the admin to register new accounts for users --> 
<?php 
  $user_id = $_GET['userid'];

  include "db_connection.php";
  if (isset($_POST['submit'])) {
    // obtains fields from form
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
        <!-- EMORY -->
        <select name="supervisor">
            <option></option>
            <!-- Queries the database for available users, displaying all in a dropdown -->
            <?php 
            $sql = mysqli_query($conn, "SELECT first_name, last_name, user_id FROM users");
            while ($row = $sql->fetch_assoc()){
              unset($first_name, $last_name, $user_id);
              $id = $row['user_id'];
              $first_name = $row['first_name']; 
              $last_name = $row['last_name']; 
              // Displays the user name but stores the user id when selected
              echo '<option value="'.$id.'">'.$first_name.' '.$last_name.'</option>';
            }
            ?>
          </select>
          <!-- END EMORY -->
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