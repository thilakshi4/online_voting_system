<?php
$title = 'officers_register_voters';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php';
session_start();

if (isset($_POST['create'])) {
    insertData();
}
?>

<body>
    <?Php
    $nic_no = @$_GET['NIC'];
    $fullname = @$_GET['full_name'];
    $namewithinitials = @$_GET['name_with_initials'];
    $gender = @$_GET['gender'];
    $address = @$_GET['address'];
    $c_address = @$_GET['current_address'];
    $grama_niladari_division = @$_GET['grama_niladari_division'];
    $houseNo = @$_GET['house_no'];
    $mobileNo = @$_GET['mobile_no'];

    $quer2 = "SELECT DISTINCT `ProvinceNo`,`Province` FROM `province` ORDER BY `Province`;";
//$province= @$_GET['province'];
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
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="navbar-brand" href="Login_voter.php">&nbsp;Back</a>
                </li>    
            </ul>
        </div> 
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm-4" >

            </div>
            <div class="col-sm-5" >
                <div class="style_form">
                    <form id="reg_voters" action="" method="POST" onsubmit="return checkForm(this);" >
                        <div class="mb-3">
                            <label for="InputReference" class="form-label">Reference Number</label>
                            <input type="text" class="form-control"  id="ref_no" name="ref_no" readonly value="<?php echo setid(); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="InputNIC No" class="form-label">NIC No</label>
                            <input type="text" class="form-control"  id="nic" name="nic" value="<?php echo $nic_no; ?>">
                        </div>
                        <div style='color:red'> <label id="err_nic"></label> </div>

                        <div class="mb-3">
                            <label for="InputFull Name)" class="form-label">Full Name</label>
                            <input type="text" class="form-control"  id="full_name" name="full_name" value="<?php echo $fullname; ?>">
                        </div>
                        <div style='color:red'> <label id="err_full_name"></label> </div>


                        <div class="mb-3">
                            <label for="InputName with Initials" class="form-label"> Name with Initials</label>
                            <input type="text" class="form-control"  id="name_with_initials" name="name_with_initials" value="<?php echo $namewithinitials; ?>">
                        </div>
                        <div style='color:red'> <label id="err_name_with_initials"></label> </div>


                        <div class="mb-3">
                            <div ><label for="InputGender" class="form-label">Gender &nbsp; &nbsp;</label></div>
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
                        <div style='color:red'> <label id="err_gender"></label> </div>


                        <div class="mb-3">
                            <label for="InputPermanent Address" class="form-label">Permanent Address</label>
                            <input type="text" class="form-control" id="address"  name="address"  value="<?php echo $address; ?>">
                        </div>  
                        <div style='color:red'> <label id="err_address"></label> </div>

                        <div class="mb-3">
                            <label for="InputCurrent Address" class="form-label">Current Address</label>
                            <input type="text" class="form-control" id="current_address" name="current_address" value="<?php echo $c_address; ?>">
                        </div> 
                        <div style='color:red'> <label id="err_current_address"></label> </div>

                        <!-- select province -->
                        <div class="mb-3">
                            <div ><label for="InputProvince" class="form-label">Province &nbsp; &nbsp;</label></div>
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

                        <div style='color:red'> <label id="err_province"></label> </div>
                        <!-- select Electoral District -->
                        <div class="mb-3">
                            <div><label for="InputElectoralDistrict" class="form-label">Electoral District &nbsp; &nbsp;</label></div>
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

                        <div style='color:red'> <label id="err_district"></label> </div>
                        <!-- select Polling Division -->
                        <div class="mb-3">
                            <div><label for="InputPollingDivision " class="form-label">Polling Division  &nbsp; &nbsp;</label></div> 
                            <select class="form-select" id="division" name="division">
                                <option value="" style="font-size: 12px">--Select--</option>
                                <?php
                                foreach ($conn->query($quer3) as $sel) {
                                    echo "<option value='$sel[division]'>$sel[division]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div style='color:red'> <label id="err_division"></label> </div>
                        
                        <!-- jQuery UI auto complete-->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                        <div class="mb-3">
                            <label for="InputGrama Niladhari Division" class="form-label">Grama Niladhari Division</label>
                            <input type="text" class="form-control" id="grama_niladari_division" name="grama_niladari_division"  value="<?php echo $grama_niladari_division; ?>">
                        </div>

                        <div style='color:red'> <label id="err_grama_niladari_division"></label> </div>
                        <div class="mb-3">
                            <label for="House Holders List No" class="form-label">House Holders List No</label>
                            <input type="text" class="form-control" id="house_no" name="house_no"  value="<?php echo $houseNo; ?>">
                        </div>

                        <div style='color:red'> <label id="err_house_no"></label> </div>
                        <div class="mb-3">
                            <label for="InputMobileNo" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $mobileNo; ?>">
                        </div>

                        <div style='color:red'> <label id="err_mobile_no"></label> </div>
                        <div class="pt-1">

                            <div class="d-flex justify-content-center ">

                                <button type="submit" class="frm_btn btn btn-primary" id="btn_submit" name="create" >Register</button>
                            </div>
                    </form>           
                </div>
            </div>
            <div class="col-sm-4" >
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
        $reference_no = $_POST['ref_no'];


        $nic_check = "SELECT *  FROM voter_registration WHERE LOWER(NIC)= LOWER('$nic_no')";
        $result_nic_check = mysqli_query($GLOBALS['conn'], $nic_check);

        if (mysqli_num_rows($result_nic_check) > 0) {
            TextNode("error", 'Entered NIC Number Already Registered with the System.');
        } else {
            $validGn = getGNDivision_validity();
            if ($validGn) {
                $sql = "INSERT INTO voter_reg_requests(ref_number,NIC, "
                        . "full_name,name_with_initials,gender, "
                        . "address,current_address,province,e_district,p_division,g_division,"
                        . "house_no,mobile_no) "
                        . "VALUES ('$reference_no','$nic_no','$fullname','$namewithinitials',"
                        . "'$gender','$address','$c_address','$province','$district',"
                        . "'$division','$grama_niladari_division','$houseNo','$mobileNo')";

                if (mysqli_query($GLOBALS['conn'], $sql)) {

                    sendsms_for_registation($mobileNo, $reference_no);
                    $query_up = "UPDATE ref_numbers SET v_ref=' $reference_no' WHERE id=1";
                    $result_up = mysqli_query($GLOBALS['conn'], $query_up);
                    echo ' <script>setTimeout(function() '
                    . '{swal({title: "Registation Successfull ",'
                    . 'text: "Data Inserted Successfully",'
                    . 'type: "success"}, '
                    . 'function() { window.location = "index.php";});}, 500);</script>';
                } else {
                    TextNode("error", 'Error Occured, Provide Necessary Data');
                }
            } else {
                TextNode("error", 'Invalid Grama Niladhari Division.Please Select Valid Grama Niladhari Division ');
            }
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
    
$result_del
    ?>
    <script src="js/js_register_voter.js"></script>

    <?php
    require_once 'includes/footer.php';
    