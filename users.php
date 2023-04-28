<?php
    include "db_connection.php";

    
    $sql = "SELECT `userid`, `supervisor`, `firstname`, `lastname`, `level`, `email` FROM `Users`";
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
                <?php while( $users = mysqli_fetch_assoc($result) ) { ?>
                <tr id="<?php echo $users ['userid']; ?>">
                <td><?php echo $users ['userid']; ?></td>
                <td><?php echo $users ['supervisor']; ?></td>
                <td><?php echo $users ['firstname']; ?></td>
                <td><?php echo $users ['lastname']; ?></td>  
                <td><?php echo $users ['level']; ?></td>  
                <td><?php echo $users ['email']; ?></td>
                <td>
                    <a href="delete_user.php?todelete=<?php echo $users['userid']?>">Delete</a>
                    <a href="updateuser.php?toedit=<?php echo $users['userid']?>">Delete</a>
                </td> 				   				   				  
                </tr>
                <?php } ?>
            </tbody>
        </a>
    </table>
</div>