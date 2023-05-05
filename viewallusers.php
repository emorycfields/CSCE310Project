<!-- EMORY --> 
<!-- This file lists all of the users that can be added to a project --> 
<?php 
    $project_id = $_GET['proj_id'];
    $userid = $_GET['userid'];

    include "db_connection.php";
    // get all users that are not already assigned to the current table
    $sql = "SELECT 
                users.user_id, 
                users.supervisor, 
                users.first_name, 
                users.last_name,
                users.level,
                users.email
            FROM users
            LEFT JOIN 
                (
                SELECT * FROM 
                `project assignments` 
                WHERE  `project assignments`.project_id = 12358
                ) t2
                on t2.user_id = users.user_id
            WHERE t2.user_id IS NULL";
    $result = $conn->query($sql);
  
?> 

<!-- standard header including home button and title --> 
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?user_id=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Add User to Project </h1>
        <br>
    </head>
</html>

<!-- list out all the users not currently in the project and include a button to add the user to the project --> 
<html>
<body style="text-align: center;">
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
                    <th>ADD</th>													
                </tr>
            </thead>
            <a href = "projects.php" >
                <tbody>
                    <?php while( $users = mysqli_fetch_assoc($result) ) { ?>
                    <tr id="<?php echo $users ['user_id']; ?>">
                    <td><?php echo $users ['user_id']; ?></td>
                    <td><?php echo $users ['supervisor']; ?></td>
                    <td><?php echo $users ['first_name']; ?></td>
                    <td><?php echo $users ['last_name']; ?></td>  
                    <td><?php echo $users ['level']; ?></td>  
                    <td><?php echo $users ['email']; ?></td>
                    <td>
                        <a href="addusertoproject.php?user_id=<?php echo $users['user_id']?>&proj_id=<?php echo $project_id?>&userid=<?php echo $userid?>">ADD</a>
                    </td> 				   				   				  
                    </tr>
                    <?php } ?>
                </tbody>
            </a>
        </table>
    </div>
</body>
</html>