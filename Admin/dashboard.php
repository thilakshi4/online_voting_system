<?php
$title = 'dashboard';
require_once 'includes/admin_header.php';
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

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="#">&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['username']; ?></a>
            </li>   
        </ul>
    </div>
    <div>
        <a class="navbar-brand" href="../sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<!-- start container -->
<div class="container-fluid "  style="margin-top:40px;">
    <div class ="row">
        <nav class="col-sm-2   sidebar py-5">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <div class="btn-group-vertical mybutton">
                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="dashboard.php"><i class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard</button></a>

                        <a button type="button" class="btn btn-secondary "  style="text-align:left; padding-left:6px" 
                           href="manage_users.php"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Manage Users</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="officer_register_voters.php"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Register Voters</button></a>

                        <a button type="button" class="btn btn-secondary  text-white"  style="text-align:left; padding-left:6px" data-toggle="modal" 
                           data-target="#search"><i class="fa fa-users"></i>&nbsp;&nbsp;Manage Voters</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="manage_political_party.php"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Manage Political Party</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="e_data_2021_election.php"><i class="fa fa-pie-chart" aria-hidden="true"></i>&nbsp;&nbsp;Election 2021 Vote Distribution</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="vote_precentage_2021.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Election 2021 Voting Percentage</button></a>

                        <a button type="button" class="btn btn-secondary " style="text-align:left; padding-left:6px" 
                           href="summery_report.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Province Summery Report</button></a>

                        <button class="btn btn-secondary dropdown-toggle dropdown-toggle-split" style="text-align:left; padding-left:6px" type="button" data-toggle="dropdown" aria-hidden="true" >
                            <i class="fa fa-registered" aria-hidden="true"></i>
                            Requests
                        </button>
                        <div class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="reqest_received_staff.php">Officer Requests</a>
                            <a class="dropdown-item" href="reqest_received_voters.php">Voter Requests</a>
                            <a class="dropdown-item" href="reqest_received_political_party.php">Political Party Requests</a>
                            <a class="dropdown-item" href="reqest_received_candidate.php">Candidate Requests</a>
                        </div>

                        <a button type="button" class="btn btn-secondary "  style="text-align:left; padding-left:6px" 
                           href="../sign_out.php"><i class="fas fa-sign-out-alt"></i></i>&nbsp;&nbsp;Log Out</button></a>

                    </div>
                </ul>
            </div>
        </nav>
        <div class="col-sm-9 col-md-10">
            <div class="row text-center mx-3">
                <div class="col-sm-3 mt-5">
                    <div class="card text-white bg-danger mb-3" style="max-width:15rem;max-height:10rem;">
                        <div class="card-header">Political Party Registration Requests</div>
                        <div class="card-body">
                            <h4 class="card-title" id="data_pp_number">0</h4>
                            <a class="btn text-white" href="request_political_party.php">View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-5">
                    <div class="card text-white bg-success mb-3" style="max-width:15rem;max-height:10rem;">
                        <div class="card-header">Candidate Registration Requests</div>
                        <div class="card-body">
                            <h4 class="card-title" id="candidate_reg_req">0</h4>
                            <a class="btn text-white" href="request_candidate_register.php" >View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-5">
                    <div class="card text-white bg-info mb-3" style="max-width:15rem;max-height:10rem;">
                        <div class="card-header">District Officer Registration Requests</div>
                        <div class="card-body">
                            <h4 class="card-title" id="do_number">0</h4>
                            <a class="btn text-white" href="request_do.php">View More</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-5">
                    <div class="card text-white bg-warning mb-3" style="max-width:15rem;max-height:10rem;">
                        <div class="card-header">Administrator Registration Requests</div>
                        <div class="card-body">
                            <h4 class="card-title" id="ad_number">0</h4>
                            <a class="btn text-white" href="request_ec.php">View More</a>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Collapsible Group for voter requests -->
            <div class="col-sm-15 ">

                <div>
                    <a  button type="hidden" class=" collapse_background btn btn-primary " 
                        data-toggle="collapse"  href="#collapse3" >Voters Requests</a>

                </div>
                <div id="collapse3" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row text-center mx-5">

                            <div class="col-sm-4 mt-5">
                                <div class="card text-white bg-success mb-3" style="max-width:18rem;max-height:10rem;">
                                    <div class="card-header">Voter Registration <br> Requests</div>
                                    <div class="card-body">
                                        <h4 class="card-title" id="v_number">0</h4>
                                        <a class="btn text-white" href="request_voter_registration.php" >View More</a>
                                    </div>
                                </div>
                            </div>




                            <div class="col-sm-4 mt-5">
                                <div class="card text-white bg-success mb-3" style="max-width:18rem;max-height:10rem;">
                                    <div class="card-header">Voter Personal Details Change Requests</div>
                                    <div class="card-body">
                                        <h4 class="card-title" id="vpdc_number">0</h4>
                                        <a class="btn text-white" href="request_voter_personnal_details_change_requests.php" >View More</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-5">
                                <div class="card text-white bg-success mb-3" style="max-width:18rem;max-height:10rem;">
                                    <div class="card-header">Voter Residential Details Change Requests</div>
                                    <div class="card-body">
                                        <h4 class="card-title" id="vrdc_number">0</h4>
                                        <a class="btn text-white" href="request_voter_residentiall_details_change_requests.php" >View More</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>  

            <br>
            <!-- Collapsible Group for officer's requests -->
            <div class="col-sm-15 ">

                <div>
                    <a  button type="hidden" class=" collapse_background btn btn-primary " 
                        data-toggle="collapse"  href="#collapse2">Officers Requests</a>

                </div>
                <div id="collapse2" class="panel-collapse collapse in">
                    <div class="panel-body">

                        <div class="row text-center mx-3">
                            <div class="col-sm-4 mt-5">
                                <div class="card text-white bg-success mb-3" style="max-width:18rem;max-height:10rem;">
                                    <div class="card-header">Grama Niladhari Registration Requests</div>
                                    <div class="card-body">
                                        <h4 class="card-title" id="gn_number">0</h4>
                                        <a class="btn text-white" href="request_gn.php" >View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 

            <br>


        </div> 
    </div>
    <br>
</div>
</div>

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

<script type="text/javascript" src="../js/admin_dashboard.js"></script>    
<?php
require_once 'includes/admin_footer.php';
?>
 