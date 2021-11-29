<?php
$title = 'Voter Requests';
require_once '../db/config.php';
require_once '../php/componenet.php';
require_once 'includes/admin_header.php';

$result = mysqli_query($conn, "SELECT * FROM voter_update_requests_residential");

if (isset($_POST['update'])) {
    update();
}
if (isset($_POST['delete'])) {
    delete();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<div align="center" class="style_form ">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:100%">
            <tr>
                <th style="width:13%">NIC Number</th>
                <th style="width:25%">Full Name</th>
                <th style="width:25%">Address</th>
                <th style="width:18%">Requested GN Division</th>
                <th style="width:5%">House Number</th>
                <th style="width:20%">Previouse GN Division</th>
                <th colspan="2" style="width:35%">Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>

                    <td><?php echo "$row[NIC]"; ?></td>
                    <td><?php echo "$row[full_name]"; ?></td>
                    <td><?php echo "$row[address]"; ?></td>
                    <td hidden=""><?php echo "$row[province]"; ?></td>
                    <td hidden=""><?php echo "$row[e_district]"; ?></td>
                    <td hidden=""><?php echo "$row[p_division]"; ?></td>
                    <td><?php echo "$row[g_division]"; ?></td>
                    <td><?php echo "$row[house_no]"; ?></td>
                    <td><?php echo "$row[oldGNDivision]"; ?></td>
                    <td hidden=""><?php echo "$row[id]"; ?></td>

                    <td> 
                        <div align="center">
                            <input id="update" class="frm_btn btn btn-success" type="submit" name="update" value="Update">
                        </div>
                    </td>
                    <td> 
                        <div align="center">
                            <input id="delete" class="style_btn btn btn-warning" type="submit" name="delete" value="Reject">
                        </div>
                    </td>
                </tr>
            <?php } ?>


        </table>
        <input type="hidden"  name="nic" id="nic">
        <input  type="hidden" name="address" id="address">
        <input type="hidden"  name="province" id="province">
        <input  type="hidden" name="e_district" id="e_district">
        <input  type="hidden" name="p_division" id="p_division">
        <input type="hidden"  name="g_division" id="g_division">
        <input  type="hidden" name="house_no" id="house_no">
        <input  type="hidden" name="id" id="id">
    </form> 
</div>

</body>
</html>
<?php

function update() {

    $nic = trim($_POST['nic']);
    $province = $_POST['province'];
    $district = $_POST['e_district'];
    $division = $_POST['p_division'];
    $address = $_POST['address'];
    $grama_niladari_division = $_POST['g_division'];
    $houseNo = $_POST['house_no'];
    $id = $_POST['id'];


    $sql = "UPDATE voter_registration SET address='$address',province='$province',e_district='$district',"
            . "p_division='$division',g_division='$grama_niladari_division',house_no='$houseNo' WHERE NIC='$nic'";

    $result_up = mysqli_query($GLOBALS['conn'], $sql);

    $sql_del = "DELETE FROM voter_update_requests_residential WHERE id='$id'";

    $result_del = mysqli_query($GLOBALS['conn'], $sql_del);

    if (($result_up) AND ($result_del)) {

        echo ' <script>setTimeout(function() '
        . '{swal({title: "Details Updated Successfully ",'
        . 'text: "",'
        . 'type: "success"}, '
        . 'function() { window.location = "dashboard.php";});}, 500);</script>';
    } else {
        TextNode("error", "Details are not updated. Please Try again");
    }
}

function delete() {

    $id = $_POST['id'];

    $sql_del = "DELETE FROM  voter_update_requests_residential WHERE id='$id'";

    $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
    if ($result_del) {

        echo ' <script>setTimeout(function() '
        . '{swal({title: "Details Deleted ",'
        . 'text: "",'
        . 'type: "success"}, '
        . 'function() { window.location = "dashboard.php";});}, 500);</script>';
    } else {
        TextNode("error", "Details are not Deleted. Please Try again");
    }
}
?> 

<script>
    var table = document.getElementById('table');
    for (var i = 1; i < table.rows.length; i++)
    {
        table.rows[i].onclick = function ()
        {
            document.getElementById("nic").value = this.cells[0].innerHTML;
            document.getElementById("address").value = this.cells[2].innerHTML;
            document.getElementById("province").value = this.cells[3].innerHTML;
            document.getElementById("e_district").value = this.cells[4].innerHTML;
            document.getElementById("p_division").value = this.cells[5].innerHTML;
            document.getElementById("g_division").value = this.cells[6].innerHTML;
            document.getElementById("house_no").value = this.cells[7].innerHTML;
            document.getElementById("id").value = this.cells[9].innerHTML;
        };
    }
</script>