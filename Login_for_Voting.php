<?php
$title = 'Login for Voting';
session_start();
require_once 'includes/header.php';
require_once 'php/componenet.php';
include_once 'db/config.php';

if (isset($_POST['login'])) {
    loginVoter();
}
?>
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <div ><a class="navbar-brand" href="index.php.">&nbsp;&nbsp;Back</a></div>
            </li>   
        </ul>
    </div>
    <div class="login-container">
        <a class="navbar-brand" href="images/user_manual.pdf" target="_blank">Support&nbsp;&nbsp;<i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>

        <div class="col-sm-4" >
            <div class="style_form ">
                <form method="POST" action="" onsubmit="return checkForm(this);">

                    <div><img src="images/vote.png" width="100%" ></div>

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

                    </br>
                    <button type="submit" class="frm_btn btn btn-primary" id="btn_submit" name="login">Login</button>
                    <br>

                </form>
            </div>
        </div>
    </div>
</div>
<br>

<?php

function loginVoter() {
//get the values pass from login.php file
    $username = $_POST['user'];
    $password = $_POST['pass'];

//to prevent sql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);


    $sql = "SELECT * FROM voter_registration WHERE BINARY username='$username' AND BINARY password='$password'";

    $result = mysqli_query($GLOBALS['conn'], $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nic = $row['NIC'];
        }

        $sql2 = "SELECT NIC FROM `vote_details` WHERE NIC='$nic'";
        $result2 = mysqli_query($GLOBALS['conn'], $sql2);

        if (mysqli_num_rows($result2) == 0) {
            $sql3 = "SELECT * FROM voter_registration WHERE BINARY username='$username' AND BINARY password='$password'";
            $result3 = mysqli_query($GLOBALS['conn'], $sql3);
            $row = mysqli_fetch_assoc($result3);
            if ($row['username'] == $username && $row['password'] == $password) {
                $_SESSION['NIC'] = $row['NIC'];
                echo "<script> window.location.assign('ballot_sheet.php'); </script>";
            } else {
                TextNode("error", 'Please make sure that you enter the correct username and password');
            }
        } else {
            TextNode("error", 'You Already voted');
        }
    } else {
        TextNode("error", 'Please make sure that you enter the correct  details and that you have activated your account.');
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
