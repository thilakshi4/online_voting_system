<?php
$title = 'Register Political Party';
session_start();
require_once 'includes/header.php';
require_once 'php/componenet.php';
include_once 'db/config.php';

if (isset($_POST['insert'])) {
    insertData();
}
?>  
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="political_party_portal.php">&nbsp;Back</a>
            </li>    
        </ul>
    </div> 
</nav>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>
        <div class="col-sm-5" >
            <div class="style_form">
                <form method="POST" action="" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                    <div class="mb-3">
                        <label for="InputReference" class="form-label">Reference Number</label>
                        <input type="text" class="form-control"  id="ref_no" name="ref_no" readonly value="<?php echo setid(); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="InputPolitical Party(Full Name)" class="form-label">Political Party(Full Name)</label>
                        <input type="text" class="form-control"  id="ppfullname" name="ppfullname" >
                    </div>
                    <div style='color:red'> <label id="err_ppfullname"></label> </div>

                    <div class="mb-3">
                        <label for="InputPolitical Party(Short Name)" class="form-label"> Abbreviation&nbsp;(Political Party Short Name)</label>
                        <input type="text" class="form-control"  id="ppshortname" name="ppshortname" >
                    </div>
                    <div style='color:red'> <label id="err_ppshortname"></label> </div>

                    <div class="mb-3">
                        <label for="InputPolitical Party Symbol" class="form-label">Political Party Symbol </label>
                        <input type="file" class="form-control" name="image" id="image" />
                    </div> 
                    <div style='color:red'> <label id="err_image"></label> </div>

                    <div class="mb-3">
                        <label for="InputColorCode" class="form-label">Party Color</label>
                        <div class="form-control">
                            <input class=" form-control text-center" type="text" value="Please Select Your Party Color" aria-label="readonly input example" readonly>
                            <input class="form-control" type="color"   id="favcolor" name="favcolor" value="#a8aaad" >
                        </div> 
                        <div style='color:red'> <label id="err_favcolor"></label> </div>

                    </div>                                    
                    <div class="mb-3">
                        <label for="InputPresidentName" class="form-label">General Secretary</label>
                        <input type="text" class="form-control" id="prsedient_name"  name="prsedient_name" >
                    </div>
                    <div style='color:red'> <label id="err_prsedient_name"></label> </div>

                    <div class="mb-3">
                        <label for="InputNIC" class="form-label">NIC</label>
                        <input type="text" class="form-control" id="NIC" name="NIC" >
                    </div>
                    <div style='color:red'> <label id="err_NIC"></label> </div>

                    <div class="mb-3">
                        <label for="InputMobileNo" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" >
                    </div>
                    <div style='color:red'> <label id="err_mobile"></label> </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" >
                    </div>
                    <div style='color:red'> <label id="err_address"></label> </div>


                    <br />  
                    <input type="submit" class="frm_btn btn btn-primary" name="insert" id="insert" value="Register" />
                </form>
            </div>
        </div>
        <div class="col-sm-4" >
        </div>
    </div>
</div>
<br>
<?php

function setid() {
    $sql = "SELECT pp_ref FROM ref_numbers";

    $getId = mysqli_query($GLOBALS['conn'], $sql);

    $userid = 0;
    if ($getId) {
        while ($row = mysqli_fetch_assoc($getId)) {
            $userid = $row['pp_ref'];
        }
    }
    return ($userid + 1);
}

function insertData() {

    $ref_number = $_POST['ref_no'];
    $party_full_name = $_POST['ppfullname'];
    $party_short_name = $_POST['ppshortname'];
    $president_name = $_POST['prsedient_name'];
    $NIC = $_POST['NIC'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $color_code = $_POST['favcolor'];
    $sql = "SELECT *  FROM political_party WHERE LOWER(party_name_short)= LOWER('$party_short_name')";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    $sql_pnl = "SELECT *  FROM political_party WHERE LOWER(party_name_long)= LOWER('$party_full_name')";
    $result_pnl = mysqli_query($GLOBALS['conn'], $sql_pnl);


    if (mysqli_num_rows($result) > 0) {
        TextNode("error", 'Your Party Abbreviation Name Already Taken, Try Another One');
    } elseif (mysqli_num_rows($result_pnl) > 0) {
        TextNode("error", 'Your Party Name Already Taken, Try Another One');
    } else {
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $query = "INSERT INTO req_reg_political_party (ref_number,party_name_long,party_name_short,party_logo,"
                . "colour,party_president_name,party_president_NIC,contact_no,adress)"
                . "VALUES ('$ref_number','$party_full_name','$party_short_name','$file','$color_code',"
                . "'$president_name','$NIC','$mobile','$address')";

        if (mysqli_query($GLOBALS['conn'], $query)) {

            $query_up = "UPDATE ref_numbers SET pp_ref='$ref_number' WHERE id=1";
            mysqli_query($GLOBALS['conn'], $query_up);
            $_SESSION['status_success'] = "Data inserted successfully";
            sendsms_for_registation($mobile, $ref_number);
            echo ' <script>setTimeout(function() '
            . '{swal({title: "Registation Completed Successfully ",'
            . 'text: "Registration details  will send to your mobile number shortly",'
            . 'type: "success"}, '
            . 'function() { window.location = "index.php";});}, 500);</script>';
        } else {
            TextNode("error", 'Error Occured, Provide Necessary Data');
        }

        mysqli_close($GLOBALS['conn']);
    }
}
?>
<script src="js/js_register_political_party.js"></script>  

<?php
require_once 'includes/footer.php';
