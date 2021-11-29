<?php
$title='Presidential election 2021';
require_once 'includes/admin_header.php';
require_once '../db/config.php';

?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="navbar-brand" href="vote_precentage_2021.php">&nbsp;&nbsp;&nbsp;Back</a>
      </li> 
    </ul>      
  </div>
               <div>
               <form action="vote_precentage_disrict_2021_report.php" method = "post">
                   <button type="submit"  class="btn btn-primary" name="report" id="report">Generate Report</button>&nbsp;&nbsp;&nbsp;
        </form>
    </div>
</nav>
<div class="container text-center home_box col-sm-10">
<div align="center">
<p><b><font size=5 color='blue'>Presidential election 2021 voting percentages</font></b></p>
<br>
<?php


$stmt = $conn->query("select e_district,no_of_registered_voters,no_of_votes,concat(ROUND(((no_of_votes/no_of_registered_voters)*100),1),'%') AS percentage FROM v_district_pvn GROUP BY `e_district`");
$query ="select e_district,no_of_registered_voters,no_of_votes,ROUND(((no_of_votes/no_of_registered_voters)*100),2) AS percentage FROM v_district_pvn GROUP BY `e_district`";
$result = mysqli_query($conn , $query);

$resultCount=$result->num_rows;
// create PHP array
$php_data_array = Array(); 

foreach ($result as $voteData) {
    $province[] = $voteData['e_district'];
    $reg_vote_count[] = $voteData['no_of_registered_voters'];
    $vote_count[] = $voteData['no_of_votes'];
}

echo "<table style='width:80%'>
    <tr> <th>District</th><th>Number of Registered Voters</th><th>Vote Count</th><th>Vote Percentage</th></tr>";
while ($row = $stmt->fetch_row()) {
   echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
   $php_data_array[] = $row; // Adding to array
   }
echo "</table>";
echo "<br>";
echo "<br>";

?>

<div id="bar-chart" class="chart-div"></div>


</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
   google.charts.load("current", {packages:['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBarBasic);
    function drawBarBasic() {
      var data = google.visualization.arrayToDataTable([
        ['Province', 'Registered Voters',{ role: 'annotation' },'Vote Count' ,{ role: 'annotation' }],
        <?php
        for($i=0;$i<$resultCount;$i++){
          ?>[<?php echo "'".$province[$i]."', ".$reg_vote_count[$i]." , "."'".$reg_vote_count[$i]."',".$vote_count[$i].", "."'".$vote_count[$i]."'" ?>],
        <?php } 
        ?>
        ]);

      var options = {
        chartArea: {width: '700'},
        hAxis: {
          title: 'Votes',
          minValue: 0
        },
        vAxis: {
          title: 'District'
        },
        legend: { position: "none" }
      };
 var chart = new google.visualization.BarChart(document.getElementById('bar-chart'));

      chart.draw(data, options);
  } 
</script>
</div>
</div>
<br>
