<?php
$title = 'Oficer Login';
session_start();
require_once 'includes/header.php';
include_once 'db/config.php';
require_once 'php/componenet.php';

if (isset($_POST['login'])) {
    login();
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="index.php.">&nbsp;&nbsp;Back</a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="officers_Registration.php.">Registration&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>

        <div class="col-sm-4" >
            <div class="style_form">
                <form method="POST" action="" onsubmit="return checkForm(this);">
                    <div><img src="images/officers.jpg" width="100%" height="100%" ></div>
                    <div class="mb-3">
                        <label for="InputUsername" class="form-label">User Name</label>
                        <input type="text" class="form-control" name="user">
                    </div>
                    <div style='color:red'> <label id="err_user"></label> </div>

                    <div class="mb-3">
                        <label for="InputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <div style='color:red'> <label id="err_pass"></label> </div>
                    <br>

                    <button type="submit" class="frm_btn btn btn-primary" id="btn_submit" name="login">Login</button>

                    <p style="font-size:12px;text-align:center;margin-top:10px">
                        <a href="officer_forget_password.php" style="color:#00376b;">Forget Password?</a>
                    </p>
                    <br>
                </form>
            </div>
        </div>
        <div class="col-sm-4" >
        </div>
    </div>
</div>
<br>

<?php

function login() {
//get the values pass from login.php file
    $username = $_POST['user'];
    $password = $_POST['pass'];

//to prevent sql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);

    $sql = "SELECT * FROM staff_login WHERE BINARY username='$username' AND BINARY password='$password'";

    $result = mysqli_query($GLOBALS['conn'], $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['username'] = $username;
            if ($row['user_level'] == 1) {
                echo "<script> window.location.assign('Admin/dashboard.php'); </script>";
            }
            if ($row['user_level'] == 2) {
                echo "<script> window.location.assign('Officer/officer_dashboard.php'); </script>";
            }

            if ($row['user_level'] == 3) {
                echo "<script> window.location.assign('GS/gs_dashboard.php'); </script>";
            }
        }
    } else {
        TextNode("error", 'Login Failed!..Please make sure that you enter the correct  details and that you have activated your account.');
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
        if (form.user.value === "") {
            printError("err_user", " * Please enter user name");
            form.user.focus();
            return false;
        }

        if (form.pass.value === "") {
            printError("err_pass", " * Please enter password");
            form.pass.focus();
            return false;
        }
        // validation was successful
        return true;
    }
</script>

<?php
require_once 'includes/footer.php';
