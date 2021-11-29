<?php
$title = 'Officer Registration';
require_once 'includes/header.php';
require_once 'php/componenet.php';
include_once 'db/config.php';


if (isset($_POST['gn_register'])) {
    insertGNData();
}
if (isset($_POST['d_register'])) {
    insertDistrictOfficerData();
}
if (isset($_POST['ec_register'])) {
    insertECData();
}
?> 

<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="officers_Login.php">&nbsp;&nbsp;Back</a>
            </li>    
        </ul>
    </div> 
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-3" >

        </div>
        <!--select registration type-->
        <div class="col-sm-6 style_form" >
            <div><img src="images/party.jpg" width="100%" height="250" align="center" ></div> 

            <div class="pt-2">
                <div class="input-group style_form">
                    <div class="input-group-text bg-warning">Register As &nbsp;</div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <select  class="form-select" id="user_level" name="user_level">
                        <option  value="">----------------------Please Select---------------------</option>
                        <option value="1">Grama Niladhari</option>
                        <option value="2">District Officer</option>
                        <option value="3">Election Commission Officer</option>
                    </select>
                </div>
            </div>
            <br>
            <br>
            <!--Register Grama Niladhari-->
            <form method="POST" id="form-1" action="" onsubmit="return checkForm(this);" style="display:none;" class="user-level-form login_officers_form">

                <div class="form-group">
                    <label for="inputref">Reference Number</label>
                    <input type="text" class="form-control" id="gn_refnumber" name="gn_refnumber" placeholder="" readonly value='<?php echo setid(); ?>' >
                </div>

                <div class="form-group">
                    <label for="inputName">Name with initials</label>
                    <input type="text" class="form-control" id="gn_name_with_initials" name="gn_name_with_initials" placeholder="">
                </div>
                <div style='color:red'> <label id="gn_err_name"></label> </div>

                <div class="form-group">
                    <label for="inputNIC">NIC Number</label>
                    <input type="text" class="form-control" id="gn_NIC" name="gn_NIC" placeholder="">
                </div>
                <div style='color:red'> <label id="gn_err_nic"></label> </div>

                <div class="form-group">
                    <label for="inputMobile">Mobile Number</label>
                    <input type="text" class="form-control" id="gn_mobile_number" name="gn_mobile_number" placeholder="">
                </div>
                <div style='color:red'> <label id="gn_err_mob"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="gn_password" name="gn_password" placeholder="">
                </div>
                <div style='color:red'> <label id="gn_err_pass"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Re-Enter Password</label>
                    <input type="password" class="form-control" id="gn_re_password" name="gn_re_password" placeholder="">
                </div>
                <div style='color:red'> <label id="gn_err_rpass"></label> </div>

                <!-- jQuery UI auto complete-->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <div class="form-group">
                    <label for="inputGNDivision">GN Division</label>
                    <input type="text" class="form-control" id="search_gn_division" name="search_gn_division" placeholder="Type to search...">
                </div>
                <div style='color:red'> <label id="gn_err_gndiv"></label> </div>

                <br>
                <input type="submit"  class="frm_btn btn btn-primary" name="gn_register" id="gn_register" value="Register" class="btn btn-info" />
            </form>


            <!--Register District Officer-->
            <form id="form-2" onsubmit="return checkForm_d(this);"  class="user-level-form login_officers_form" style="display:none;" method="POST" action="">
                <div class="form-group">
                    <label for="inputref">Reference Number</label>
                    <input type="text" class="form-control" id="d_refnumber" name="d_refnumber" placeholder="" readonly value=<?php echo setid(); ?> >
                </div>

                <div class="form-group">
                    <label for="inputName">Name with initials</label>
                    <input type="text" class="form-control" id="d_name_with_initials" name="d_name_with_initials" placeholder="">
                </div>
                <div style='color:red'> <label id="d_err_name"></label> </div>

                <div class="form-group">
                    <label for="inputNIC">NIC Number</label>
                    <input type="text" class="form-control" id="d_NIC" name="d_NIC" placeholder="">
                </div>
                <div style='color:red'> <label id="d_err_nic"></label> </div>

                <div class="form-group">
                    <label for="inputMobile">Mobile Number</label>
                    <input type="text" class="form-control" id="d_mobile_number" name="d_mobile_number" placeholder="">
                </div>
                <div style='color:red'> <label id="d_err_mob"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="d_password" name="d_password" placeholder="">
                </div>
                <div style='color:red'> <label id="d_err_pass"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Re-Enter Password</label>
                    <input type="password" class="form-control" id="d_re_password" name="d_re_password" placeholder="">
                </div>
                <div style='color:red'> <label id="d_err_rpass"></label> </div>

                <!-- jQuery UI auto complete-->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <div class="form-group">
                    <label for="inputDistrict">District</label>
                    <input type="text" class="form-control" id="search_d_division" name="search_d_division" placeholder="Type to search...">
                </div>
                <div style='color:red'> <label id="d_err_district"></label> </div>
                <br>

                <input type="submit" class="frm_btn btn btn-primary" name="d_register" id="d_register" value="Register" class="btn btn-info" />
            </form>


            <!--Register Election Commision Officer-->
            <form id="form-3" onsubmit="return checkForm_e(this);" class="user-level-form login_officers_form" style="display:none;" method="POST" action="">
                <div class="form-group">
                    <label for="inputref">Reference Number</label>
                    <input type="text" class="form-control" id="ec_refnumber" name="ec_refnumber" placeholder="" readonly value=<?php echo setid(); ?> >
                </div>

                <div class="form-group">
                    <label for="inputName">Name with initials</label>
                    <input type="text" class="form-control" id="ec_name_with_initials" name="ec_name_with_initials" placeholder="">
                </div>
                <div style='color:red'> <label id="e_err_name"></label> </div>

                <div class="form-group">
                    <label for="inputNIC">NIC Number</label>
                    <input type="text" class="form-control" id="ec_NIC" name="ec_NIC" placeholder="">
                </div>
                <div style='color:red'> <label id="e_err_nic"></label> </div>

                <div class="form-group">
                    <label for="inputMobile">Mobile Number</label>
                    <input type="text" class="form-control" id="ec_mobile_number" name="ec_mobile_number" placeholder="">
                </div>
                <div style='color:red'> <label id="ec_err_mob"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="ec_password" name="ec_password" placeholder="">
                </div>
                <div style='color:red'> <label id="e_err_pass"></label> </div>

                <div class="form-group">
                    <label for="inputPassword">Re-Enter Password</label>
                    <input type="password" class="form-control" id="ec_re_password" name="ec_re_password" placeholder="">
                </div>
                <div style='color:red'> <label id="e_err_rpass"></label> </div>
                <br>
                <input type="submit" class="frm_btn btn btn-primary" name="ec_register" id="ec_register" value="Register" class="btn btn-info" />

        </div >

        <div class="col-sm-4" > </div>
    </div>
</div>

<br>

<?php

function insertGNData() {
    $user_level = '3';
    $ref_number = $_POST['gn_refnumber'];
    $name_with_initials = $_POST['gn_name_with_initials'];
    $NIC = $_POST['gn_NIC'];
    $mobile = $_POST['gn_mobile_number'];
    $password = $_POST['gn_password'];
    $gn_division = $_POST['search_gn_division'];

    $sql_gn = "select gn_division_No FROM gn_division WHERE `gn_division`='$gn_division' ";
    $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);
    if (mysqli_num_rows($result_gn) > 0) {
        while ($row = mysqli_fetch_assoc($result_gn)) {
            $g_division = $row['gn_division_No'];
        }

        $sql_p = "SELECT `division_No` FROM `gn_division` WHERE `gn_division_No`='$g_division' ";
        $result_p = mysqli_query($GLOBALS['conn'], $sql_p);
        if (mysqli_num_rows($result_p) > 0) {
            while ($row = mysqli_fetch_assoc($result_p)) {
                $p_division = $row['division_No'];
            }
        }

        $sql_e = "SELECT districtNo FROM `p_division` WHERE `division_No`='$p_division' ";
        $result_e = mysqli_query($GLOBALS['conn'], $sql_e);
        if (mysqli_num_rows($result_e) > 0) {
            while ($row = mysqli_fetch_assoc($result_e)) {
                $e_division = $row['districtNo'];
            }
        }
        $query = "INSERT INTO req_reg_officer_gn (user_level,ref_number,name_with_initials,NIC,mobile_no,password,work_place,gn_division_no,p_division,district_no)"
                . "VALUES ('$user_level','$ref_number','$name_with_initials','$NIC','$mobile','$password','$gn_division','$g_division','$p_division','$e_division')";
        $result = mysqli_query($GLOBALS['conn'], $query);

        $query_up = "UPDATE ref_numbers SET officer_ref='$ref_number' WHERE id=1";
        $result_up = mysqli_query($GLOBALS['conn'], $query_up);

        if ($result AND $result_up) {
            sendsms_for_registation($mobile, $ref_number);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Completed Successfully ",'
            . 'text: "Registration details will send to your mobile number shortly",'
            . 'type: "success"}, '
            . 'function() { window.location = "index.php";});}, 500);</script>';
        }
        mysqli_close($GLOBALS['conn']);
    } else {
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Registation Unsuccessful ",'
        . 'text: "The GN division you entered does not exist.Please register again",'
        . 'type: "error"}, '
        . 'function() { window.location = "officers_Registration.php";});}, 500);</script>';
    }
}

function insertDistrictOfficerData() {
    $user_level = '2';
    $ref_number = $_POST['d_refnumber'];
    $name_with_initials = $_POST['d_name_with_initials'];
    $NIC = $_POST['d_NIC'];
    $mobile = $_POST['d_mobile_number'];
    $password = $_POST['d_password'];
    $district = $_POST['search_d_division'];

    $sql_d = "select districtNo FROM e_district  WHERE `district`='$district' ";
    $result_d = mysqli_query($GLOBALS['conn'], $sql_d);
    if (mysqli_num_rows($result_d) > 0) {
        while ($row = mysqli_fetch_assoc($result_d)) {
            $district_no = $row['districtNo'];
        }
        $query = "INSERT INTO req_reg_officer_d (user_level,ref_number,name_with_initials,NIC,mobile_no,password,district,district_no)"
                . "VALUES ('$user_level','$ref_number','$name_with_initials','$NIC','$mobile','$password','$district','$district_no')";
        $result = mysqli_query($GLOBALS['conn'], $query);

        $query_up = "UPDATE ref_numbers SET officer_ref='$ref_number' WHERE id=1";
        $result_up = mysqli_query($GLOBALS['conn'], $query_up);

        if ($result AND $result_up) {
            sendsms_for_registation($mobile, $ref_number);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Completed Successfully ",'
            . 'text: "Registration details will send to your mobile number shortly",'
            . 'type: "success"}, '
            . 'function() { window.location = "index.php";});}, 500);</script>';
        }
        mysqli_close($GLOBALS['conn']);
    } else {
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Registation Unsuccessful ",'
        . 'text: "The district you entered does not exist.Please register again",'
        . 'type: "error"}, '
        . 'function() { window.location = "officers_Registration.php";});}, 500);</script>';
    }
}

function insertECData() {
    $user_level = '1';
    $ref_number = $_POST['ec_refnumber'];
    $name_with_initials = $_POST['ec_name_with_initials'];
    $NIC = $_POST['ec_NIC'];
    $mobile = $_POST['ec_mobile_number'];
    $password = $_POST['ec_password'];

    $query = "INSERT INTO req_reg_officer (user_level,ref_number,name_with_initials,NIC,mobile_no,password)"
            . "VALUES ('$user_level','$ref_number','$name_with_initials','$NIC','$mobile','$password')";

    $result = mysqli_query($GLOBALS['conn'], $query);

    $query_up = "UPDATE ref_numbers SET officer_ref='$ref_number' WHERE id=1";
    $result_up = mysqli_query($GLOBALS['conn'], $query_up);

    if ($result AND $result_up) {
        sendsms_for_registation($mobile, $ref_number);
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Registation Completed Successfully ",'
        . 'text: "Registration details will send to your mobile number shortly",'
        . 'type: "success"}, '
        . 'function() { window.location = "index.php";});}, 500);</script>';
    }
    mysqli_close($GLOBALS['conn']);
}

function getData() {
    $sql = "SELECT officer_ref FROM ref_numbers";

    $result = mysqli_query($GLOBALS['conn'], $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}

//set id
function setid() {
    $getId = getData();
    $userid = 0;
    if ($getId) {
        while ($row = mysqli_fetch_assoc($getId)) {
            $userid = $row['officer_ref'];
        }
    }
    return ($userid + 1);
}
?>

<script src="js/js_oficers_registration.js"></script>

<?php
require_once 'includes/footer.php';
