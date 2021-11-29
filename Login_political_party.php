<?php
$title = 'Login Political Party';
session_start();
require_once 'includes/header.php';
require_once 'php/componenet.php';
include_once 'db/config.php';

if (isset($_POST['login'])) {
    loginPoliticalParty();
}
?>

<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="political_party_portal.php.">&nbsp;&nbsp;Back</a></div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>
        
        <div class="col-sm-4" >
            <div class="style_form ">
                <form method="POST" action="" onsubmit="return checkForm(this);">
                    <div><img src="images/party.jpg" width="100%" height="70%" ></div>
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

                    <p style="font-size:12px;text-align:center;margin-top:10px">
                        <a href="political_party_forget_password.php" style="color:#00376b;">Forget Password?</a>
                    </p>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<?php

function loginPoliticalParty() {
//get the values pass from login.php file
    $username = $_POST['user'];
    $password = $_POST['pass'];

//to prevent sql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);

    $sql = "SELECT * FROM political_party WHERE BINARY username='$username' AND BINARY password='$password'";

    $result = mysqli_query($GLOBALS['conn'], $sql);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['username'] = $username;

        $row = mysqli_fetch_assoc($result);
        $partyName = $row['party_name_short'];
        if ($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['party_name_short'] = $partyName;
            echo "<script> window.location.assign('registered_political_party_portal.php'); </script>";
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
