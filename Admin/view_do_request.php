<?php
$title = 'District Officer Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection

session_start();
$ref = $_SESSION['ref_number'];

$res = mysqli_query($conn, "SELECT * FROM req_reg_officer_d WHERE ref_number='$ref'");
if (isset($_POST['btn_accept'])) {

    insertData();
}
if (isset($_POST['btn_reject'])) {

    rejectData();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="request_do.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<div align="center" class="style_form">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:70%; text-indent: 15px">
            <?php
            while ($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <td style="width:50%">Reference Number</td>
                    <td><?php echo "$row[ref_number]"; ?></td>
                </tr>
                <tr>
                    <td>Name with Initials</td>
                    <td><?php echo "$row[name_with_initials]"; ?></td>
                </tr>
                <tr>
                    <td>NIC</td>
                    <td> <?php echo "$row[NIC]"; ?></td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td> <?php echo "$row[mobile_no]" ?></td>
                </tr>
                <tr>
                    <td>Work Place</td>
                    <td><?php echo "$row[district]"; ?></td>
                </tr>

            </table>
            <input type="text" name="mobile" id="mobile" hidden="" value='<?php echo $row['mobile_no']; ?>'>
            <input type="text" name="NIC" id="NIC" hidden="" value='<?php echo $row['NIC']; ?>'>
            <input type="text" name="password" id="password" hidden="" value='<?php echo $row['password']; ?>'>

            <div class="d-flex justify-content-center ">
                <button type="submit" class="block" name="btn_accept" id="btn_accept">Accept</button>
                <button type="button" class="block"  data-toggle="modal" data-target="#reject">Reject</button>
            </div>

        </form>
        <br>
        <?php
    }

    function insertData() {
        $ref = $_SESSION['ref_number'];
        $mobile = $_POST['mobile'];
        $nic = $_POST['NIC'];
        $password = $_POST['password'];

        //insert req_reg_officer_gn values to staff_login table
        $sql = "INSERT INTO staff_login (staff_id, username, password,user_level,name_with_initials,
            NIC,mobile_no,status,district,district_no)
            SELECT ref_number, NIC, password,user_level,name_with_initials,
            NIC,mobile_no,'Successfully Registered',district,district_no
            FROM req_reg_officer_d
            WHERE ref_number='$ref'";
        $result = mysqli_query($GLOBALS['conn'], $sql);


        //delete relavent result from req_reg_officer_gn table
        $sql_del = "DELETE FROM req_reg_officer_d WHERE ref_number='$ref'";
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
        if (($result) AND ($result_del)) {
            sendsms_registation_success($mobile, $nic, $password);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Successfull ",'
            . 'text: "Data Inserted Successfully",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
        }
        mysqli_close($GLOBALS['conn']);
    }

    function rejectData() {

        $ref = $_SESSION['ref_number'];
        $comments = $_POST['re_comment'];

        $sql_mob = "select mobile_no FROM req_reg_officer_d WHERE `ref_number`='$ref' ";
        $result_mob = mysqli_query($GLOBALS['conn'], $sql_mob);
        if (mysqli_num_rows($result_mob) > 0) {
            while ($row = mysqli_fetch_assoc($result_mob)) {
                $mobile = $row['mobile_no'];
            }
        }
        //insert req_reg_officer_gn values to rejected_officer_registration table
        $sql = "INSERT INTO rejected_officer_registration (user_level,ref_number,name_with_initials,NIC,mobile_no,password,
            district,district_no,commnent)
            SELECT user_level,ref_number,name_with_initials,NIC,mobile_no,password,district,district_no,'$comments'
            FROM req_reg_officer_d
            WHERE ref_number='$ref'";
        $result = mysqli_query($GLOBALS['conn'], $sql);

        //delete relavent result from req_reg_officer_gn table
        $sql_del = "DELETE FROM req_reg_officer_d WHERE ref_number='$ref'";
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
        if (($result) AND ($result_del)) {
            sendsms_registation_reject($mobile, $comments);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Rejected ",'
            . 'text: "Data Inserted to Rejected List",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
        }

        mysqli_close($GLOBALS['conn']);
    }
    ?>
    <!-- Create Bootstrap model for search -->

    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Reject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action=""  method="POST">
                        <div class="form-group">
                            <label for="rejectList">Reason for reject</label>
                            <textarea class="form-control" id="reject_registration" placeholder="Enter Comments" name="re_comment" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn_reject" name="btn_reject">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of the Model -->


