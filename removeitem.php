<! -- ALL GABE -- >
<?php
    // Take in global variables passed in from the search bar
    $item_id = $_GET['item_id'];
    $proj_id = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    include "db_connection.php";

    // Delete item assignment instance
    $sql = "DELETE FROM `item assignments`WHERE item_id=$item_id AND project_id=$proj_id";

    $result = $conn->query($sql);
            
    if ($result == TRUE) {
        // Go back to project details
        echo "Item removed successfully.";
        header("Location: projectdetails.php?proj_id=$proj_id&userid=$user_id");
    }else{
        echo "Error:". $sql . "<br>". $conn->error;
    }
    $conn->close();
?>
