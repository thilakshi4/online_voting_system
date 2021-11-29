<?php 
require_once '../db/config.php';
session_start();
$nic_no=$_SESSION['username'];

 
    $sql_p = "SELECT `district_no` FROM staff_login WHERE username='$nic_no' ";
    $result_p = mysqli_query($GLOBALS['conn'], $sql_p);
    if (mysqli_num_rows($result_p) > 0) {
        while ($row = mysqli_fetch_assoc($result_p)) {
            $e_district = $row['district_no'];
        }
    }

$sql="SELECT * FROM `req_reg_officer_gn` WHERE `district_no`= '$e_district'";
$result=$conn->query($sql);
echo $result->num_rows;

$conn->close();
?>

