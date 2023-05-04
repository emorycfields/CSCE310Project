<?php
    $var_value = $_GET['proj_id'];
    $user_id = $_GET['userid'];

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
                users.last_name, 
                users.user_id, 
                users.level, 
                users.user_id 
            FROM
                comment_status
            INNER JOIN users on users.user_id = comment_status.user_id
            WHERE project_id = $var_value;";
    $result2 = $conn->query($sql);

    $sql = " SELECT
                users.first_name, 
                users.last_name, 
                users.user_id, 
                users.supervisor,
                users.level, 
                users.email
            FROM
                `project assignments`
            INNER JOIN users on users.user_id = `project assignments`.user_id
            WHERE `project assignments`.project_id = $var_value;";
    $result3 = $conn->query($sql);

    $sql = " SELECT
                user_id,
                first_name, 
                last_name, 
                user_id, 
                supervisor,
                level, 
                email
            FROM
                `users`
            WHERE `users`.user_id = $user_id;";
    $result4 = $conn->query($sql);
    $result4 = mysqli_fetch_array($result4);
?> 

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id ?>">
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
<a href="newitem.php?userid=<?php echo $user_id?>">
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

<a href="newcomment.php?proj_id=<?php echo $var_value ?>&userid=<?php echo $user_id?>">
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
                            <?php if ($result4['level'] == 1 || $result4['user_id'] == $row['user_id']){?>
                                <button onclick="window.location.href='deletecomment.php?comment_id=<?php echo $row['comment_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>'"> DELETE </button>
                                <button onclick="window.location.href='editcomment.php?comment_id=<?php echo $row['comment_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>'"> EDIT </button>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
<br>


<h2 align="center"> Users </h2>

<a href="viewallusers.php?proj_id=<?php echo $var_value ?>&userid=<?php echo $user_id?>">
    <button type="button" class="btn btn-primary" >
        <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
    </button>
</a>

<div>
    <table id="editableTable" class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Supervisor</th>
                <th>First Name</th>
                <th>Last Name</th>	
                <th>Level</th>
                <th>Email</th>
                <th>Delete</th>													
            </tr>
        </thead>
        <a href = "projects.php" >
            <tbody>
                <?php while( $users = mysqli_fetch_assoc($result3) ) { ?>
                <tr id="<?php echo $users ['user_id']; ?>">
                <td><?php echo $users ['user_id']; ?></td>
                <td><?php echo $users ['supervisor']; ?></td>
                <td><?php echo $users ['first_name']; ?></td>
                <td><?php echo $users ['last_name']; ?></td>  
                <td><?php echo $users ['level']; ?></td>  
                <td><?php echo $users ['email']; ?></td>
                <td>
                    <a href="deleteuserfromproject.php?todelete=<?php echo $users['user_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>">Delete</a>
                </td> 				   				   				  
                </tr>
                <?php } ?>
            </tbody>
        </a>
    </table>
</div>
