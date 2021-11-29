<?php
$title = 'Voter Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection

session_start();
$reference_number = $_SESSION['ref_number'];

$res = mysqli_query($conn, "SELECT * FROM voter_reg_requests WHERE ref_number='$reference_number'");

if (isset($_POST['btn_accept'])) {

    insertData();
}
if (isset($_POST['btn_reject'])) {

    rejectData();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="request_voter_registration.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<div align="center" class="style_form ">
    <form action = "" method = "post" >
        <table border="1" id="table" style="width:70%;text-indent: 15px">
            <?php
            while ($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <td style="width:50%">Reference Number</td>
                    <td><?php echo "$row[ref_number]"; ?></td>
                </tr>
                <tr>
                    <td style="width:50%">NIC</td>
                    <td><?php echo "$row[NIC]"; ?></td>
                </tr>
                <tr>
                    <td>Name in Full</td>
                    <td><?php echo "$row[full_name]"; ?></td>
                </tr>
                <tr>
                    <td>Name with Initials</td>
                    <td> <?php echo "$row[name_with_initials]"; ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td> <?php echo "$row[gender]" ?></td>
                </tr>
                <tr>
                    <td>Permanent Address</td>
                    <td><?php echo "$row[address]"; ?></td>
                </tr>
                <tr>
                    <td>Current Address</td>
                    <td> <?php echo "$row[current_address]"; ?></td>
                </tr>
                <tr>
                    <td>GN Division</td>
                    <td> <?php echo "$row[g_division]" ?></td>
                </tr>
                <tr>
                    <td>House No</td>
                    <td><?php echo "$row[house_no]"; ?></td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td><?php echo "$row[mobile_no]"; ?></td>
                </tr>
                <?php
                $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $str = str_shuffle($str);
                $str = substr($str, 0, 4);
                $str_num="0123456789";
                $str_num = str_shuffle($str_num);
                $str_num = substr($str_num, 0, 4);
                $password = $str_num.$str;
                ?>
                <tr>
                    <td> Password</td>
                    <td>

                        <input type="password" id='password' name='password' readonly="" value='<?php echo $password; ?>'>
                    </td>
                </tr>
            </table>
            <input type="text" name="mobile" id="mobile" hidden="" value='<?php echo $row['mobile_no']; ?>'>
            <input type="text" name="nic" id="nic"  hidden="" value='<?php echo $row['NIC']; ?>'>

            <div class="d-flex justify-content-center ">
                <button type="submit" class="block" name="btn_accept" id="btn_accept">Accept</button>
                <button type="button" class="block"  data-toggle="modal" data-target="#reject">Reject</button>
            </div>
            <br>
        </form>

        <?php
    }

    function insertData() {
        $reference_number = trim($_SESSION['ref_number']);
        $password = $_POST['password'];
        $nic = $_POST['nic'];
        $mobile = $_POST['mobile'];


        //insert voter_reg_requests values to voter_registration table
        $sql = "INSERT INTO voter_registration(ref_number,NIC, full_name,name_with_initials,gender, address,current_address,province,
                e_district,p_division,g_division,house_no,mobile_no,password,status,username)
                SELECT ref_number,NIC,full_name,name_with_initials,gender,address,current_address,province,e_district,
                p_division,g_division,house_no,mobile_no,'$password','Successfully Registered',NIC
            FROM voter_reg_requests
            WHERE ref_number='$reference_number '";
        $result = mysqli_query($GLOBALS['conn'], $sql);


        //delete relavent result from voter_reg_requests table
        $sql_del = "DELETE FROM voter_reg_requests WHERE ref_number='$reference_number'";
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

        $reference_number = trim($_SESSION['ref_number']);

        $comments = $_POST['re_comment'];

        $sql_mob = "select mobile_no FROM voter_reg_requests WHERE ref_number='$reference_number' ";
        $result_mob = mysqli_query($GLOBALS['conn'], $sql_mob);
        if (mysqli_num_rows($result_mob) > 0) {
            while ($row = mysqli_fetch_assoc($result_mob)) {
                $mobile = $row['mobile_no'];
            }
        }
        //insert voter_reg_requests values to rejected_voter_registration table
        $sql = "INSERT INTO rejected_voter_registration(ref_number,NIC, full_name,name_with_initials,gender, address,current_address,province,
                e_district,p_division,g_division,house_no,mobile_no,commnent)
                SELECT ref_number,NIC,full_name,name_with_initials,gender,address,current_address,province,e_district,
                p_division,g_division,house_no,mobile_no,'$comments'
            FROM voter_reg_requests
            WHERE ref_number='$reference_number'";
        $result = mysqli_query($GLOBALS['conn'], $sql);

        //delete relavent result from voter_reg_requests table
        $sql_del = "DELETE FROM voter_reg_requests WHERE ref_number='$reference_number'";
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
        if (($result) AND ($result_del)) {
            sendsms_registation_reject($mobile, $comments);

            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Unsuccessfull ",'
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


