<?php 
require_once '../db/config.php';
session_start();
$nic_no=$_SESSION['username'];

 
    $sql_d_no = "SELECT `district_no` FROM staff_login WHERE username='$nic_no' ";
    $result_dn = mysqli_query($GLOBALS['conn'], $sql_d_no);
    if (mysqli_num_rows($result_dn) > 0) {
        while ($row = mysqli_fetch_assoc($result_dn)) {
            $e_district = $row['district_no'];
        }
    }
 
     $sql_d = "SELECT district FROM e_district WHERE districtNo='$e_district' ";
    $result_d = mysqli_query($GLOBALS['conn'], $sql_d);
    if (mysqli_num_rows($result_d) > 0) {
        while ($row = mysqli_fetch_assoc($result_d)) {
            $district = $row['district'];
        }
    }

$sql="SELECT * FROM `voter_reg_requests` WHERE `e_district`= '$district'";
$result=$conn->query($sql);
echo $result->num_rows;

$conn->close();
?>

