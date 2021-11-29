<?php
$title = 'Change Voters Residential Details';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php';

session_start();

$NIC = $_SESSION['NIC'];
$res = mysqli_query($conn, "SELECT * FROM voter_registration WHERE NIC='$NIC'");


if (isset($_POST['update'])) {

    updateData();
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <div ><a class="navbar-brand" href="voters_change_personnal_details.php.">&nbsp;&nbsp;Back</a></div>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
</br>
<div class="container">
    <div class="row">
        <div class="col-sm-3" >
        </div>

        <div class="col-sm-6" >
            <div class="style_form">
                <form  action="" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                    <br>
                    <br>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        ?>

                        <div class="mb-3">
                            <label for="InputNIC" class="form-label">NIC</label>
                            <input type="text" class="form-control"  id='nic' name='nic' readonly="" value='<?php echo "$row[NIC]"; ?>' >  
                        </div>

                        <div class="mb-3">
                            <label for="InputFull Name)" class="form-label">Full Name</label>
                            <input type="text" class="form-control"  id="full_name" name="full_name" readonly="" value="<?php echo "$row[full_name]"; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="InputPermanent Address" class="form-label">Permanent Address</label>
                            <input type="text" class="form-control" id="address"  name="address"  value="<?php echo "$row[address]"; ?>">
                        </div>                  
                        <div style='color:red'> <label id="err_address"></label> </div>


                        <!-- select province -->
                        <div class="mb-3">
                            <div ><label for="InputProvince" class="form-label">Province &nbsp; &nbsp;</label></div>
                            <select class="form-select" id="province" name="province" >   
                                <option  value="<?php echo "$row[province]"; ?>"><?php echo "$row[province]"; ?></option>
                            </select>
                        </div>
                        <div style='color:red'> <label id="err_province"></label> </div>


                        <!-- select Electoral District -->
                        <div class="mb-3">
                            <div><label for="InputElectoralDistrict" class="form-label">Electoral District &nbsp; &nbsp;</label></div>
                            <select class="form-select" id="district" name="district" > 
                                <?php echo "<option value=$row[e_district]>$row[e_district]</option>"; ?>
                            </select>
                        </div>    
                        <div style='color:red'> <label id="err_district"></label> </div>


                        <!-- Select Polling Division -->
                        <div class="mb-3">
                            <div><label for="InputPollingDivision " class="form-label">Polling Division  &nbsp; &nbsp;</label></div> 
                            <select class="form-select" id="division" name="division" >  
                                <?php echo "<option value=$row[p_division]>$row[p_division]</option>"; ?>
                            </select>
                        </div>
                        <div style='color:red'> <label id="err_division"></label> </div>


                        <!-- jQuery UI auto complete-->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                        <div class="mb-3">
                            <label for="InputGrama Niladhari Division" class="form-label">Grama Niladhari Division</label>
                            <input type="text" class="form-control" id="grama_niladari_division" name="grama_niladari_division"  value="<?php echo "$row[g_division]"; ?>">
                        </div>
                        <div style='color:red'> <label id="err_grama_niladari_division"></label> </div>


                        <div class="mb-3">
                            <label for="House Holders List No" class="form-label">House Holders List No</label>
                            <input type="text" class="form-control" id="house_no" name="house_no"  value="<?php echo "$row[house_no]"; ?>">
                        </div>
                        <div style='color:red'> <label id="err_house_no"></label> </div>
                        <input type="hidden"  id="old_gn" name="old_gn"  value="<?php echo "$row[g_division]"; ?>">

                        <?php
                    }
                    ?>

                    <br>
                    <div>
                        <input id="update" class="frm_btn btn btn-primary" type="submit" name="update" value="Submit" >
                    </div>

                </form>           
            </div>
        </div>
        <div class="col-sm-3" >
        </div>
    </div>

</div>
<br>
<?php

function updateData() {
    $nic_no = $_POST['nic'];
    $fullname = $_POST['full_name'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $division = $_POST['division'];
    $address = $_POST['address'];
    $grama_niladari_division = $_POST['grama_niladari_division'];
    $houseNo = $_POST['house_no'];
    $old_gn = $_POST['old_gn'];

    $validGn = getGNDivision_validity();
    if ($validGn) {
        $sql = "INSERT INTO voter_update_requests_residential(NIC,full_name,address,province,e_district, p_division,g_division,house_no) "
                . "VALUES ('$nic_no','$fullname','$address','$province','$district','$division', '$grama_niladari_division','$houseNo')";
        $result = mysqli_query($GLOBALS['conn'], $sql);

        $sql_gn = "UPDATE voter_update_requests_residential SET oldGNDivision='$old_gn' WHERE NIC='$nic_no'";

        $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);

        if (($result) AND ($result_gn)) {
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Request Sent ",'
            . 'text: "Your request send to futher processing ",'
            . 'type: "success"}, '
            . 'function() { window.location = "voters_portal.php";});}, 500);</script>';
        } else {
            TextNode("error", "Error occured. Please try again shortly");
        }
    } else {
        TextNode("error", 'Invalid Grama Niladhari Division.Please Select Valid Grama Niladhari Division ');
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
?>

<script src="js/js_voters_change_residential_details.js"></script>

<?php
require_once 'includes/footer.php';
