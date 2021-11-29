<?php
$title = 'Political Party Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection

session_start();
$ref = $_SESSION['ref_number'];

$res = mysqli_query($conn, "SELECT * FROM req_reg_political_party WHERE ref_number='$ref'");

if (isset($_POST['btn_accept'])) {
    insertData();
}

if (isset($_POST['btn_reject'])) {
    rejectData();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="request_political_party.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<div align="center" class="style_form">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:70%; text-indent: 15px;">
            <?php
            while ($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <td style="width:50%">Reference Number</td>
                    <td><?php echo "$row[ref_number]"; ?></td>
                </tr>
                <tr>
                    <td>Political Party Name</td>
                    <td><?php echo "$row[party_name_long]"; ?></td>
                </tr>
                <tr>
                    <td>Abbreviation</td>
                    <td> <?php echo "$row[party_name_short]"; ?></td>
                </tr>
                <tr>
                    <td>Political Party Logo</td>
                    <td> <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['party_logo']) . '" height="100" width="100"/>'; ?></td>
                </tr>
                <tr>
                    <td>Party Color</td>
                    <?php
                    $color = $row['colour'];
                    echo "<td bgcolor='$color'>";
                    ?>
                </tr>
                <tr>
                    <td>Secretary Name</td>
                    <td><?php echo "$row[party_president_name]"; ?></td>
                </tr>
                <tr>
                    <td> Secretary NIC</td>
                    <td><?php echo "$row[party_president_NIC]"; ?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> <?php echo "$row[contact_no]"; ?></td>
                </tr>
                <tr>
                    <td> Address</td>
                    <td><?php echo "$row[adress]"; ?></td>
                </tr>
                <tr>
                    <?php
                    $str = "abcdefghijklmnopqrstuvwxyz0123456789";
                    $str = str_shuffle($str);
                    $str = substr($str, 3, 3);
                    $username_l = $str;
                    ?>
                    <td> User Name</td>
                    <td> <input type="text" id='username' name='username' readonly="" value='<?php echo $row['party_name_short'] . '_' . $username_l; ?>'>
                    </td>
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

                        <input type="password" id='password' name='password' readonly="true" value='<?php echo $password; ?>'>
                    </td>
                </tr>

            </table>
            <input type="hidden" name="mobile" id="mobile" value='<?php echo $row['contact_no']; ?>'>
            
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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $mobile_no = $_POST['mobile'];

        //insert req_reg_political_party values to political_party table
        $sql = "INSERT INTO political_party (ref_number, party_name_short, party_name_long,party_logo,colour,
            party_president_name,party_president_NIC,contact_no,adress,status,candidate)
            SELECT ref_number, party_name_short, party_name_long,party_logo,colour,
            party_president_name,party_president_NIC,contact_no,adress,'Successfully Registered','Candidate not Registered'
            FROM req_reg_political_party
            WHERE ref_number='$ref'";
        $result = mysqli_query($GLOBALS['conn'], $sql);

        //Add usename and password to the political_party table
        $sql_new = "UPDATE political_party SET username='$username',password='$password' WHERE ref_number='$ref'";
        $result_new = mysqli_query($GLOBALS['conn'], $sql_new);

        //delete relavent result from req_reg_political_party table
        $sql_del = "DELETE FROM req_reg_political_party WHERE ref_number='$ref'";
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);

        if (($result) AND ($result_new) AND ($result_del)) {
            sendsms_political_party_registation_details($mobile_no, $username, $password);
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

        $sql_mob = "select contact_no FROM req_reg_political_party WHERE ref_number='$ref' ";
        $result_mob = mysqli_query($GLOBALS['conn'], $sql_mob);
        if (mysqli_num_rows($result_mob) > 0) {
            while ($row = mysqli_fetch_assoc($result_mob)) {
                $mobile = $row['contact_no'];
            }
        }

        //insert req_reg_political_party values to reject_political_party table
        $sql = "INSERT INTO reject_political_party (ref_number, party_name_short, party_name_long,party_logo,colour,
            party_president_name,party_president_NIC,contact_no,adress,commnet)
            SELECT ref_number, party_name_short, party_name_long,party_logo,colour,
            party_president_name,party_president_NIC,contact_no,adress,'$comments'
            FROM req_reg_political_party
            WHERE ref_number='$ref'";

        $result = mysqli_query($GLOBALS['conn'], $sql);

        //delete relavent result from req_reg_political_party table
        $sql_del = "DELETE FROM req_reg_political_party WHERE ref_number='$ref'";
        ;
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
        if (($result) AND ($result_del)) {

            sendsms_registation_reject($mobile, $comments);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Rejected ",'
            . 'text: "Data Inserted to Rejected List",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
        }
    }
    ?>
    <!-- Create Bootstrap model for commnents -->

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
<?php
require_once 'includes/admin_footer.php';
?>
 