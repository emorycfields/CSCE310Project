<!-- All Emory -->
<?php 
    include "db_connection.php";

    // set timezone
    date_default_timezone_set('America/Chicago');

    // get variables from the url
    $proj_id = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    // insert into table when form is submitted
    if (isset($_POST['submit'])) {
        $project_id = $proj_id;
        $time = date("h:i:s");
        $date = date("Y-m-d");
        $description = $_POST['comment'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO `comment_status`(`user_id`, `project_id`, `description`, `date`, `time`, `approval_status`) 
            VALUES ('$user_id', '$project_id', '$description', '$date', '$time', '$status')";
        
        $result = $conn->query($sql);
        
        // navigate back to the projectdetails page
        if ($result == TRUE) {
        header("Location: projectdetails.php?proj_id=$proj_id&userid=$user_id");
        }
        $conn->close();
  } 
?> 

<!-- general header including home page and title-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Add New Comment & Status </h1>
        <br>
    </head>
</html>

<!-- create form for making a new table -->
<body style="text-align: center;"> 
<form action="" method="POST">
  <fieldset>
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