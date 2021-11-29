<?php
$title = 'Change Candidate Details';
session_start();
require_once 'includes/header.php';
require_once 'db/config.php';
require_once 'php/componenet.php';
$partyName = $_SESSION['party_name_short'];
$res = mysqli_query($conn, "SELECT * FROM candidate WHERE party='$partyName'");

//insert candidate values to the database
if (isset($_POST['insert'])) {
    updateCandidate();
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
                            <label for="InputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value='<?php echo "$row[address]"; ?>' disabled="">
                        </div>
                        <div style='color:red'> <label id="err_address"></label> </div>

                        <div class="mb-3">
                            <label for="InputMobileNo" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value='<?php echo "$row[mobile]"; ?>' disabled="">
                        </div>
                        <div style='color:red'> <label id="err_mobile"></label> </div>

                        <div class="mb-3">
                            <label for="InputEmail" class="form-label">E mail</label>
                            <input type="text" class="form-control" placeholder="name@example.com" id="email" name="email"  value='<?php echo "$row[email]"; ?>' disabled="">
                        </div>
                        <div style='color:red'> <label id="err_email"></label> </div>

                        <div name='img_show' id="img_show" >               
                            <input type="button" name='image_show' id="image_show" class="btn btn-warning" value="Change Candidate Image" disabled="" onclick='imageFunction()' >
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['candidate_photo']) ?> " width="50" height="50"  />  
                        </div>

                        <div class="mb-3" style="display: none" id="image_browse" name="image_browse">
                            <label for="InputCandidatePhoto" class="form-label">Candidate photo </label>
                            <input type="file" class="form-control" name="image" id="image" value="" />
                        </div> 
                        <div style='color:red'> <label id="err_image"></label> </div>

                        <br>
                        <button type="submit" class="frm_btn btn btn-primary" name="insert" id="insert" disabled="">Update</button>
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

function updateCandidate() {

    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $party = $_SESSION['party_name_short'];

    $file = $_FILES["image"]["tmp_name"];
    if ($file == null) {
        $sql = "UPDATE candidate SET address='$address',mobile='$mobile',email='$email' WHERE party='$party'";
    } else {
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $sql = "UPDATE candidate SET address='$address',mobile='$mobile',email='$email',candidate_photo='$file' WHERE party='$party'";
    }

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

        document.getElementById('address').disabled = false;
        document.getElementById('mobile').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('insert').disabled = false;
        document.getElementById('image_show').disabled = false;
    }

    function imageFunction() {
        document.getElementById('image_browse').style.display = "block";
        document.getElementById('img_show').style.display = "none";
    }

    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }

    function checkForm(form)
    {

        if (form.address.value === "") {
            printError("err_address", " * Please Enter Address");
            form.address.focus();
            return false;
        }
        if (form.mobile.value === "") {
            printError("err_mobile", " * Please Enter Mobile Number");
            form.mobile.focus();
            return false;
        }

        if (form.email.value === "") {
            printError("err_email", " * Please Enter Email Address");
            form.email.focus();
            return false;
        }

        // --regular expression to match mobile number--
        var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
        if (!re_mob.test(form.mobile.value)) {
            printError("err_mobile", " * Please Enter Valid Mobile Number");
            form.mobile.focus();
            return false;
        }


        //-- regular expression to match valid full name letters and space--
        var re_name = /\S+@\S+\.\S+/;
        if (!re_name.test(form.email.value)) {
            printError("err_email", " * Please Enter Valid E-mail");
            form.email.focus();
            return false;
        }

        // validation was successful
        return true;
    }

</script>

<?php
require_once 'includes/footer.php';
?>




