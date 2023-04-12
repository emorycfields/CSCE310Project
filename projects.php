<?php
include "db_connection.php";

$title= 'Web Develop'; 
// SQL query to select data from database
$sql = " SELECT * FROM users ";
$result = $conn->query($sql);
$conn->close();

while ( $row = mysqli_fetch_array($result) ) :
?>
    <main class="py-4 container">
         <div class ="row">
             <div class="col-md-4">
                <div class="card">
                    <h4 class="card-header">
                        <a href="show.php" class="btn btn-primary">Go somewhere</a>
                    </h4>
                    <div class="card-body"><?php echo $row['first_name']?></div>
                    <div class="card-footer"><?php echo $row['last_name']?></div>
                </div>
            </div>
         </div>
    </main>

<?php
endwhile;
?>