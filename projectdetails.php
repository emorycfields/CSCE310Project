<!-- EMORY AND GABE -->
<!-- This file holds the project details for a particular project, including the items, comments, and users associated with that project --> 
<?php

    // EMORY start 
    // get the results from the url
    $var_value = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // select project information for the specified project_id
    $sql = " SELECT
                *
            FROM projects_users
            WHERE project_id = $var_value
            LIMIT 1; ";
    $project_result = $conn->query($sql);
    $project_result = mysqli_fetch_array($project_result);
    
    // select the comments & the user information for their author
    // COMMENTS_AUTHOR_INFO is the view
    $sql = " SELECT
                *
            FROM 
            comments_author_info
            WHERE project_id = $var_value;";
    $comment_result = $conn->query($sql);

    // select the users assigned to the specified project
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
    $assigned_users = $conn->query($sql);

    // select the level and id of the current user
    $sql = " SELECT
                user_id, 
                level
            FROM
                `users`
            WHERE `users`.user_id = $user_id;";
    $user_result = $conn->query($sql);
    $user_result = mysqli_fetch_array($user_result);
?> 


<!-- general header including the home button -->
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
        <span style="font-size: 2.5em;" align="left"> Project Name: </span> <span style="font-size: 1.5em;"> <?php echo $project_result['project_name']?> </span>
        <br>
        <span style="font-size: 2.5em;" align="left"> Project Manager: </span> <span style="font-size: 1.5em;"> <?php echo $project_result['first_name']?> <?php echo $project_result['last_name']?> </span>
        <br>
    </head>
</html>
<!-- EMORY END -->

<!-- ITEMS SECTION GABE -->
<?php
    // Take in global variables passed in from the search bar
    $var_value = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // Using a view of a join on the item and item assignment tables to get
    // the necessary details to show the items within a project
    $sql = "SELECT
                item_id,
                name,
                description, 
                total_cost,
                quantity
            FROM
                attached_items
            WHERE project_id = $var_value;";
    $result3 = $conn->query($sql);

    // Checking for same manger as user
    $sql = "SELECT
                user_id
            FROM
                projects
            Where
                project_id=$var_value
            LIMIT 1";
    $result4 = $conn->query($sql);
    $row = mysqli_fetch_array($result4);
    $proj_manager = ($row['user_id']==$user_id);
    // End Checking for manager == user

    // Checking for admin
    // Uses index isAdmin in the user table
    $sql = "SELECT
        level
    FROM
        users
    Where
        user_id=$user_id
    LIMIT 1";
    $result5 = $conn->query($sql);
    $row = mysqli_fetch_array($result5);
    $admin = ($row['level']==1);
    // End Checking for admin
?> 

<h2 align="center"> Items </h2>
<!-- If the user is admin or the manager of the project, allow them to add items to the project via the blue plus sign -->
<?php if($proj_manager or $admin) : ?>
    <a href="availableitems.php?&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>">
        <button type="button" class="btn btn-primary" style=" left: 30">
            <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
        </button>
    </a>
<?php endif; ?>

<div class="container">
    <div class="row-fluid ">
        <!-- For each item in the project displays the name, description, total cost, quantity, and ID on a card -->
            <?php while ( $row = mysqli_fetch_array($result3) ) : ?>
                <div class="col-sm-4 ">
                    <div class="card-columns-fluid">
                        <div class="card bg-light" style = "width: 30rem; height: 35rem " >
                            <div class="card-body">
                                <h3>Item Name: </h3>
                                    <h4> <?php echo $row['name']?> </h4>
                                <h3>Description: </h3>
                                    <h4> <?php echo $row['description']?> </h4>
                                <h3>Cost: $<?php echo $row['total_cost']?></h3>
                                    <h4>Quantity: <?php echo $row['quantity']?></h4>
                                    <h4>ID: <?php echo $row['item_id']?></h4>
                                    <! -- If the user is admin or the manager of the project, allow them to remove items from the project or edit the quantity of an item assignment via their respective buttons -- >
                                <?php if($proj_manager or $admin) : ?>
                                    <button onclick="window.location.href='removeitem.php?item_id=<?php echo $row['item_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>'"> REMOVE </button>
                                    <button onclick="window.location.href='editquantity.php?item_id=<?php echo $row['item_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>'"> EDIT QUANTITY </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<br>
<!-- EMORY START  -->
<!-- (list out all comments in the form of blocks) -->
<br>
<h2 align="center"> Comments/Statuses </h2>

<!-- provide the button to add a new comment to the project --> 
<a href="newcomment.php?proj_id=<?php echo $var_value ?>&userid=<?php echo $user_id?>">
    <button type="button" class="btn btn-primary" >
        <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
    </button>
</a>

<div class="container">
    <div class="row-fluid ">
        <?php while ( $row = mysqli_fetch_array($comment_result) ) : ?>
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
                            <!-- provide option to edit/delete if admin or owner of comment -->
                            <?php if ($user_result['level'] == 1 || $user_result['user_id'] == $row['user_id']){?>
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


<!-- List out all users that are a part of the current project -->
<h2 align="center"> Users </h2>

<!-- provide the button to add a new user to a project --> 
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
                <?php while( $users = mysqli_fetch_assoc($assigned_users) ) { ?>
                <tr id="<?php echo $users ['user_id']; ?>">
                <td><?php echo $users ['user_id']; ?></td>
                <td><?php echo $users ['supervisor']; ?></td>
                <td><?php echo $users ['first_name']; ?></td>
                <td><?php echo $users ['last_name']; ?></td>  
                <td><?php echo $users ['level']; ?></td>  
                <td><?php echo $users ['email']; ?></td>
                <!-- provide option to delete user from the project --> 
                <td>
                    <a href="deleteuserfromproject.php?todelete=<?php echo $users['user_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>">Delete</a>
                </td> 				   				   				  
                </tr>
                <?php } ?>
            </tbody>
        </a>
    </table>
</div>