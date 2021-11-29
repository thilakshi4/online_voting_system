<?php
require_once 'db/config.php';
 
function get_district($conn , $term){ 
$query = "SELECT * FROM e_district WHERE district LIKE '%".$term."%' ORDER BY district ASC";
 $result = mysqli_query($conn, $query); 
 $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
 return $data; 
}
 
if (isset($conn,$_GET['term'])) {
 $getDistrict = get_district($conn, $_GET['term']);
 $districtList = array();
 foreach($getDistrict as $district){
 $districtList[] = $district['district'];
 }
 echo json_encode($districtList);
}
?>