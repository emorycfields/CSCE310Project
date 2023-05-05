<!-- All Allison -->
<!-- This file allows users to update their own user information --> 
<?php 
    $user_id = $_GET['userid'];

    include "db_connection.php";


    // obtains the current user profile information associated with the current user
    $sql_grab_current = "SELECT * FROM `Users` WHERE `user_id`='" .$user_id. "'";
    $result_current = $conn->query($sql_grab_current);
    $row = mysqli_fetch_array($result_current);


    /*echo "before select";
    $sql_sup = "SELECT `supervisor` FROM `Users` WHERE `user_id`='" .$user_id. "'";
    echo $sql_sup;
    $result_sup_id = $conn->query($sql_sup);
    echo "supervisor $result_sup_id";*/
    if (isset($_POST['submit'])) {

        // grabs the information from the form
        $new_supervisor = $_POST['supervisor'];
        $new_first_name = $_POST['firstname'];
        $new_last_name = $_POST['lastname'];
        $new_level = $_POST['level'];
        $new_email = $_POST['email'];
        $new_password = $_POST['password'];
        
        // update the user table
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
        // redirects back to home with the user id stored
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
<!-- This form is very similar to other forms, but with the values prefilled out
    These fields can be edited but originally show the current stored information
    Once the submit button is pressed, whatever is in the fields will be updated
    to the database
-->
<h2>Update Profile</h2> 
  <form action="" method="POST">
    <fieldset>
      <legend>Information:</legend>
      Supervisor:<br>
      <select name="supervisor" value="">
          <option></option>
          <!-- Queries the database for available users, displaying all in a dropdown -->
          <?php 
          $sql = mysqli_query($conn, "SELECT first_name, last_name, user_id FROM users");
          while ($users = $sql->fetch_assoc()){
            unset($first_name, $last_name, $user_id);
            $id = $users['user_id'];
            $first_name = $users['first_name']; 
            $last_name = $users['last_name']; 
            // Displays the user name but stores the user id when selected
            // displays the current supervisor as current selected value
            if ($id == $row['supervisor']) {
              echo '<option value="'.$id.'" selected>'.$first_name.' '.$last_name.'</option>';
            } else {
              echo '<option value="'.$id.'">'.$first_name.' '.$last_name.'</option>';
            }
            
          }
          ?>
        </select>
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