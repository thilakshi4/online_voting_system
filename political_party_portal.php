<?php
$title = 'Register Political Party';
require_once 'includes/header.php';
?>

<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="index.php">&nbsp;Back</a>
            </li>    
        </ul>
    </div> 
</nav>

<div class="container" style="margin-top:30px">
    <div class="style_form">
        <div class="row"  style="margin-left: 150px">

            <div class="col-sm-5 border-control" >
                <h2  style="text-align: center"><br>For Unregistered Political Party</h2>
                <br>
                <br>
                <div><img src="images/citizen.jpg" width="100%" height=50% ></div>

                <p><a class="btn btn-primary home_btn " href="register_political_party.php" role="button">Political Party Registration</a></p>
                <br>
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div class="col-sm-5 border-control">
                <h2 style="text-align: center"><br>For Registered Political Party</h2>
                <br>
                <br>
                <div><img src="images/party.jpg" width="100%" height="100%" ></div>
                <br>
                <p><a class="btn btn-primary home_btn " href="Login_political_party.php" role="button">Political Party/Candidate Portal </a></p>
                <br>
            </div>

        </div>
    </div>
</div>
<br>
<?php require_once 'includes/footer.php' ?>

