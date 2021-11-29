<?php
$title = 'Login';
require_once 'includes/gs_header.php';
require_once '../db/config.php';
require_once '../php/componenet.php';

session_start();

if (isset($_POST['submit'])) {
    $nic_no = $_POST['nic'];
    $sql = "SELECT * FROM voter_registration WHERE NIC='$nic_no'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['NIC'] = $nic_no;
        echo "<script> window.location.assign('officer_manage_voters.php'); </script>";
    } else {
        TextNode("error", 'NIC you entered doed not exist');
    }
}
?>
<!-- Create Bootstrap model for search -->

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Search Voters</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action=""  method="POST">
                    <div class="form-group">
                        <label for="InputNIC">NIC Number</label>
                        <input type="text" class="form-control" id="InputNIC" aria-describedby="NIC" placeholder="Enter NIC" name="nic" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of the Model -->

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="#">&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['username']; ?></a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="../sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<!-- start container -->
<div class="container-fluid "  style="margin-top:40px;">
    <div class ="row">
        <nav class="col-sm-2  sidebar py-5">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <div class="btn-group-vertical mybutton">
                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="gs_dashboard.php"><i class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard</button></a>

                        <a button type="button" class="btn btn-secondary "  style="text-align:left; padding-left:6px" 
                           href="officer_register_voters.php"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Voter Registration</button></a>

                        <a button type="button" class="btn btn-secondary  text-white"  style="text-align:left; padding-left:6px" data-toggle="modal" 
                           data-target="#search"><i class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;Manage Voters</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="reqest_received_voters.php"><i class="fa fa-registered" aria-hidden="true"></i>&nbsp;&nbsp;Voter Requests</button></a>


                        <a button type="button" class="btn btn-secondary "  style="text-align:left; padding-left:6px" 
                           href="../sign_out.php"><i class="fas fa-sign-out-alt"></i></i>&nbsp;&nbsp;Log Out</button></a>
                    </div>
                </ul>
            </div>
        </nav>
        <div class="col-sm-9 col-md-10">
            <div class="row text-center mx-5">
                <div class="col-sm-4 mt-5">
                    <div class="card text-white bg-danger mb-3" style="max-width:18rem;">
                        <div class="card-header">Voters Request <br>Received</div>
                        <div class="card-body">
                            <h4 class="card-title" id="gn_number">0</h4>
                            <a class="btn text-white" href="request_voter.php">View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="card text-white bg-success mb-3" style="max-width:18rem;">
                        <div class="card-header">Voter Residential Details Change Requests</div>
                        <div class="card-body">
                            <h4 class="card-title "id="vdc_number">0</h4>
                            <a class="btn text-white" href="request_voter_residentiall_details_change_requests.php">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript">

    function loadGNData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("gn_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "voter_data.php", true);
            xhttp.send();

        }, 1000);

    }

    loadGNData();

    function loadvoter_details_change_data() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("vdc_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_residential_dc_requests.php", true);
            xhttp.send();

        }, 1000);

    }

    loadvoter_details_change_data();

</script>
<?php
require_once 'includes/gs_header.php';
?>
 