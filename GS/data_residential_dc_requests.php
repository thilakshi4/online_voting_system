
<?php 
require_once '../db/config.php';
session_start();
$nic_no=$_SESSION['username'];

    $sql_gn_no = "SELECT gn_division_no FROM staff_login WHERE username='$nic_no' ";
    $result_gn_no = mysqli_query($GLOBALS['conn'], $sql_gn_no);
    if (mysqli_num_rows($result_gn_no) > 0) {
        while ($row = mysqli_fetch_assoc($result_gn_no)) {
            $gn_division_no = $row['gn_division_no'];
        }
    }
    
    $sql_gn = "SELECT gn_division FROM gn_division WHERE gn_division_No='$gn_division_no' ";
    $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);
    if (mysqli_num_rows($result_gn) > 0) {
        while ($row = mysqli_fetch_assoc($result_gn)) {
            $gn_division = $row['gn_division'];
        }
    }

$sql="SELECT * FROM voter_update_requests_residential WHERE oldGNDivision= '$gn_division'";
$result=$conn->query($sql);
echo $result->num_rows;

$conn->close();
?>