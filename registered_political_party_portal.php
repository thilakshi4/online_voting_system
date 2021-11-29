<?php
$title = 'Registered Political Party';
session_start();
require_once 'includes/header.php';
require_once 'php/componenet.php';
include_once 'db/config.php';

if (isset($_POST['reg_candidate'])) {    
registerCandidate();
}
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="#">&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['party_name_short']; ?></a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4" >
        </div>

        <div class="col-sm-4" >
            <div class="style_form ">
                <form method="POST" action="">
                    <div><img src="images/party.jpg" width="100%" height="100%" ></div>
                    <br>
                    <div class="mb-3">
                        <a button type="button" class="frm_btn btn btn-primary" id="btn_submit" name="view_details" href='view_party_Details.php'>View Party Details</button></a>
                    </div>

                    <div class="mb-3">
                        <input type="submit" class="frm_btn btn btn-primary" name="reg_candidate" id="reg_candidate" value="Register Candidate" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
function registerCandidate(){
        
    $partyName = $_SESSION['party_name_short'];

    $sql = "SELECT candidate FROM political_party WHERE party_name_short='$partyName'";

    $result = mysqli_query($GLOBALS['conn'], $sql);
    $row = mysqli_fetch_assoc($result);
    $status = $row['candidate'];

    if ($status == "Candidate not Registered") {
        echo "<script> window.location.assign('register_candidate.php'); </script>";
    } else {
        TextNode("error", 'Your Party Already Registered the Candidate. Please Update Candidate Details');
    }
}
require_once 'includes/footer.php';
