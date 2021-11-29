<?php
$title = 'officers_update_delete_voters';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php';

session_start();
$NIC = $_SESSION['NIC'];

function getData() {
    $nic_no = $_SESSION['NIC'];
    $sql = "SELECT * FROM voter_registration WHERE NIC='$nic_no' ";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}
?>
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<?php
if (isset($_POST['edit'])) {
    updateData();
}

if (isset($_POST['delete'])) {
    deleteData();
}
?>


    <div class="container text-center style_form col-sm-10">
        <h2 class="py-2 bg-dark text-white rounded"><i class="fa fa-users" aria-hidden="true">&nbsp;</i>Manage Voters</h2>

        <div class="d-flex p-2 justify-content-center">
            <form id="reg_voters" action="" method="POST" class="w-50" onsubmit="return checkForm(this);">


                <?php
                $result = getData();
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ID = $row['ref_number'];
                        $nic = $row['NIC'];
                        $full_name = $row['full_name'];
                        $namewithinitials = $row['name_with_initials'];
                        $gender = $row['gender'];
                        $address = $row['address'];
                        $c_address = $row['current_address'];
                        $grama_niladari_division = $row['g_division'];
                        $houseNo = $row['house_no'];
                        $mobileNo = $row['mobile_no'];
                        $province = $row['province'];
                        $district = $row['e_district'];
                        $division = $row['p_division'];
                        $password = $row['password'];
                        $username = $row['username'];
                        ?>
                        <input type="hidden" id="Id" name="ID" value='<?php echo $ID ?>'>

                        <div class="pt-1">
                            <?php inputElementManageUser("NIC No", "<i class='fas fa-id-badge'></i>", "NIC&nbsp;No", "nic", "$nic"); ?>
                        </div>
                        <div style='color:red'> <label id="err_nic"></label> </div>

                        <div class="pt-1">
                            <?php inputElementManageUser("Full Name", "<i class='fas fa-user'></i>", "Full&nbsp;Name", "full_name", "$full_name"); ?>
                        </div>
                        <div style='color:red'> <label id="err_full_name"></label> </div>

                        <div class="pt-1">
                            <?php inputElementManageUser("Name with Initials", "<i class='fas fa-user'></i>", "Name&nbsp;with&nbsp;Initials", "name_with_initials", "$namewithinitials"); ?>
                        </div>
                        <div style='color:red'> <label id="err_name_with_initials"></label> </div>

                        <div class="pt-1">
                            <div class="input-group">
                                <div class="input-group-text bg-warning">Gender &nbsp;<i class='fas fa-id-badge'></i></div>
                                <select class="form-select" id="gender" name="gender" value="" >

                                    <?php
                                    if ($gender == null) {
                                        echo "<option selected>--Select--</option>";
                                        echo "<option value=1>Male</option>";
                                        echo "<option value=2>Female</option>";
                                    } else {
                                        echo "<option selected value='$gender'>$gender</option>" . "<BR>";
                                        echo "<option value=1>Male</option>";
                                        echo "<option value=2>Female</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div style='color:red'> <label id="err_gender"></label> </div>

                        <div class="pt-4">
                            <?php inputElementManageUser("Permanent Address", "<i class='fa fa-envelope-open'></i>", "Address", "address", "$address"); ?>
                        </div>
                        <div style='color:red'> <label id="err_address"></label> </div>

                        <div class="pt-4">
                            <?php inputElementManageUser("Current Address", "<i class='fa fa-envelope-open'></i>", "Current&nbsp;Address", "current_address", "$c_address"); ?>
                        </div>
                        <div style='color:red'> <label id="err_current_address"></label> </div>

                        <!-- jQuery UI auto complete-->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                        <div class="pt-3">
                            <?php inputElementManageUser_id("Grama Niladhari Division", "<i class='fa fa-map-o'></i>", "Grama&nbsp;Niladhari&nbsp;Division", "grama_niladari_division", "$grama_niladari_division", "grama_niladari_division"); ?>
                        </div>
                        <div style='color:red'> <label id="err_grama_niladari_division"></label> </div>

                        <div class="pt-1">
                            <?php inputElementManageUser("House Holders List No", "<i class='fa fa-home'></i>", "House&nbsp;Holders&nbsp;List&nbsp;No", "house_no", "$houseNo"); ?>
                        </div>
                        <div style='color:red'> <label id="err_house_no"></label> </div>

                        <div class="pt-1">
                            <?php inputElementManageUser("Mobile No", "<i class='fa fa-mobile' aria-hidden='true'></i>", "Mobile&nbsp;No", "mobile_no", "$mobileNo"); ?>
                        </div>
                        <div style='color:red'> <label id="err_mobile_no"></label> </div>

                        <div class="pt-2">
                            <div class="input-group">
                                <div class="input-group-text bg-warning">Province &nbsp;<i class='fa fa-map-marker'></i>
                                </div> 
                                <select class="form-select" id="province" name="province" >   
                                    <?php echo "<option value=$province>$province</option>"; ?>
                                </select>
                            </div>
                        </div> 

                        <br>
                        <div class="pt-2">
                            <div class="input-group">
                                <div class="input-group-text bg-warning">Electoral District &nbsp;<i class='fa fa-map-marker'></i>
                                </div> 
                                <select class="form-select" id="district" name="district" > 
                                    <?php
                                    echo "<option value='$district'>$district</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div style='color:red'> <label id="err_district"></label> </div>

                        <br>

                        <div class="pt-2">
                            <div class="input-group">
                                <div class="input-group-text bg-warning">Polling Division &nbsp;<i class='fa fa-map-marker'></i>
                                </div> 
                                <select class="form-select" id="division" name="division" >  
                                    <?php
                                    echo "<option value=$division>$division</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                       <div style='color:red'> <label id="err_division"></label> </div>

                        <br>
                        <div class="pt-1">
                            <?php inputElementManageUser("Username", "<i class='fa fa-mobile' aria-hidden='true'></i>", "User&nbsp;Name", "username", "$username"); ?>
                        </div>
                        <div style='color:red'> <label id="err_username"></label> </div>
                        
                        <div class="pt-2">
                            <div class="input-group">
                                <div class="input-group-text bg-warning">Password &nbsp;<i class='fas fa-lock'></i>
                                </div> 
                                <input type="password" class="form-control" id='password' name='password' value='<?php echo $password ?>' >
                            </div>
                        </div>
                        <div style='color:red'> <label id="err_password"></label> </div>
                        <?php
                    }
                }
                ?>                
                <div class="pt-1">
                    <div class="d-flex justify-content-center ">
                        <button type="submit" class="frm_btn btn btn-primary" name="edit">Update</button>
                        <button type="button" class="frm_btn btn btn-primary"  data-toggle="modal" data-target="#reject">Delete</button>
                    </div>                
            </form> 

        </div>

    </div>

</div>

<br>



<?php

function updateData() {

    $ID = $_POST['ID'];
    $NIC = $_POST['nic'];
    $full_name = $_POST['full_name'];
    $namewithinitials = $_POST['name_with_initials'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $c_address = $_POST['current_address'];
    $grama_niladari_division = $_POST['grama_niladari_division'];
    $houseNo = $_POST['house_no'];
    $mobileNo = $_POST['mobile_no'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $division_e = $_POST['division'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    if ($gender == 1) {
        $gender = "Male";
    } else {
        $gender = "Female";
    }
    $validGn = getGNDivision_validity();
    if ($validGn) {

        $sql = " UPDATE voter_registration SET `NIC`='$NIC',full_name='$full_name',name_with_initials='$namewithinitials',"
                . "gender='$gender',address='$address',current_address='$c_address',g_division='$grama_niladari_division',"
                . "house_no='$houseNo',mobile_no='$mobileNo',province='$province',e_district='$district',"
                . "p_division='$division_e',username='$username',password='$password' WHERE ref_number='$ID '";


        if (mysqli_query($GLOBALS['conn'], $sql)) {

            sendsms_officer__update($mobileNo, $username, $password);

            echo ' <script>setTimeout(function() '
            . '{swal({title: "Updated Successfully ",'
            . 'text: "Data Updated Successfully",'
            . 'type: "success"}, '
            . 'function() { window.location = "officer_dashboard.php";});}, 500);</script>';
        } else {
            TextNode("error", "Error occured. Please try again shortly");
        }
    } else {
        TextNode("error", 'Invalid Grama Niladhari Division.Please Select Valid Grama Niladhari Division');
    }
}

function getGNDivision_validity() {
    $division = trim($_POST['division']);
    $grama_niladari_division = $_POST['grama_niladari_division'];

    $sql_gn = "select gn_division_No FROM gn_division WHERE `gn_division`='$grama_niladari_division' ";
    $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);
    if (mysqli_num_rows($result_gn) > 0) {


        $sql_p = "SELECT division_No FROM p_division WHERE division='$division'";
        $result_p = mysqli_query($GLOBALS['conn'], $sql_p);
        if (mysqli_num_rows($result_p) > 0) {
            while ($row = mysqli_fetch_assoc($result_p)) {
                $p_division_no = $row['division_No'];
            }
        }
        $sql = "SELECT division_No FROM gn_division WHERE gn_division='$grama_niladari_division'";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ent_division_no = $row['division_No'];
            }
        }

        if ($ent_division_no == $p_division_no) {
            return true;
        }
    }
}

function deleteData() {
    $NIC = $_SESSION['NIC'];

$result_delete = mysqli_query($GLOBALS['conn'], "DELETE FROM voter_registration WHERE NIC='$NIC'");

if ($result_delete) {
    echo ' <script>setTimeout(function() '
    . '{swal({title: "Details Deleted ",'
    . 'text: "Data Deleted Successfully",'
    . 'type: "success"}, '
    . 'function() { window.location = "officer_dashboard.php";});}, 500);</script>';
}
}
?>
<!-- Create Bootstrap model for delete -->

<div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header model_background">
                <h5 class="modal-title" id="exampleModalCenterTitle">Delete Voter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body model_background">
                <form action=""  method="POST">

                    <p> Are you sure about delete the voter details? </P>  <br>     

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning" id="delete" name="delete">Delete </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of the Model -->

<script src="../js/js_officer_manage_voters.js"></script>

<?php
require_once 'includes/admin_footer.php';
