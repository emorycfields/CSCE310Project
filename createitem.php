<!-- ALL GABE -->
<!-- This file allows the user to create a new item in the database --> 
<?php 
    // Take in global variable passed in from the search bar
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // On Button Submit
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $cost = $_POST['cost'];
      
      // Insert item into item table with data from the input fields
      $sql = "INSERT INTO `items`(`name`, `description`, `cost`) VALUES ('$name', '$description','$cost')";
      
      $result = $conn->query($sql);
      
      if ($result == TRUE) {
        // Go back to items
        echo "New item created successfully.";
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
    <! -- Home Button -- >
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