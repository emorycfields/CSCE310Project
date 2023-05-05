<!-- ALL GABE -->
<?php
    // Take in global variables passed in from the search bar
    $item_id = $_GET['item_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // Delete item assignments which include the item being deleted
    $sql = "DELETE FROM `item assignments` WHERE item_id=$item_id";
    $result = $conn->query($sql);
    
    // Delete item from item table
    $sql = "DELETE FROM items WHERE item_id=$item_id";
    $result2 = $conn->query($sql);

    if ($result2 == TRUE) {
        // Go back to items
        echo "Item deleted successfully.";
        header("Location: items.php?userid=$user_id");
    }else{
        echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
?>