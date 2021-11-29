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
        <p><b><font size=5 color='blue'> District vice vote distribution</font></b></p>
        <br>
        <?php
        $query = "SELECT e_district,no_of_registered_voters,no_of_votes FROM v_district_pvn ";
        $result = mysqli_query($conn, $query);
        ?>
        <table>
            <tr> 
                <th>District</th>
                <th>No of Registered Voters</th>
                <th>Vote Count</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td> <?php echo "$row[e_district]"; ?></td>
                    <td> <?php echo "$row[no_of_registered_voters]"; ?></td>
                    <td> <?php echo "$row[no_of_votes]"; ?></td>
                </tr>
            <?php }
            ?>
        </table>
        <?php
        $resultCount = mysqli_num_rows($result);

        $color = array("#17CDE4", "#EB11BA", "#11EB25", "#EBB311", "#E41717", "#1B17E4", "#16C942", "#7033FF", "#FFD633","#17CDE4", "#EB11BA", "#11EB25", "#EBB311", "#E41717", "#1B17E4", "#16C942", "#7033FF", "#FFD633","#17CDE4", "#EB11BA", "#11EB25", "#EBB311", "#E41717", "#1B17E4", "#16C942", "#7033FF", "#FFD633");
        foreach ($result as $voteData) {
            $district[] = $voteData['e_district'];
            $voter_count[] = $voteData['no_of_registered_voters'];
            $vote_count[] = $voteData['no_of_votes'];
        }
        ?>

        <div id="chart_bar" class="chart-div"></div>
        <div id="barchart_material" style="width: 900px; height: 500px;"></div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>

            //draw bar chart
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawBarBasic);

            function drawBarBasic() {

                var data = new google.visualization.arrayToDataTable([
                    ['District', 'No of Registered Voters', {role: 'annotation'}, 'Vote Count', {role: 'style'}, {role: 'annotation'}],
<?php
for ($i = 0; $i < $resultCount; $i++) {
    ?>[<?php echo "'" . $district[$i] . "', " . $voter_count[$i] . ",'" . $voter_count[$i] . "'," . $vote_count[$i] . ", '" . $color[$i] . "' , '" . $vote_count[$i] . "'" ?>],
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
                        title: 'District'
                    },
                    legend: {position: 'top', maxLines: 3},
                };

                var chart_bar = document.getElementById('barchart_material');
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
    $sql = "UPDATE image_url SET url='$url' WHERE id=2 ";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "<script> window.location.assign('e_data_2021_district_report.php'); </script>";
    }
}

    