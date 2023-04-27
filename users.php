<?php
    include "db_connection.php";

    $title= 'Web Develop'; 
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

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <h1 align="left"> Home </h1>  
</head>
</html>
<div>
    <table id="editableTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>													
            </tr>
        </thead>
        <tbody>
            <?php while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
            <tr id="<?php echo $developer ['id']; ?>">
            <td><?php echo $developer ['id']; ?></td>
            <td><?php echo $developer ['name']; ?></td>
            <td><?php echo $developer ['gender']; ?></td>
            <td><?php echo $developer ['age']; ?></td>  				   				   				  
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>