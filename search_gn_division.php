<?php
require_once 'db/config.php';
 
function get_gn_division($conn , $term){ 
$query = "SELECT * FROM gn_division WHERE gn_division LIKE '%".$term."%' ORDER BY gn_division ASC";
 $result = mysqli_query($conn, $query); 
 $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
 return $data; 
}
 
if (isset($conn,$_GET['term'])) {
 $getGNDivision = get_gn_division($conn, $_GET['term']);
 $gn_divisionList = array();
 foreach($getGNDivision as $gn_division){
 $gn_divisionList[] = $gn_division['gn_division'];
 }
 echo json_encode($gn_divisionList);
}
?>
