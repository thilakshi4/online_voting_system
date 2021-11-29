<?php
$title = 'Presidential election 2021';
require_once 'includes/admin_header.php';
require_once '../db/config.php';
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="dashboard.php">&nbsp;&nbsp;&nbsp;Back</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    View
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="e_data_2021_province.php">Vote distribution - Province</a>
                    <hr>
                    <a class="dropdown-item" href="e_data_2021_district.php">Vote distribution - District</a>
                    <hr>
                    <a class="dropdown-item" href="e_data_2021_pol_division.php">Vote distribution - Polling Division</a>
                </div>
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
        <p><b><font size=5 color='blue'>Presidential election 2021 vote distribution</font></b></p>
        <br>
        <?php
        $stmt = $conn->query("SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all");
        $query = "SELECT party_name_short as Political_Party,counts as Votes ,colour FROM v_vote_count_all ";
        $result = mysqli_query($conn, $query);

        $resultCount = $result->num_rows;

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
        <div id="chart_bar" class="chart-div"></div>
        <hr>
        <div id="column-chart" class="chart-div"></div>
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

            //draw Cloumn chart  
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawColumnChart);
            function drawColumnChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Political_Party', 'Votes', {role: 'style'}, {role: 'annotation'}],
<?php
for ($i = 0; $i < $resultCount; $i++) {
    ?>[<?php echo "'" . $political_party[$i] . "', " . $vote_count[$i] . ", '" . $color[$i] . "' , " . "'" . $vote_count[$i] . "'" ?>],
<?php }
?>
                ]);


                var options = {
                    chartArea: {width: '70%'},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("column-chart"));
                chart.draw(data, options);

            }

            //draw bar chart
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
                    //title: "Presidential election 2021 vote distribution",
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
                var chart_bar = document.getElementById('chart_bar');
                var chart = new google.visualization.BarChart(chart_bar);

                // Wait for the chart to finish drawing before calling the getImageURI() method.
                google.visualization.events.addListener(chart, 'ready', function () {
                    chart_bar.innerHTML = '<img src="' + chart.getImageURI() + '">';

                });
                chart.draw(data, options);
                document.getElementById("hidden_v").value = chart.getImageURI();
            }



        </script>
    </div>
</div>
<br>
<?php
if (isset($_POST['submit'])) {

    $url = $_POST["hidden_v"];
    $sql = "UPDATE image_url SET url='$url' WHERE id=1 ";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "<script> window.location.assign('report.php'); </script>";
    }
}