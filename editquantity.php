<! -- ALL GABE -- >
<?php
    // Take in global variables passed in from the search bar
    $item_id = $_GET['item_id'];
    $proj_id = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // Query item data for details on the item quantity being edited
    $sql = "SELECT
                items.item_id,
                items.name,
                items.description,
                items.cost
            FROM
                items
            WHERE item_id=$item_id";

    $result = $conn->query($sql);
    // Row is one entry, and it contains the details on the item being edited
    $row = mysqli_fetch_array($result);
    // Empty Error message
    $message = "";

    // On Button Submit
    if (isset($_POST['submit'])) {
        // If the user did not input a number greater than 0, set the error message and do not insert into table
        $quantity = (int)$_POST['quantity'];
        if($quantity < 1){
            $message = "Item Quantity must be greater than 0";
        }
        else{
            // Calculate total cost and update item assignment table
            $total_cost = (int)$quantity * $row['cost'];        
            $sql = "UPDATE `item assignments` set 
                            `quantity` = $quantity,
                            `total_cost` = $total_cost
                    WHERE `item_id` = $item_id and `project_id` = $proj_id;";
            
            $result2 = $conn->query($sql);
            
            // Go back to Project details
            if ($result2 == TRUE) {
                echo "Item assignment created successfully.";
                header("Location: projectdetails.php?proj_id=$proj_id&userid=$user_id");
            }else{
                echo "Error:". $sql . "<br>". $conn->error;
            }
        }
        $conn->close();
    }
?>

<! -- HOME BUTTON -- >
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
        <a href="home.php?userid=<?php echo $user_id?>">
            <button type="button" class="btn btn-primary" style="position:absolute; top:0; right:0;">
                <i style="font-size: 2em; " class="glyphicon glyphicon-home"></i>
            </button>
        </a>
        <h1 align="center"> Select quantity of  <?php echo $row['name']?></h1>
        <br>
    </head>
</html>

<! -- Display item data -- >
<div class="container">
    <div class="row-fluid ">
        <div class="col-sm-4 ">
            <div class="card-columns-fluid">
                <div class="card bg-light" style = "width: 35rem; height: 35rem " >
                    <div class="card-body">
                        <h3>Item Name: </h3>
                            <h4> <?php echo $row['name']?> </h4>
                        <h3>Description: </h3>
                            <h4> <?php echo $row['description']?> </h4>
                        <h3>Cost: $<?php echo $row['cost']?></h3>
                            <h4>ID: <?php echo $row['item_id']?></h4>
                        
                        <! -- Input for quantity -- >
                        <form action="" method="POST">
                            <fieldset>
                                Quantity: <?php echo $message?><br>
                                <input type="number" name="quantity" placeholder="0" min = "1">
                                <input type="submit" name="submit" value = "submit">
                            </fieldset>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
