<?php
$title = 'officers_register_voters';
require_once 'includes/gs_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php';
session_start();

if (isset($_POST['create'])) {

    insertData();
}
?>

<?Php
$nic_no = @$_GET['nic'];
$fullname = @$_GET['full_name'];
$namewithinitials = @$_GET['name_with_initials'];
$gender = @$_GET['gender'];
$address = @$_GET['address'];
$c_address = @$_GET['current_address'];
$grama_niladari_division = @$_GET['grama_niladari_division'];
$houseNo = @$_GET['house_no'];
$mobileNo = @$_GET['mobile_no'];
$password = @$_GET['password'];


$quer2 = "SELECT DISTINCT `ProvinceNo`,`Province` FROM `province` ORDER BY `Province`;";
$province = filter_input(INPUT_GET, 'province');

$res_province_no = mysqli_query($conn, "SELECT DISTINCT ProvinceNo FROM province WHERE Province='$province'");
while ($row = mysqli_fetch_array($res_province_no)) {
    $quer = "SELECT DISTINCT `districtNo`,`district` FROM `e_district` WHERE `ProvinceNo`='$row[ProvinceNo]' ORDER BY `district`";
}

$district = @$_GET['district'];
$res_district_no = mysqli_query($conn, "SELECT districtNo FROM e_district WHERE district='$district'");
while ($row = mysqli_fetch_array($res_district_no)) {
    $quer3 = "SELECT DISTINCT `division_No`,`division` FROM `p_division` WHERE `districtNo`='$row[districtNo]' ORDER BY `division`";
}
$division = @$_GET['division'];
?>
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="gs_dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>

    <div class="container text-center style_form col-sm-10">
        <h2 class="py-2 bg-dark text-white rounded"><i class="fa fa-users" aria-hidden="true">&nbsp;</i>Register Voters</h2>
        <br>
        <div class="d-flex p-2 justify-content-center">

            <form id="reg_voters" action="" method="POST" class="w-50" onsubmit="return checkForm(this);">
                <div class="pt-1">
                    <?php inputElementManageUser_id("Reference Number", "<i class='fas fa-id-badge'></i>", "", "ref_no", setid(), "ref_no"); ?>                   
                </div>
                <br>
                <div class="pt-1">
                    <?php inputElementManageUser_id("NIC No", "<i class='fas fa-id-badge'></i>", "NIC&nbsp;No", "nic", "$nic_no", "val()", "nic"); ?>                   
                </div>
                <div style='color:red'> <label id="err_nic"></label> </div>

                <div class="pt-1">
                    <?php inputElementManageUser("Full Name", "<i class='fas fa-user'></i>", "Full&nbsp;Name", "full_name", "$fullname"); ?>
                </div>
                <div style='color:red'> <label id="err_full_name"></label> </div>

                <div class="pt-1">
                    <?php inputElementManageUser("Name with Initials", "<i class='fas fa-user'></i>", "Name&nbsp;with&nbsp;Initials", "name_with_initials", "$namewithinitials"); ?>
                </div>
                <div style='color:red'> <label id="err_name_with_initials"></label> </div>

                <div class="pt-1">
                    <div class="input-group">
                        <div class="input-group-text bg-warning">Gender &nbsp;<i class='fas fa-id-badge'></i></div>
                        <select class="form-select" id="gender" name="gender" value="" required="">

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

                <!-- select province -->
                <div class="pt-2">
                    <div class="input-group">
                        <div class="input-group-text bg-warning">Province &nbsp;<i class='fa fa-map-marker'></i>
                        </div> 
                        <select class="form-select" id="province" name="province" onchange="reload1(this.form)">
                            <option value="" style="font-size: 12px" selected="" >--Select--</option>
                            <?php
                            foreach ($conn->query($quer2) as $sel) {
                                if ($sel['Province'] == @$province) {
                                    echo "<option selected value='$sel[Province]'>$sel[Province]</option>" . "<BR>";
                                } else {
                                    echo "<option value='$sel[Province]'>$sel[Province]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div style='color:red'> <label id="err_province"></label> </div>

                <!-- select Electoral District -->
                <div class="pt-3">
                    <div class="input-group">
                        <div class="input-group-text bg-warning">Electoral District &nbsp;<i class='fa fa-map-marker'></i>
                        </div> 
                        <select class="form-select" id="district" name="district" onchange="reload3(this.form)">
                            <option value="" style="font-size: 12px" >--Select--</option>
                            <?php
                            foreach ($conn->query($quer) as $sel) {
                                if ($sel['district'] == @$district) {
                                    echo "<option selected value='$sel[district]'>$sel[district]</option>" . "<BR>";
                                } else {
                                    echo "<option value='$sel[district]'>$sel[district]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>    
                <div style='color:red'> <label id="err_district"></label> </div>

                <!-- select Polling Division -->
                <div class="pt-3">
                    <div class="input-group">
                        <div class="input-group-text bg-warning">Polling Division &nbsp;<i class='fa fa-map-marker'></i>
                        </div> 
                        <select class="form-select" id="division" name="division">
                            <option value="" style="font-size: 12px">--Select--</option>
                            <?php
                            foreach ($conn->query($quer3) as $sel) {
                                echo "<option value='$sel[division]'>$sel[division]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div style='color:red'> <label id="err_division"></label> </div>
                <!-- jQuery UI auto complete-->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <div class="pt-2"  id="gn_divisions">
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
                    <div class="pt-1">


                        <?php
                        $str = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";
                        $str = str_shuffle($str);
                        $str = substr($str, 0, 4);
                        $str_num = "123456789";
                        $str_num = str_shuffle($str_num);
                        $str_num = substr($str_num, 0, 4);
                        $password = $str_num . $str;
                        ?>

                        <div class="pt-2">
                            <?php inputElementManageUser_idp("Password", "<i class='fas fa-lock'></i>", "Password", "password", "$password", "password"); ?>


                            <div class="d-flex justify-content-center ">

                                <button type="submit" class="frm_btn btn btn-primary" id="btn_submit" name="create" >Register</button>
                            </div>

                            </form>           
                        </div> 
                    </div>     
                </div>
                
                <br>

                <?php

                function getData() {
                    $sql = "SELECT v_ref FROM ref_numbers";

                    $result = mysqli_query($GLOBALS['conn'], $sql);
                    if (mysqli_num_rows($result) > 0) {
                        return $result;
                    }
                }

                function setid() {
                    $getId = getData();
                    $userid = 0;
                    if ($getId) {
                        while ($row = mysqli_fetch_assoc($getId)) {
                            $userid = $row['v_ref'];
                        }
                    }
                    return ($userid + 1);
                }

                function insertData() {
                    $ref_no = $_POST['ref_no'];
                    $nic_no = $_POST['nic'];
                    $fullname = $_POST['full_name'];
                    $namewithinitials = $_POST['name_with_initials'];
                    $gender = $_POST['gender'];
                    $address = $_POST['address'];
                    $c_address = $_POST['current_address'];
                    $province = trim($_POST['province']);
                    $district = trim($_POST['district']);
                    $division = trim($_POST['division']);
                    $grama_niladari_division = $_POST['grama_niladari_division'];
                    $houseNo = $_POST['house_no'];
                    $mobileNo = $_POST['mobile_no'];
                    $password = $_POST['password'];


                    $nic_check = "SELECT *  FROM voter_registration WHERE LOWER(NIC)= LOWER('$nic_no')";
                    $result_nic_check = mysqli_query($GLOBALS['conn'], $nic_check);

                    if (mysqli_num_rows($result_nic_check) > 0) {
                        TextNode("error", 'Entered NIC Number Already Added to the System');
                    } else {
                        $sql = "INSERT INTO voter_registration(ref_number,NIC, "
                                . "full_name,name_with_initials,gender, "
                                . "address,current_address,province,e_district,p_division,g_division,"
                                . "house_no,mobile_no,username,password,status) "
                                . "VALUES ($ref_no,'$nic_no','$fullname','$namewithinitials',"
                                . "'$gender','$address','$c_address','$province','$district',"
                                . "'$division','$grama_niladari_division','$houseNo','$mobileNo','$nic_no','$password','Successfully Registered')";

                        if (mysqli_query($GLOBALS['conn'], $sql)) {
                            sendsms_registation_success($mobileNo, $nic_no, $password);
                            $query_up = "UPDATE ref_numbers SET v_ref=' $ref_no' WHERE id=1";
                            mysqli_query($GLOBALS['conn'], $query_up);
                            echo ' <script>setTimeout(function() '
                            . '{swal({title: "Registation Successfull ",'
                            . 'text: "Data Inserted Successfully",'
                            . 'type: "success"}, '
                            . 'function() { window.location = "gs_dashboard.php";});}, 500);</script>';
                        } else {
                            TextNode("error", 'Error Occured, Provide Necessary Data');
                        }
                    }
                }
                ?>

                <script src="../js/js_officer_register_voters.js"></script>
                <?php
                require_once 'includes/gs_footer.php';
                