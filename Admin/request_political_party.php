<?php
$title = 'Political Party Requests';
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
<br>
<?php
$result = mysqli_query($conn, "SELECT * FROM req_reg_political_party");
?>
<div align="center" class="style_form">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:98%">
            <tr>
                <th style="width:10%">Reference Number</th>
                <th style="width:20%">Political Party Name</th>
                <th style="width:5%">Abbreviation</th>
                <th style="width:10%">Logo</th>
                <th style="width:5%">Party Color</th>
                <th style="width:15%">Secretary Name</th>
                <th style="width:10%">Secretary NIC</th>
                <th style="width:10%">Mobile No</th>
                <th style="width:10%">Address</th>

            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td> 
                        <?php echo "$row[ref_number]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[party_name_long]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[party_name_short]"; ?>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['party_logo']) . '" height="25" width="25"/>'; ?>
                        </div>
                    </td>  
                    <?php
                    $color = $row['colour'];
                    echo "<td bgcolor='$color'>";
                    ?>

                    <td> 
                        <?php echo "$row[party_president_name]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[party_president_NIC]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[contact_no]"; ?>
                    </td>
                    <td> 
                        <?php echo "$row[adress]"; ?>
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
        $sql = "SELECT * FROM req_reg_political_party WHERE ref_number='$referenceNumber'";

        $result = mysqli_query($conn, $sql);


        if (mysqli_num_rows($result) > 0) {
            $_SESSION['ref_number'] = $referenceNumber;
            echo "<script> window.location.assign('view_political_party.php'); </script>";
        }
    }
    ?>    
