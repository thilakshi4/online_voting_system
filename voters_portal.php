<?php
$title = 'Voters Portal';
require_once 'includes/header.php';
require_once 'db/config.php';
session_start();

$NIC = $_SESSION['NIC'];

$res = mysqli_query($conn, "SELECT * FROM `voter_registration` WHERE `NIC`='$NIC'");
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="navbar-brand disabled" href="#">&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['NIC']; ?></a>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
<br>
<!-- start container -->
<div align="center">
    <table border="1" id="table" style="color: black; font-weight: 800">
        <?php
        while ($row = mysqli_fetch_array($res)) {
            ?>
            <tr>
                <td>NIC</td>
                <td><?php echo "$row[NIC]"; ?></td>
            </tr>
            <tr>
                <td> Full Name</td>
                <td> <?php echo "$row[full_name]"; ?></td>
            </tr>
            <tr>
                <td> Name with Initials</td>
                <td> <?php echo "$row[name_with_initials]"; ?></td>
            </tr>
            <tr>
                <td> Gender</td>
                <td> <?php echo "$row[gender]"; ?></td>
            </tr>
            <tr>
                <td> Permanent Address</td>
                <td> <?php echo "$row[address]"; ?></td>
            </tr>
            <tr>
                <td> Current Address</td>
                <td> <?php echo "$row[current_address]"; ?></td>
            </tr>
            <tr>
                <td> Province</td>
                <td> <?php echo "$row[province]"; ?></td>
            </tr>
            <tr>
                <td> Electoral District</td>
                <td> <?php echo "$row[e_district]"; ?></td>
            </tr>
            <tr>
                <td> Polling Division</td>
                <td> <?php echo "$row[p_division]"; ?></td>
            </tr>
            <tr>
                <td> Grama Niladhari Division</td>
                <td> <?php echo "$row[g_division]"; ?></td>
            </tr>
            <tr>
                <td> House Holder's List No</td>
                <td> <?php echo "$row[house_no]"; ?></td>
            </tr>
            <tr>
                <td> Mobile Number </td>
                <td> <?php echo "$row[mobile_no]"; ?></td>
            </tr>
            <tr>
                <td> Password </td>
                <td> <input type="password" value="<?php echo "$row[password]"; ?>" id="password" disabled="">
                    <input type="checkbox" onclick="showPassword()"> &nbsp;Show
                </td>
            </tr>

        </table>

        <?php
    }
    ?>

    <div class="style_form label_txt col-sm-6">
        <form action = "" method = "post">

            <font size="5" color="blue">Are you want to change your details? <br>
            Then click on button below</font>
            <br>
            <br>
            <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="Change Details">
        </form>
    </div>
</div>
<br>
<?php
if (isset($_POST['submit'])) {
    echo "<script> window.location.assign('voters_change_basic_details.php'); </script>";
}
?>
<script>
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>