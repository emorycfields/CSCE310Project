<!-- ALL EMORY -->

<?php
    include "db_connection.php";

    // get comment_id sent in from projectdetails
    $comment_id = $_GET['comment_id'];

    // get project_id to send back to projectdetails page
    $proj_id = $_GET['proj_id'];
    $user_id = $_GET['userid'];

    // delete the comment row for the corresponding comment_id
    $sql = "DELETE FROM comment_status WHERE comment_id=$comment_id LIMIT 1";

    $result = $conn->query($sql);
    
    // navigate back to projectdetails
    if ($result == TRUE) {
        header("Location: projectdetails.php?proj_id=$proj_id&userid=$user_id");
    }
    $conn->close();
?>