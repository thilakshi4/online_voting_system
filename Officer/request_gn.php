<?php
$title = 'Grama Niladhari Requests';
require_once 'includes/officer_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection
session_start();
$nic_no = $_SESSION['username'];
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="officer_dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<?php
$sql_p = "SELECT `district_no` FROM staff_login WHERE username='$nic_no' ";
$result_p = mysqli_query($GLOBALS['conn'], $sql_p);
if (mysqli_num_rows($result_p) > 0) {
    while ($row = mysqli_fetch_assoc($result_p)) {
        $e_district = $row['district_no'];
    }
}
$result = mysqli_query($conn, "SELECT * FROM `req_reg_officer_gn` WHERE `district_no`= '$e_district'");
?>
<div align="center" class="style_form ">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:98%">
            <tr>
                <th style="width:15%">Reference Number</th>
                <th style="width:30%">Name with Initials</th>
                <th style="width:15%">NIC</th>
                <th style="width:15%">Mobile Number</th>
                <th style="width:25%">Work Place</th>

            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td> 
                        <?php echo "$row[ref_number]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[name_with_initials]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[NIC]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[mobile_no]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[work_place]"; ?>
                    </td>


                    <td> 
                        <div align="center">
                            <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="View">
                        </div>
                    </td>
                <?php }
                ?>
            </tr>
        </table>
        <input type="hidden" name="selected_value_hidden" id="selected_value_hidden">

    </form>

    <script>
        var table = document.getElementById('table');
        for (var i = 1; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function ()
            {
                document.getElementById("selected_value_hidden").value = this.cells[0].innerHTML;
            };
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {

        $referenceNumber = $_POST['selected_value_hidden'];
        $sql = "SELECT * FROM req_reg_officer_gn WHERE ref_number='$referenceNumber'";

        $result = mysqli_query($conn, $sql);


        if (mysqli_num_rows($result) > 0) {
            $_SESSION['ref_number'] = $referenceNumber;
            echo "<script> window.location.assign('view_gn_request.php'); </script>";
        }
    }
    ?> 


