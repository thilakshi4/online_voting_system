<?php
$title = 'Candidate Register Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection

session_start();
$ref = $_SESSION['ref_number'];

$res = mysqli_query($conn, "SELECT * FROM candidate_requests WHERE ref_number='$ref'");
if (isset($_POST['btn_accept'])) {

    insertData();
}
if (isset($_POST['btn_reject'])) {

    rejectData();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="request_candidate_register.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<br>
<div align="center" class="style_form">
    <form action = "" method = "post" enctype="multipart/form-data">
        <table border="1" id="table" style="width:70%;text-indent: 15px; ">
            <?php
            while ($row = mysqli_fetch_array($res)) {
                ?>
            <tr>
                    <td colspan="2"> 
                        <div align="center">
                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['candidate_photo']) . '" height="250" width="250"/>'; ?>
                        </div>
                    </td> 
            </tr>
                <tr  style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Reference Number</td>
                    <td ><?php echo "$row[ref_number]"; ?></td>
                </tr>
                <tr  style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>NIC Number</td>
                    <td><?php echo "$row[NIC]"; ?></td>     
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Full Name</td>
                    <td> <?php echo "$row[full_name]"; ?></td>
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Name with Initials</td>
                    <td><?php echo "$row[name_with_initials]"; ?></td>
                    
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Date of Birth</td>
                    <td><?php echo "$row[dob]"; ?></td>
                    
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Address</td>
                    <td><?php echo "$row[address]"; ?></td>
                    
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Mobile Number</td>
                    <td> <?php echo "$row[mobile]"; ?></td>
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>E-mail Address</td>
                    <td> <?php echo "$row[email]"; ?></td>
                   
                </tr>
                <tr style="width:50%; font-weight: 800; font-size: 20px;color: black ">
                    <td>Political Party</td>
                    <td> <?php echo "$row[party]"; ?></td>
                   
                </tr>
            </table>
        <br>
            <input type="text" name="mobile" id="mobile" hidden="" value='<?php echo $row['mobile']; ?>'>
            <input type="text" name="full_name" id="full_name" hidden="" value='<?php echo $row['full_name']; ?>'>
            <input type="text" name="party" id="party" hidden="" value='<?php echo $row['party']; ?>'>
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
        $full_name =$_POST['full_name'];
        $party= $_POST['party'];
        
        //insert candidate values to candidate_requests table
        $sql = "INSERT INTO candidate (ref_number,NIC,full_name,name_with_initials,dob,address,mobile,email,candidate_photo,party)
            SELECT  ref_number,NIC,full_name,name_with_initials,dob,address,mobile,email,candidate_photo,party
            FROM candidate_requests
            WHERE ref_number='$ref'";
        $result = mysqli_query($GLOBALS['conn'], $sql);


        //delete relavent result from candidate_requests table
        $sql_del = "DELETE FROM candidate_requests WHERE ref_number='$ref'";
        $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
        
        //Add candidate name the political_party table
        $sql_candidate="UPDATE political_party SET candidate='$full_name' WHERE party_name_short='$party'";
        $result_candidate= mysqli_query($GLOBALS['conn'], $sql_candidate);
        
        if (($result) AND ($result_del) AND ($result_candidate)) {
            sendsms_candidate_registration($mobile);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Successfull ",'
            . 'text: "Data Sved Successfully",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
        }
        mysqli_close($GLOBALS['conn']);
    }

    function rejectData() {

        $ref = $_SESSION['ref_number'];
        $comments = $_POST['re_comment'];

        $sql_mob = "SELECT mobile FROM candidate_requests WHERE ref_number='$ref' ";
        $result_mob = mysqli_query($GLOBALS['conn'], $sql_mob);
        if (mysqli_num_rows($result_mob) > 0) {
            while ($row = mysqli_fetch_assoc($result_mob)) {
                $mobile = $row['mobile'];
            }
        }
        //insert candidate_requests values to candidate_req_reject table
         $sql = "INSERT INTO candidate_req_reject (ref_number,NIC,full_name,name_with_initials,dob,address,mobile,email,candidate_photo,party,comment)
            SELECT  ref_number,NIC,full_name,name_with_initials,dob,address,mobile,email,candidate_photo,party,'$comments'
            FROM candidate_requests
            WHERE ref_number='$ref'";
        $result = mysqli_query($GLOBALS['conn'], $sql);

        //delete relavent result from candidate_requests table
        $sql_del = "DELETE FROM candidate_requests WHERE ref_number='$ref'";
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


