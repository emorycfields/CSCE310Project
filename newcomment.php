<?php 
    $proj_id = $_GET['proj_id'];

    include "db_connection.php";
    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $project_id = $proj_id;
        $time = date("h:i:sa");
        $date = date("m/d/Y");
        $description = $_POST['comment'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO `comment_status`(`user_id`, `project_id`, `time`, `date`, `description`, `approval_status`) 
            VALUES ('$user_id', '$project_id','$time', '$date', '$description', '$status')";
        
        $result = $conn->query($sql);
        
        if ($result == TRUE) {
        echo "New project created successfully.";
        }else{
        echo "Error:". $sql . "<br>". $conn->error;
        }
        $conn->close();
  } 
?> 

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Add New Comment & Status Update </h1>
        <br>
    </head>
</html>


<body style="text-align: center;"> 
<form action="projectdetails.php?proj_id=<?php echo $proj_id?>" method="POST">
  <fieldset>
    user_id:<br>
    <input type="text" name="user_id">
    <br>
    Comment:<br>
    <input type="text" name="comment" size="200">
    <br>
    Status:<br>
    <select name="status">
        <option value="Not Started">Not Started</option>
        <option value="In Progress">In progress</option>
        <option value="Blocked">Blocked</option>
        <option value="Completed">Completed </option>
    </select>
    <br>

    <br>

    <input type="submit" name="submit" value="submit">
  </fieldset>
</form> 
</body>