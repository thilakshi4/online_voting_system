<?php
$title = 'Political Party Details';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php'; // Database connection

session_start();
$party_name = $_SESSION['party_name_short'];

$res = mysqli_query($conn, "SELECT * FROM political_party WHERE BINARY party_name_short='$party_name'");
$res_candidate = mysqli_query($conn, "SELECT * FROM candidate WHERE BINARY party='$party_name'");

if (isset($_POST['delete'])) {

    reRegisterCandidate();
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="registered_political_party_portal.php">&nbsp;&nbsp;&nbsp;Back</a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<div align="center" class="style_form ">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:70%; font-weight: 500; font-size: 20px;color: black ">
            <tr>
                <td  colspan='2' style="height: 50px; background:blueviolet;font-weight:900">Political Party Details</td>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <td style="width:50%">Abbreviation</td>
                    <td><?php echo "$row[party_name_short]"; ?></td>
                </tr>
                <tr>
                    <td>Political Party Name</td>
                    <td><?php echo "$row[party_name_long]"; ?></td>
                </tr>
                <tr>
                    <td>Logo</td>
                    <td> <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['party_logo']) . '" height="150" width="150"/>'; ?></td>
                </tr>
                <tr>
                    <td>Party Color</td>
                    <?php
                    $color = $row['colour'];
                    echo "<td bgcolor='$color'>";
                    ?>
                </tr>
                <tr>
                    <td>Secretary Name</td>
                    <td><?php echo "$row[party_president_name]"; ?></td>
                </tr>
                <tr>
                    <td> Secretary NIC Number</td>
                    <td><?php echo "$row[party_president_NIC]"; ?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> <?php echo "$row[contact_no]"; ?></td>
                </tr>
                <tr>
                    <td> Address</td>
                    <td><?php echo "$row[adress]"; ?></td>
                </tr>
                <tr>
                    <td  colspan='2' style="height: 50px; background:blueviolet;font-weight:900">Candidate Details</td>
                </tr>
                <?php
                $candidate = $row['candidate'];
                if ($candidate == 'Candidate not Registered') {
                    echo " <tr> <th colspan='2'> Candidate Not Registered Yet </td></tr>";
                } else {
                    while ($row = mysqli_fetch_array($res_candidate)) {
                        ?>
                        <tr>
                            <td>Candidate NIC Number</td>
                            <td><?php echo "$row[NIC]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate Full Name</td>
                            <td><?php echo "$row[full_name]"; ?></td>
                        </tr>

                        <tr>
                            <td>Candidate Name with Initials</td>
                            <td><?php echo "$row[name_with_initials]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate Date of Birth</td>
                            <td><?php echo "$row[dob]"; ?></td>
                        </tr>

                        <tr>
                            <td>Candidate Address</td>
                            <td><?php echo "$row[address]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate Mobile Number</td>
                            <td><?php echo "$row[mobile]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate Address</td>
                            <td><?php echo "$row[address]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate E- mail</td>
                            <td><?php echo "$row[email]"; ?></td>
                        </tr>
                        <tr>
                            <td>Candidate Photo</td>
                            <td> <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['candidate_photo']) . '" height="150" width="150"/>'; ?></td>
                        </tr> 

                        <?php
                    }
                }
                ?> 
            </table>
            <br>
            <br>
            <div class="d-flex justify-content-center ">

                <input type="button" class="block btn btn-primary"  onclick="location.href = 'update_political_party.php'" value="Change Political Party Details">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="button" class="block btn btn-secondary"  onclick="location.href = 'update_candidate.php'" value="Change Candidate Basic Details"
                       <?php if ($candidate == 'Candidate not Registered') { ?> disabled='disabled' <?php } ?> >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="button" class="block btn btn-secondary" value="Delete Candidate & Re-Register"
                       data-toggle="modal" data-target="#reject" 
                       <?php if ($candidate == 'Candidate not Registered') { ?> disabled='disabled' <?php } ?> >

            </div>
        </form>
        <br>
        <?php
    }

    function reRegisterCandidate() {

        $party_name = $_SESSION['party_name_short'];

        $result_delete = mysqli_query($GLOBALS['conn'], "DELETE FROM candidate WHERE  `party`='$party_name'");
        $result_update = mysqli_query($GLOBALS['conn'], "UPDATE political_party SET candidate='Candidate not Registered' WHERE party_name_short='$party_name'");
        if (($result_delete) AND ($result_update)) {
            echo "<script> window.location.assign('register_candidate.php'); </script>";
        }
    }
    ?>
    <!-- Create Bootstrap model for delete -->

    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header model_background">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Delete Candidate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body model_background">
                    <form action=""  method="POST">

                        <p> Are you sure about delete the candidate details? </P>  <br>     

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" id="delete" name="delete">Delete and re-register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of the Model -->


