<?php
$title = 'All Requests';
require_once 'includes/admin_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php'; // Database connection
session_start();
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div ><a class="navbar-brand" href="reqest_received_candidate.php."><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div class="search-container">
        <form action="" method = "post">
            <input type="text" placeholder="&nbsp;Type Reference Number" name="search">
            <button type="submit"  class="btn btn-primary" name="btn_search" id="btn_search">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
        </form>
    </div>

</nav>

<?php
if (isset($_POST['btn_search'])) {
    $ref_number = $_POST['search'];
    $result = mysqli_query($conn, "SELECT * FROM requst_candidate WHERE ref_number='$ref_number'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM requst_candidate");
}
?>

<div align="center" class="style_form ">
    
    <form action = "" method = "post">
        <table border="1" id="table" style="width:50%">
            <tr>
                <td colspan="2">
                    <h1 class="py-2 bg-success text-white rounded"><i class="fa fa-users" aria-hidden="true">&nbsp;</i>Candidate Requests</h2>
                </td>
            </tr>
            <tr>
                <th style="width:20%">Reference Number</th>
                <th style="width:30%">States or Comments</th>

            </tr>
<?php
while ($row = mysqli_fetch_array($result)) {
    ?>
                <tr>
                    <td> 
    <?php echo "$row[ref_number]"; ?>
                    </td>
                    <td> 
    <?php echo "$row[comment]"; ?>
                    </td>
                    <?php }
                    ?>
            </tr>
        </table>
    </form>
    </br>

<?php
require_once 'includes/admin_footer.php';
?>