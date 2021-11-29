<?php
$title = 'Reset Password for Political Party';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php';

if (isset($_POST['submit'])) {
    reset_password();
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <div ><a class="navbar-brand" href="Login_political_party.php.">&nbsp;&nbsp;Back</a></div>
            </li>   
        </ul>
    </div>
</nav>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>
        
        <div class="col-sm-5" >
            <div class="style_form">
                <form  action="" method="POST" onsubmit="return checkForm(this);" >

                    <div class="alert alert-dark" role="alert">
                        <h4 class="alert-heading"><b>Important!</b></h4>
                        <p><h6>To change password please enter your username and mobile number which was registered with the online voting system</h6></p>
                        <hr>
                    </div>
                    <div>

                    </div>
                    <div class="mb-3">
                        <label for="Inputusername" class="form-label">Username</label>
                        <input type="text" class="form-control"  id='user_name' name='user_name' value='' >  
                    </div>
                    <div style='color:red'> <label id="err_user_name"></label> </div>

                    <div class="mb-3">
                        <label for="InputMobileNumber" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id='mobile_no' name='mobile_no' value='' >
                    </div>
                    <div style='color:red'> <label id="err_mobile_no"></label> </div>
                    <br>

                    <div>
                        <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="Reset Password"  >
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

function reset_password() {

    $username = $_POST['user_name'];
    $mobile = $_POST['mobile_no'];

    $sql = "SELECT * FROM political_party WHERE BINARY username='$username' AND BINARY contact_no='$mobile'";

    $result = mysqli_query($GLOBALS['conn'], $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username && $row['contact_no'] == $mobile) {

            //create auto genarated password
            $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $str = str_shuffle($str);
                $str = substr($str, 0, 4);
                $str_num="0123456789";
                $str_num = str_shuffle($str_num);
                $str_num = substr($str_num, 0, 4);
                $password = $str_num.$str;

            $sql_update = "UPDATE political_party SET password='$password' WHERE  username='$username' AND  contact_no='$mobile'";

            if (mysqli_query($GLOBALS['conn'], $sql_update)) {
                sendsms_forget_password($mobile, $username, $password);
                echo ' <script>setTimeout(function() '
                . '{swal({title: "Successfully Reset Password   ",'
                . 'text: "Reset details will send to your mobile number shortly",'
                . 'type: "success"}, '
                . 'function() { window.location = "Login_political_party.php";});}, 500);</script>';
            }
        }
    } else {
        TextNode("error", 'Your username or mobile number invalid. Please try again');
    }
    mysqli_close($GLOBALS['conn']);
}
?>
<script>
    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }

    function checkForm(form)
    {
        // validation fails if the inputs are blank
        if (form.user_name.value === "") {
            printError("err_user_name", " * Please Enter Username");
            form.user_name.focus();
            return false;
        }
        if (form.mobile_no.value === "") {
            printError("err_mobile_no", " * Please Enter Mobile Number");
            form.mobile_no.focus();
            return false;
        }

        // --regular expression to match mobile number--
        var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
        if (!re_mob.test(form.mobile_no.value)) {
            printError("err_mobile_no", " * Please Enter Valid Mobile Number");
            form.mobile_no.focus();
            return false;
        }

        // validation was successful
        return true;
    }
</script>

<?php
require_once 'includes/footer.php';
