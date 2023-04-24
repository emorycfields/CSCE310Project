<?php 

include "db_connection.php";
    $project_id = 00000000001;
    
    $items_sql = "SELECT * FROM `Items` WHERE `project_id`!='" .$project_id. "'";
    $avail_items = $conn->query($items_sql);

    $conn->close();



?> 

<!DOCTYPE html>
<html>
<body>
<h2>Add Item</h2> 
<form action="" method="POST">
  <fieldset>
    <legend>Available Items:</legend>
    <?php
        while($row = mysqli_fetch_assoc($avail_items)){
            // This will loop through each row of the query
            echo $row['item_id']."" + $row["description"]."" + $row["cost"]."";
            
        } 
    ?>
    <br>
    <input type="submit" name="submit" value="+">
  </fieldset>
</form> 
</body>
</html>