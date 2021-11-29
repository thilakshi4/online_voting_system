<?php
$title = 'Presidential election 2021';
require_once 'includes/header.php';
require_once 'db/config.php'; // Database connection
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="index.php">&nbsp;&nbsp;&nbsp;Home</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    View
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="view_e_data_colomn_chart.php">Column Chart</a>
                </div>
        </ul>      
    </div>       
</nav>
<div class="container text-center home_box col-sm-10">
    <div align="center">
        <p><b><font size=5 color='blue'>Presidential election 2021 vote distribution</font></b></p>
        
        <!-- <?php
        $que2="SELECT MAX(`counts`)AS count FROM v_vote_count_all";
        $res2= mysqli_query($conn, $que2);
        while ($row = mysqli_fetch_array($res2)) {
             $value2=$row['count'];
         }
         //echo $value2;
        $que="SELECT `party_name_short` FROM v_vote_count_all WHERE counts=$value2";
         $res= mysqli_query($conn, $que);
         while ($row = mysqli_fetch_array($res)) {
             $value=$row['party_name_short'];
         }
         //echo $value;
        ?>
        
        <p><b><font size=5 color='blue'>Winner is <?php echo $value;?></font></b></p>
        <br> -->   
        <?php
        $stmt = $conn->query("SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all");
        $query = "SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all ";
        $result = mysqli_query($conn, $query);

        $resultCount = $result->num_rows;

        $php_data_array = Array();

        foreach ($result as $voteData) {
            $color[] = $voteData['colour'];
            $political_party[] = $voteData['Political_Party'];
            $vote_count[] = $voteData['Votes'];
        }

        echo "<table>
    <tr> <th>Party Name</th><th>Vote Count</th></tr>";
        while ($row = $stmt->fetch_row()) {
            echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
            $php_data_array[] = $row; // Adding to array
        }
        echo "</table>";
        ?>
        <div id="pie-chart" class="chart-div"></div>
        <hr>
        <div id="bar-chart" class="chart-div"></div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            google.charts.load('current', {'packages': ['corechart']});

            google.charts.setOnLoadCallback(drawPieChart);

            function drawPieChart() {

                var data = new google.visualization.arrayToDataTable([
                    ["Political_Party", "Votes"],
<?php
for ($i = 0; $i < $resultCount; $i++) {
    ?>[<?php echo "'" . $political_party[$i] . "', " . $vote_count[$i] ?>],
<?php }
?>
                ]);

                var options = {
                    width: '700',
                    height: '400',
                    is3D: true,
                    colors: [
<?php
for ($i = 0; $i < $resultCount; $i++) {
    echo "'" . $color[$i] . "',";
}
?>
                    ]
                };
                var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
                chart.draw(data, options);
            }
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawBarBasic);

            function drawBarBasic() {

                var data = new google.visualization.arrayToDataTable([
                    ['Political_Party', 'Votes', {role: 'style'}, {role: 'annotation'}],
<?php
for ($i = 0; $i < $resultCount; $i++) {
    ?>[<?php echo "'" . $political_party[$i] . "', " . $vote_count[$i] . ", '" . $color[$i] . "' , " . "'" . $vote_count[$i] . "'" ?>],
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
                        title: 'Political Party'
                    },
                    legend: {position: "none"}
                };

                var chart = new google.visualization.BarChart(document.getElementById('bar-chart'));

                chart.draw(data, options);
            }
        </script>
    </div>
</div>
<br>
