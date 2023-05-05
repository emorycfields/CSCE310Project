<?php
    include "db_connection.php";

    $user_id = $_GET["userid"];
   
    $sql = "SELECT
            user1.user_id, 
            supervisorname.first_name as SupFirst,
            supervisorname.last_name as SupLast,
            user1.first_name, 
            user1.last_name,
            user1.level,
            user1.email
        FROM
            users AS user1
        LEFT JOIN users AS supervisorname on user1.supervisor = supervisorname.user_id;";
    
    $result = $conn->query($sql);

    if (isset($_POST['delete'])) {

    }
?> 

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <h1 align="center"> Users </h1>  
</head>
</html>

<a href="home.php?userid=<?php echo $user_id?>">
    <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
        <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
    </button>
</a>

<a href="adduser.php?userid=<?php echo $user_id?>">
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
                <?php while( $users = mysqli_fetch_assoc($result) ) { 

                    ?>
                <tr id="<?php echo $users ['user_id']; ?>">
                <td><?php echo $users ['user_id']; ?></td>
                <td><?php echo $users ['SupFirst']; ?> <?php echo $users ['SupLast']; ?></td>
                <td><?php echo $users ['first_name']; ?></td>
                <td><?php echo $users ['last_name']; ?></td>  
                <td><?php echo $users ['level']; ?></td>  
                <td><?php echo $users ['email']; ?></td>
                <td>
                    <a href="delete_user.php?userid=<?php echo $user_id?>&todelete=<?php echo $users['user_id']?>">Delete</a>
                    <a href="updateuser.php?userid=<?php echo $user_id?>&toedit=<?php echo $users['user_id']?>">Edit</a>
                </td> 				   				   				  
                </tr>
                <?php } ?>
            </tbody>
        </a>
    </table>
</div>