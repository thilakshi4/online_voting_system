<?php
$title = 'Change Political Party Details';
session_start();
require_once 'includes/header.php';
require_once 'db/config.php';
require_once 'php/componenet.php';
$partyName = $_SESSION['party_name_short'];
$res = mysqli_query($conn, "SELECT * FROM political_party WHERE BINARY party_name_short='$partyName'");


if (isset($_POST['update'])) {
    updatePoliticalParty();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="view_party_Details.php">&nbsp;&nbsp;Back</a>
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
                    <div align="center">
                        <input type="button"  class="frm_btn btn btn-primary" name='edit_cmn' value='Change Details' onclick='myFunction()' >
                    </div>
                    <br>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <div class="mb-3">
                            <label for="InputPresidentName" class="form-label">General Secretary</label>
                            <input type="text" class="form-control" id="prsedient_name"  name="prsedient_name" value='<?php echo "$row[party_president_name]"; ?>' disabled="" >
                        </div>
                        <div style='color:red'> <label id="err_prsedient_name"></label> </div>

                        <div class="mb-3">
                            <label for="InputNIC" class="form-label">NIC</label>
                            <input type="text" class="form-control" id="NIC" name="NIC" value='<?php echo "$row[party_president_NIC]"; ?>' disabled="" >
                        </div>
                        <div style='color:red'> <label id="err_NIC"></label> </div>

                        <div class="mb-3">
                            <label for="InputMobileNo" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value='<?php echo "$row[contact_no]"; ?>' disabled="" >
                        </div>
                        <div style='color:red'> <label id="err_mobile"></label> </div>

                        <div class="mb-3">
                            <label for="InputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value='<?php echo "$row[adress]"; ?>' disabled="">
                        </div>
                        <div style='color:red'> <label id="err_address"></label> </div>

                        <br>
                        <button type="submit" class="frm_btn btn btn-primary" name="update" id="update" disabled="">Update</button>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="col-sm-4" >
        </div>
    </div>
</div>
<br>

<?php

function updatePoliticalParty() {

    $president_name = $_POST['prsedient_name'];
    $NIC = $_POST['NIC'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $party = $_SESSION['party_name_short'];


    $sql = "UPDATE political_party SET party_president_name='$president_name',party_president_NIC='$NIC',adress='$address',contact_no='$mobile' WHERE party_name_short='$party'";


    $result = mysqli_query($GLOBALS['conn'], $sql);

    if ($result) {
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Details Updated Successfully ",'
        . 'text: "",'
        . 'type: "success"}, '
        . 'function() { window.location = "view_party_Details.php";});}, 500);</script>';
    } else {
        TextNode("error", "Registration not completed. Please re-register.");
    }
}
?>

<script>

    function myFunction() {
        document.getElementById('prsedient_name').disabled = false;
        document.getElementById('NIC').disabled = false;
        document.getElementById('mobile').disabled = false;
        document.getElementById('address').disabled = false;
        document.getElementById('update').disabled = false;
    }


    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }

    function checkForm(form)
    {

        if (form.prsedient_name.value === "") {
            printError("err_prsedient_name", " * Please enter secretary name");
            form.prsedient_name.focus();
            return false;
        }

        if (form.NIC.value === "") {
            printError("err_NIC", " * Please enter NIC number");
            form.NIC.focus();
            return false;
        }
        if (form.mobile.value === "") {
            printError("err_mobile", " * Please enter mobile number");
            form.mobile.focus();
            return false;
        }

        if (form.address.value === "") {
            printError("err_address", " * Please enter address");
            form.address.focus();
            return false;
        }

        //-- regular expression to match NIC number--
        var re_nic = /^[V0-9]{9,12}$/;
        if (!re_nic.test(form.NIC.value)) {
            printError("err_NIC", " * Please Enter Valid NIC Number");
            form.NIC.focus();
            return false;
        }


        // --regular expression to match mobile number--
        var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
        if (!re_mob.test(form.mobile.value)) {
            printError("err_mobile", " * Please Enter Valid Mobile Number");
            form.mobile.focus();
            return false;
        }

        // validation was successful
        return true;
    }
</script>

<?php
require_once 'includes/footer.php';
?>




