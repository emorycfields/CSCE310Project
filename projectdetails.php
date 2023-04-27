<?php
    $var_value = $_GET['proj_id'];

    include "db_connection.php";

    // SQL query to select data from database
    $sql = " SELECT
                *
            FROM projects_users
            WHERE project_id = $var_value
            LIMIT 1; ";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result);

    $sql = " SELECT
                comment_status.comment_id, 
                comment_status.description, 
                comment_status.date, 
                comment_status.time, 
                comment_status.approval_status, 
                users.first_name, 
                users.last_name
            FROM
                comment_status
            INNER JOIN users on users.user_id = comment_status.user_id
            WHERE project_id = $var_value;";
    $result2 = $conn->query($sql);
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
        <h1 align="center"> Project Details </h1>
        <span style="font-size: 2.5em;" align="left"> Project Name: </span> <span style="font-size: 1.5em;"> <?php echo $result['project_name']?> </span>
        <br>
        <span style="font-size: 2.5em;" align="left"> Project Manager: </span> <span style="font-size: 1.5em;"> <?php echo $result['first_name']?> <?php echo $result['last_name']?> </span>
        <br>
    </head>
</html>

<h2 align="center"> Items </h2>
<a href="newitem.php">
    <button type="button" class="btn btn-primary" style=" left: 30">
        <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
    </button>
</a>

<div class="col d-flex justify-content-center">
    <div class="card-columns-fluid mx-auto">
        <div class="card bg-light" style = "width: 150rem; height: 30rem " >
            <div class="card-body">
               
            </div>
        </div>
    </div>
</div>

<br>
<h2 align="center"> Comments/Statuses </h2>

<a href="newcomment.php?proj_id=<?php echo $var_value ?>">
    <button type="button" class="btn btn-primary" >
        <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
    </button>
</a>

<div class="container">
    <div class="row-fluid ">
        <?php while ( $row = mysqli_fetch_array($result2) ) : ?>
            <div class="col-sm-4 ">
                <div class="card-columns-fluid">
                    <div class="card bg-light" style = "width: 30rem; height: 35rem " >
                        <div class="card-body">
                            <h3>Comment: </h3>
                                <h4> <?php echo $row['description']?> </h4>
                            <h3>Status: </h3>
                                <h4> <?php echo $row['approval_status']?> </h4>
                            <br>
                            <h4>Author: <?php echo $row['first_name']?>  <?php echo $row['last_name']?></h4>
                            <h4><?php echo $row['time']?> <?php echo $row['date']?> </h4>
                            <button onclick="window.location.href='deletecomment.php?comment_id=<?php echo $row['comment_id']?>&proj_id=<?php echo $var_value?>'"> DELETE </button>
                            <button onclick="window.location.href='editcomment.php?comment_id=<?php echo $row['comment_id']?>&proj_id=<?php echo $var_value?>'"> EDIT </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
