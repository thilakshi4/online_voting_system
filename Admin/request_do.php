<?php
$title = 'District Officer Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection
session_start();
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>

<?php
$result = mysqli_query($conn, "SELECT * FROM req_reg_officer_d");
?>
<div align="center" class="style_form">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:98%">
            <tr>
                <th style="width:15%">Reference Number</th>
                <th style="width:30%">Name with Initials</th>
                <th style="width:15%">NIC</th>
                <th style="width:15%">Mobile Number</th>
                <th style="width:25%">District</th>

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
                        <?php echo "$row[district]"; ?>
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
        $sql = "SELECT * FROM req_reg_officer_d WHERE ref_number='$referenceNumber'";

        $result = mysqli_query($conn, $sql);


        if (mysqli_num_rows($result) > 0) {
            $_SESSION['ref_number'] = $referenceNumber;
            echo "<script> window.location.assign('view_do_request.php'); </script>";
        }
    }
    ?> 


