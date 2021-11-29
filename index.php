<?php
$title = 'Home';
require_once 'includes/header.php';
session_start();
unset($_SESSION['username']);
?>

<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand" href="#">&nbsp;&nbsp;Home <span class="sr-only">(current)</span></a>
            </li>   
        </ul>
    </div>
</nav>

<div class="container" style="margin-top:30px">
    <div class="style_form">
        <div class="row">
            <div class="col-sm-3">
                <h2>Online Voting System</h2>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <br>
                        <a class="btn btn-primary home_btn" href="view_e_data.php">E-Data</a>
                    </li>
                    <li class="nav-item">
                        <br>
                        <div class="button txt_color">
                            <a class="nav-link txt_color" href="Login_for_Voting.php">E- voting Presidential Election 2021</a>
                        </div>
                    </li>
                </ul>
                <hr class="d-sm-none">
            </div>

            <div class="col-sm-3">
                <h2>For Citizen</h2>
                <br>
                <br>
                <div><img src="images/citizen.jpg" width="100%" height="70%" ></div>
                <br>
                <br>
                <p><a class="btn btn-primary home_btn " href="Login_voter.php" role="button">Voters Portal </a></p>
                <br>
            </div>

            <div class="col-sm-3">
                <h2>For Parties & Other</h2>
                <br>
                <div><img src="images/party.jpg" width="100%" height="100%" ></div>
                <br>
                <br>
                <p><a class="btn btn-primary home_btn " href="political_party_portal.php" role="button">Political Party Portal</a></p>
                <br>

            </div>

            <div class="col-sm-3">
                <h2>For Government Officers</h2>
                <div><img src="images/officers.jpg" width="100%" height="100%" ></div>
                <br>
                <br>
                <p><a class="btn btn-primary home_btn" href="officers_Login.php" role="button">Officers Portal </a></p>
                <br>
            </div>
        </div>
    </div>
</div>
<br>

<?php require_once 'includes/footer.php' ?>