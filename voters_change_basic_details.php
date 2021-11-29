<?php
$title = 'Change Voters Details';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php';
session_start();

$NIC = $_SESSION['NIC'];
$res = mysqli_query($conn, "SELECT * FROM voter_registration WHERE NIC='$NIC'");

$errors = array('current_address' => '', 'mobile_no' => '', 'password' => '');

if (isset($_POST['submit'])) {


    //Check Whether Current Address Inserted
    if (empty($_POST['current_address'])) {
        $errors['current_address'] = " * Please Enter Current Address";
    } else {
        $c_address = $_POST['current_address'];
    }

    //Check Mobile Number Validity
    if (empty($_POST['mobile_no'])) {
        $errors['mobile_no'] = " * Please Enter Mobile Number";
    } else {
        $mobileNo = $_POST['mobile_no'];
        if (!preg_match("/^([0]{1})([7]{1})([0-9]{8})$/", $mobileNo)) {
            $errors['mobile_no'] = "* Please Enter Valid Mobile Number";
        }
    }

    //Check Mobile Number Validity
    if (empty($_POST['password'])) {
        $errors['password'] = " * Please Enter Mobile Number";
    } else {
        $password = $_POST['password'];
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{8,}$/", $password)) {
            $errors['password'] = "* Please Enter Valid Password. Password should contain atleast 8 character with letters and numbers";
        }
    }
    if ($errors['current_address'] || $errors['mobile_no'] || $errors['password']) {
        TextNode("error", 'Error Occured, Please Check Details You Entered');
    } else {

        updateData();
    }
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <div ><a class="navbar-brand" href="voters_portal.php.">&nbsp;&nbsp;Back</a></div>
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
                <form  action="" method="POST" >
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading"><b>Important!</b></h4>
                        <p><h6>You can change your current address,mobile number and password only.</h6></p>
                        <hr>
                        <p class="mb-0">To change other critical details please <a href="voters_change_personnal_details.php" style="color:red"> click here </a></p>
                    </div>
                    <div>
                        <input type="button" class="frm_btn btn btn-primary" name='edit_cmn' value='Change Basic Details' onclick='myFunction()'>

                        <br>
                        <br>
                        <?php
                        while ($row = mysqli_fetch_array($res)) {
                            ?>


                        </div>
                        <div class="mb-3">
                            <label for="InputNIC" class="form-label">NIC</label>
                            <input type="text" class="form-control"  id='nic' name='nic' value='<?php echo "$row[NIC]"; ?>' disabled>  
                        </div>

                        <div class="mb-3">
                            <label for="InputCurrentAddress" class="form-label">Current Address</label>
                            <input type="text" class="form-control" id='current_address' name='current_address' value='<?php echo "$row[current_address]"; ?>' disabled>
                        </div>
                        <div style='color:red'> <?php echo $errors['current_address']; ?> </div>

                        <div class="mb-3">
                            <label for="InputMobileNumber" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id='mobile_no' name='mobile_no' value='<?php echo "$row[mobile_no]"; ?>' disabled>
                        </div>
                        <div style='color:red'> <?php echo $errors['mobile_no']; ?> </div>

                        <div class="mb-3">
                            <label for="InputPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id='password' name='password' value='<?php echo "$row[password]"; ?>' disabled>
                            <input type="checkbox" onclick="showPassword()">&nbsp;Show Password</td>    
                        </div>
                        <div style='color:red'> <?php echo $errors['password']; ?> </div>
                        <br>
                        <div>
                            <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="Submit" onclick='submitResult()' disabled >
                        </div>
                        <?php
                    }
                    ?>
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

    $nic_no = $_SESSION['NIC'];
    $c_address = $_POST['current_address'];
    $password = $_POST['password'];
    $mobileNo = $_POST['mobile_no'];

    $sql = "UPDATE `voter_registration` SET `current_address`='$c_address',"
            . "`mobile_no`='$mobileNo',`password`= '$password' WHERE `NIC`='$nic_no'";
    if (mysqli_query($GLOBALS['conn'], $sql)) {
        sendsms_officer__update($mobileNo, $password, $nic_no);
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Details Updated Successfully ",'
        . 'text: "Updated details will send to your mobile number shortly",'
        . 'type: "success"}, '
        . 'function() { window.location = "voters_portal.php";});}, 500);</script>';
    } else {
        TextNode("error", 'Error Occured');
    }
}
?>

<script>


    function myFunction() {
        document.getElementById('current_address').disabled = false;
        document.getElementById('mobile_no').disabled = false;
        document.getElementById('password').disabled = false;
        document.getElementById('submit').disabled = false;
    }

    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

</script>