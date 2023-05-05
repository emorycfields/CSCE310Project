<!-- ALL GABE -->
<?php
    // Take in global variables passed in from the search bar
    $user_id = $_GET['userid'];
    $var_value = $_GET['proj_id'];

    include "db_connection.php";

    // Query for items that do not have an item assignment instance where the project_id matches the current ones to identify the available items
    // Uses the except clause to remove those results from the items in the query
    // Uses the Left Join on the items table to add the attributes to the identified item_ids
    $sql = "SELECT 
                items.item_id,
                items.name,
                items.description, 
                items.cost
            FROM 
                (SELECT
                    items.item_id
                FROM
                    items
                EXCEPT
                SELECT
                    items.item_id
                FROM
                    items
                INNER JOIN `item assignments` on items.item_id = `item assignments`.item_id
                WHERE `item assignments`.project_id = $var_value) a
            LEFT JOIN items on a.item_id = items.item_id";

    $avail_items = $conn->query($sql);

    $conn->close();

?> 

<! -- HOME BUTTON -- >
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id ?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>

    </head>
</html>

<! -- Display the name, direction, cost, and ID of each item not in the project -- >
<h2 align="center"> Available Items </h2>
<div class="container">
    <div class="row-fluid ">
        <?php while ( $row = mysqli_fetch_array($avail_items) ) : ?>
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
                                <! -- When Selecting an item to add, forwards to screen where they can determine the quantity -- >
                            <button onclick="window.location.href='additem.php?item_id=<?php echo $row['item_id']?>&proj_id=<?php echo $var_value?>&userid=<?php echo $user_id?>'"> ADD </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>