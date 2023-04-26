<?php
    $var_value = $_GET['proj_id'];

    include "db_connection.php";

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
            INNER JOIN projects ON projects.user_id = users.user_id
            WHERE projects.project_id = $var_value
            LIMIT 1; ";
    $result = $conn->query($sql);
    $result = mysqli_fetch_array($result);
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
<h2 align="center"> Comments/Status Updates </h2>

<a href="newcomment.php?proj_id=<?php echo $var_value ?>">
    <button type="button" class="btn btn-primary" >
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