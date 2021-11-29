<?php
$title='Presidential election 2021 vote distribution';
require_once 'includes/header.php';
require_once 'db/config.php';// Database connection

?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item active">
          <a class="navbar-brand" href="view_e_data.php">&nbsp;&nbsp;&nbsp;Back</a>
      </li> 
    </ul>      
  </div>       
</nav>
<div class="container text-center home_box col-sm-10">
<div align="center">
<p><b><font size=5 color='blue'>Presidential election 2021 vote distribution</font></b></p>
<br>
<?php
$stmt = $conn->query("SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all");
$query ="SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all";
$result = mysqli_query($conn , $query);

$resultCount=$result->num_rows;

$php_data_array = Array(); 

foreach ($result as $voteData) {
    $color[]=$voteData['colour'];
    $political_party[] = $voteData['Political_Party'];
    $vote_count[] = $voteData['Votes'];
}
?>
<?php
echo "<table>
    <tr> <th>Party Name</th><th>Vote Count</th></tr>";
while ($row = $stmt->fetch_row()) {
   echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
   $php_data_array[] = $row; // Adding to array
   }
echo "</table>";
?>
<br>
<div id="column-chart" class="chart-div"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


  google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawColumnChart);
    function drawColumnChart() {
      var data = google.visualization.arrayToDataTable([
        ['Political_Party', 'Votes', { role: 'style' }, { role: 'annotation' }],
        <?php
        for($i=0;$i<$resultCount;$i++){
          ?>[<?php echo "'".$political_party[$i]."', ".$vote_count[$i].", '".$color[$i]."' , "."'".$vote_count[$i]."'" ?>],
        <?php } 
        ?>
        ]);


      var options = {
        chartArea: {width: '70%'},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("column-chart"));
      chart.draw(data, options);
  }
  </script>
  </div>
</div>
<br>