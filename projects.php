<?php
    include "db_connection.php";
    $user_id = $_GET['userid'];
    // SQL query to select data from database
    $sql = " SELECT
                projects.project_id,
                users.user_id,
                projects.project_name,
                users.first_name,
                users.last_name, 
                projects.start_date
            FROM
                users
            INNER JOIN projects ON projects.user_id = users.user_id; ";
    $result = $conn->query($sql);
?> 

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>

        <a href="newproject.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:30; right:375;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
            </button>
        </a>
        <h1 align="center"> Projects </h1>
        <br>
    </head>
</html>


<div class="container">
    <div class="row-fluid ">
    <?php while ( $row = mysqli_fetch_array($result) ) : ?>
        <div class="col-sm-4 ">
            <div class="card-columns-fluid">
                <div class="card bg-light" style = "width: 30rem; height: 30rem " >
                    <div class="card-body">
                        <a class="card-block stretched-link text-decoration-none" href="projectdetails.php?proj_id=<?php echo $row['project_id'] ?>&userid=<?php echo $user_id ?>" style="color:black">
                            <h3> Project: </h3>
                            <h4>Name: <?php echo $row['project_name']?> <br> ID: <?php echo $row['project_id']?></h4> 
                            <h3>  Manager: </h3>
                            <h4>
                                <?php echo $row['first_name']?>
                                <?php echo $row['last_name']?>
                            </h4> 
                            <h3>  Start Date: </h3>
                            <h4>
                                <?php echo $row['start_date']?>
                            </h4> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>