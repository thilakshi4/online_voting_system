<?php
$title = 'Grama Niladhari Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection
session_start();
$nic_no = $_SESSION['username'];
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<?php


$result = mysqli_query($conn, "SELECT * FROM voter_reg_requests");
?>
<div align="center" class="login_officers_form ">
    <form action = "" method = "post" class="style_form">
        <table border="1" id="table" style="width:98%">
            <tr>
                <th style="width:10%">Reference Number</th>
                <th style="width:13%">NIC</th>
                <th style="width:30%">Name with Initials</th>
                <th style="width:8%">Gender</th>
                <th style="width:25%">Current Address</th>
                <th style="width:10%">House Number</th>
                <th style="width:10%">Mobile Number</th>

            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td> 
                        <?php echo "$row[ref_number]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[NIC]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[name_with_initials]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[gender]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[current_address]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[house_no]"; ?>
                    </td>

                    <td> 
                        <?php echo "$row[mobile_no]"; ?>
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

        $ref_number = $_POST['selected_value_hidden'];
        $reference_number = trim($ref_number);
        $sql = "SELECT * FROM voter_reg_requests WHERE ref_number='$reference_number'";
        $results = mysqli_query($conn, $sql);


        if (mysqli_num_rows($results) > 0) {
            $_SESSION['ref_number'] = $reference_number;
            echo "<script> window.location.assign('view_voter_registration.php'); </script>";
        }
    }
    ?> 


