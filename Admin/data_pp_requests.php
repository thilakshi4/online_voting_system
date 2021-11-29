<?php

require_once '../db/config.php';

$sql = "SELECT * FROM req_reg_political_party";
$result = $conn->query($sql);
echo $result->num_rows;

$conn->close();
?>

