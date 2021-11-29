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
        <a class="navbar-brand" href="e_data_2021_election.php">&nbsp;&nbsp;&nbsp;Back</a>
      </li> 
    </ul>      
  </div>
    <div>
        <form action="" method = "post">
            <input type="hidden" name="hidden_v" id="hidden_v" />
            <button type="submit"  class="btn btn-primary" name="submit" id="submit">Generate Report</button>&nbsp;&nbsp;&nbsp;
        </form>
    </div>
</nav>
<div class="container text-center home_box col-sm-10">
<div align="center">
<p><b><font size=5 color='blue'>Province vice vote distribution</font></b></p>
<br>
<?php
$stmt = $conn->query("SELECT province,no_of_registered_voters,no_of_votes FROM v_province_pvn");
$query ="SELECT province,no_of_registered_voters,no_of_votes FROM v_province_pvn";
$result = mysqli_query($conn , $query);

$resultCount=$result->num_rows;

$color = array("#17CDE4","#EB11BA","#11EB25", "#EBB311","#E41717","#1B17E4","#16C942", "#7033FF", "#FFD633");
foreach ($result as $voteData) {
    $province[] = $voteData['province'];
    $voter_count[] = $voteData['no_of_registered_voters'];
    $vote_count[] = $voteData['no_of_votes'];
}?>
 <table border="1" id="table" style="width:80%">
    <tr>
                <th style="width:15%">Province</th>
                <th style="width:30%">Number of Registered Users</th>
                <th style="width:15%">Vote Count</th>
            </tr>
    <?php
while ($row = $stmt->fetch_row()) {
   echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
   $php_data_array[] = $row; // Adding to array
   }
echo "</table>";
?>


<div id="barchart_material" style="width: 900px; height: 500px;"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    
    //draw bar chart
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBarBasic);
      
     function drawBarBasic() {

      var data = new google.visualization.arrayToDataTable([
         ['Province','No of Registered Voters',{ role: 'annotation' },'Votes', { role: 'style' }, { role: 'annotation' }],
        <?php
        for($i=0;$i<$resultCount;$i++){
          ?>[<?php echo "'".$province[$i]."', ".$voter_count[$i].",'".$voter_count[$i]."',".$vote_count[$i].", '".$color[$i]."' , '".$vote_count[$i]."'" ?>],
        <?php } 
        ?>
        ]);

      var options = {
        chartArea: {width: '700'},
        hAxis: {
          title: 'Vote Count',
          minValue: 0
        },
        vAxis: {
          title: 'Province'
        },
        legend: { position: 'top', maxLines: 3 },
      };
            var chart_bar = document.getElementById('barchart_material');
                var chart = new google.visualization.BarChart(chart_bar);
// Wait for the chart to finish drawing before calling the getImageURI() method.
                google.visualization.events.addListener(chart, 'ready', function () {
                    chart_bar.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    // console.log(chart_div.innerHTML);

                });

      chart.draw(data, options);
      document.getElementById("hidden_v").value = chart.getImageURI();

    }
</script>
</div>
</div>
<br>
<?php 
if(isset($_POST['submit'])){
    
      $url = $_POST["hidden_v"];
       $sql="UPDATE image_url SET url='$url' WHERE id=3 ";
       
       if(mysqli_query($GLOBALS['conn'], $sql)){
        echo "<script> window.location.assign('e_data_2021_province_report.php'); </script>";
        }
}

