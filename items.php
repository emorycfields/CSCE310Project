<! -- ALL GABE -- >
<?php  
    // Take in global variable passed in from the search bar
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // Select data from all items to show in the item display
    $sql = " SELECT
                items.item_id,
                items.name,
                items.description,
                items.cost
            FROM
                items";
    $result = $conn->query($sql);

    // Checking for admin
    // Uses index isAdmin in the user table
    $sql = "SELECT
        level
    FROM
        users
    Where
        user_id=$user_id
    LIMIT 1";
    
    $result4 = $conn->query($sql);
    $row = mysqli_fetch_array($result4);
    $condition = ($row['level']==1);
    // End Checking for admin
?> 

<html>
    <head>
    <!-- HOME BUTTON -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>

        <!-- If the user is an admin, give the option to create items via the blue plus -->
        <?php if($condition) : ?>
            <a href="createitem.php?userid=<?php echo $user_id?>">
                <button type="button" class="btn btn-primary" style="position:absolute; top:30; right:375;">
                    <i style="font-size: 2em; " class="glyphicon glyphicon-plus"></i>
                </button>
            </a>
        <?php endif; ?>
        <h1 align="center"> Items </h1>
        <br>
    </head>
</html>

<! -- Display all items data -- >
<div class="container">
    <div class="row-fluid ">
    <?php while ( $row = mysqli_fetch_array($result) ) : ?>
        <div class="col-sm-4 ">
            <div class="card-columns-fluid">
                <div class="card bg-light" style = "width: 30rem; height: 35rem " >
                    <div class="card-body">
                        <h3>Item Name: </h3>
                                <h4> <?php echo $row['name']?> </h4>
                        <h3>Description: </h3>
                                <h4> <?php echo $row['description']?> </h4>
                        <h3>Cost: $<?php echo $row['cost']?></h3>
                            <h4>ID: <?php echo $row['item_id']?></h4>
                            
                        <! -- If the user is an admin, give the options to edit and delete items via their respective buttons -- >
                        <?php if($condition) : ?>
                                <button onclick="window.location.href='edititem.php?item_id=<?php echo $row['item_id']?>&userid=<?php echo $user_id?>'"> EDIT </button>
                                <button onclick="window.location.href='deleteitem.php?item_id=<?php echo $row['item_id']?>&userid=<?php echo $user_id?>'"> DELETE </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>