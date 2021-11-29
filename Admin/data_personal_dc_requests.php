<?php 
require_once '../db/config.php';


$sql="SELECT * FROM voter_update_requests";
$result=$conn->query($sql);
echo $result->num_rows;

$conn->close();
?>
