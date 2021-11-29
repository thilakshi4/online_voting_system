<?php
$title = 'Register Candidate';
session_start();
require_once 'includes/header.php';
require_once 'db/config.php';
require_once 'php/componenet.php';

//insert candidate values to the database
if (isset($_POST['insert'])) {
    registerCandidate();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="registered_political_party_portal.php">&nbsp;&nbsp;Back</a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>

<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>

        <div class="col-sm-4" >
            <div class="style_form">
                <form method="POST" action="" enctype="multipart/form-data" onsubmit="return checkForm(this);">

                    <div class="form-group">
                        <label for="inputref">Reference Number</label>
                        <input type="text" class="form-control" id="refnumber" name="refnumber" placeholder="" readonly value="<?php echo setid(); ?>" >
                    </div>

                    <div class="mb-3">
                        <label for="InputNIC" class="form-label">NIC</label>
                        <input type="text" class="form-control" id="inputNIC" name="NIC">
                    </div>
                    <div style='color:red'> <label id="err_NIC"></label> </div>

                    <div class="mb-3">
                        <label for="InputFullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="inputFullName"  name="full_name">
                    </div>
                    <div style='color:red'> <label id="err_full_name"></label> </div>

                    <div class="mb-3">
                        <label for="InputNamewithInitials" class="form-label">Name with Initials</label>
                        <input type="text" class="form-control" id="inputnamewithinitials" name="name_with_initials">
                    </div>
                    <div style='color:red'> <label id="err_name_with_initials"></label> </div>

                    <div class="mb-3">
                        <label for="InputDOB" class="form-label">Date of Birth</label>
                        <input  type="date" class="form-control" id="dob" name="dob"  placeholder="" value="">
                    </div>
                    <div style='color:red'> <label id="err_dob"></label> </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="address">
                    </div>
                    <div style='color:red'> <label id="err_address"></label> </div>

                    <div class="mb-3">
                        <label for="InputMobileNo" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="inputMobile" name="mobile">
                    </div>
                    <div style='color:red'> <label id="err_mobile"></label> </div>

                    <div class="mb-3">
                        <label for="InputEmail" class="form-label">E mail</label>
                        <input type="text" class="form-control" placeholder="name@example.com" id="inputEmail" name="email">
                    </div>
                    <div style='color:red'> <label id="err_email"></label> </div>

                    <div class="mb-3">
                        <label for="InputPolitical Party Symbol" class="form-label">Candidate photo </label>
                        <input type="file" class="form-control" name="image" id="image" />
                    </div> 
                    <div style='color:red'> <label id="err_image"></label> </div>

                    <div class="mb-3">
                        <label for="InputEmail" class="form-label">Party</label>
                        <input type="text" class="form-control"  id="inputparty" name="party"  disabled="" value='<?php echo $_SESSION['party_name_short']; ?>'>
                    </div>

                    <br>
                    <button type="submit" class="frm_btn btn btn-primary" name="insert">Submit</button>
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
    $sql_id = "SELECT c_ref FROM ref_numbers WHERE id=1";

    $getId = mysqli_query($GLOBALS['conn'], $sql_id);

    $userid = 0;
    if ($getId) {
        while ($row = mysqli_fetch_assoc($getId)) {
            $userid = $row['c_ref'];
        }
    }
    return ($userid + 1);
}

function registerCandidate() {

    $refnumber = $_POST['refnumber'];
    $NIC = $_POST['NIC'];
    $full_name = $_POST['full_name'];
    $name_with_initials = $_POST['name_with_initials'];
    $dob = $_POST['dob'];
    $Date = date('Y-m-d', strtotime($dob));
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $party = $_SESSION['party_name_short'];

    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    $sql = "  INSERT INTO candidate_requests(ref_number,NIC,full_name,name_with_initials,dob,address,mobile,"
            . "email,candidate_photo,party) VALUES "
            . "('$refnumber' ,'$NIC','$full_name','$name_with_initials',' $Date','$address','$mobile',"
            . "'$email','$file','$party')";
    $result = mysqli_query($GLOBALS['conn'], $sql);

    $query_up = "UPDATE ref_numbers SET c_ref='$refnumber' WHERE id=1";
    $result_up = mysqli_query($GLOBALS['conn'], $query_up);

    if (($result) AND ($result_up)) {
        sendsms_for_registation($mobile, $refnumber);
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Registation Completed Successfully ",'
        . 'text: "Registration details  will send to your mobile number shortly",'
        . 'type: "success"}, '
        . 'function() { window.location = "registered_political_party_portal.php";});}, 500);</script>';
    } else {
        TextNode("error", "Registration not completed. Please re-register.");
    }
}
?>

<script src="js/js_register_candidate.js"></script>

<?php
require_once 'includes/footer.php';
