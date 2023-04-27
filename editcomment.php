<?php
    date_default_timezone_set('America/Chicago');
    $proj_id = $_GET['proj_id'];
    $comment_id = $_GET['comment_id'];

    include "db_connection.php";
    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $project_id = $proj_id;
        $time = date("h:i:s");
        $date = date("Y-m-d");
        $description = $_POST['comment'];
        $status = $_POST['status'];
        

        $sql = "UPDATE `comment_status` SET 
                    `user_id`= '$user_id', 
                    `project_id` = '$project_id', 
                    `description` = '$description', 
                    `date` = '$date', 
                    `time` = '$time', 
                    `approval_status` = '$status' 
                WHERE `comment_id` = $comment_id;";
        
        $result = $conn->query($sql);
        
        if ($result == TRUE) {
            echo "comment updated successfully.";
            header("Location: projectdetails.php?proj_id=$proj_id");
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
        <h1 align="center"> Update Comment & Status </h1>
        </head>

        <br>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
</html>


<html>
    <body style="text-align: center;"> 
        <form action="" method="POST">
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

                <input type="submit" name="submit" value="update">
            </fieldset>
        </form> 
    </body>
</html>
