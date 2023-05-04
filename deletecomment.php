<?php
    include "db_connection.php";

    $comment_id = $_GET['comment_id'];
    $proj_id = $_GET['proj_id'];
    $sql = "DELETE FROM comment_status WHERE comment_id=$comment_id LIMIT 1";

    $result = $conn->query($sql);
            
            if ($result == TRUE) {
            echo "New project created successfully.";
            header("Location: projectdetails.php?proj_id=$proj_id");
            }else{
            echo "Error:". $sql . "<br>". $conn->error;
            }
            $conn->close();
?>