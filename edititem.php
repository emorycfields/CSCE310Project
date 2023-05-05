<!-- ALL GABE -->
<!-- This file provides the query and interface that allows a user to update an existing item --> 
<?php 
    // Take in global variables passed in from the search bar
    $item_id = $_GET['item_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // On Button Submit
    if (isset($_POST['submit'])) {
      // Gather input fields
      $name = $_POST['name'];
      $description = $_POST['description'];
      $cost = $_POST['cost'];
      
      // Update item in item table to have new attributes
      $sql = "UPDATE `items` SET 
                  `name`= '$name', 
                  `description` = '$description', 
                  `cost` = '$cost' 
              WHERE `item_id` = $item_id;";
      $result = $conn->query($sql);

      // Update each instance in item assingments which uses this item with the new attributes
      $sql = "UPDATE `item assignments` SET 
                  `total_cost` = $cost * `quantity`
              WHERE `item_id` = $item_id;";
      $result2 = $conn->query($sql);
      
      if ($result == TRUE and $result2 == TRUE) {
        // Go back to items
        echo "item updated successfully.";
        header("Location: items.php?userid=$user_id");
      }else{
        echo "Error:". $sql . "<br>". $conn->error;
      }
      $conn->close();
    } 
?> 

<!DOCTYPE html>
<html>
  <head>
      <! -- Home Button-- >
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
          <a href="home.php?userid=<?php echo $user_id?>">
              <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                  <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
              </button>
          </a>
      <h1 align="left"> Create a New Item </h1>  
  </head>

  <! -- Input Fields -- >
  <body style="text-align: center;"> 
    <form action="" method="POST">
      <fieldset>
        Item Name:<br>
        <input type="text" name="name">
        <br>
        Item Description:<br>
        <input type="text" name="description">
        <br>
        Item Cost:<br>
        <input type="" name="cost">
        <br> 
        <input type="submit" name="submit" value="submit">
      </fieldset>
    </form> 
  </body>
</html>