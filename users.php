<?php
    include "db_connection.php";

    
   
    $sql = "SELECT
            user1.userid, 
            supervisorname.firstname as SupFirst,
            supervisorname.lastname as SupLast,
            user1.firstname, 
            user1.lastname,
            user1.level,
            user1.email
        FROM
            users AS user1
        INNER JOIN users AS supervisorname on user1.supervisor = supervisorname.userid;";
    
    $result = $conn->query($sql);
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
                <tr id="<?php echo $users ['userid']; ?>">
                <td><?php echo $users ['userid']; ?></td>
                <td><?php echo $users ['SupFirst']; ?> <?php echo $users ['SupLast']; ?></td>
                <td><?php echo $users ['firstname']; ?></td>
                <td><?php echo $users ['lastname']; ?></td>  
                <td><?php echo $users ['level']; ?></td>  
                <td><?php echo $users ['email']; ?></td>
                <td>
                    <a href="delete_user.php?todelete=<?php echo $users['userid']?>">Delete</a>
                    <a href="updateuser.php?toedit=<?php echo $users['userid']?>">Edit</a>
                </td> 				   				   				  
                </tr>
                <?php } ?>
            </tbody>
        </a>
    </table>
</div>