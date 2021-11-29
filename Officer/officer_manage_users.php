<?php
$title = 'Manage users';
require_once 'includes/officer_header.php';
require_once '../php/componenet.php';
require_once '../db/config.php';

if (isset($_POST['create'])) {
        insertData();   
}

if (isset($_POST['update'])) {
        updateData();   
}

if (isset($_POST['delete'])) {
    deleteRecord();
}
?>
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="officer_dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div class="search-container">
        <form action="" method = "post">
            <input type="text" placeholder="&nbsp;&nbsp;Search &nbsp;NIC" name="search">
            <button type="submit"  class="btn btn-primary" name="btn_search" id="btn_search">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;</button>&nbsp;&nbsp;&nbsp;
        </form>
    </div>
</nav>
<main>
    <div class="container text-center style_form col-sm-10">
        <h2 class="py-4 bg-dark text-white rounded"><i class="fas fa-users-cog">&nbsp;</i>Manage GN Officers</h2>

        <div class="d-flex p-2 justify-content-center">
            <form action="" method="POST" class="w-50" onsubmit="return checkForm(this);">
                <div class="pt-2">
                    <?php inputElementManageUser_id("Staff ID", "<i class='fas fa-id-badge'></i>", "User&nbsp;ID", "user_id", setid(), "user_id"); ?>
                </div>

                <div class="pt-2">
                    <?php inputElementManageUser_id("Name with Initials", "<i class='fas fa-id-badge'></i>", "Name&nbsp;with&nbsp;Initials", "name_with_initials", "", "name_with_initials") ?>
                </div>
                <div style='color:red'> <label id="err_name_with_initials"></label> </div>

                <div class="pt-2">
                    <?php inputElementManageUser_id("NIC", "<i class='fas fa-user'></i>", "NIC", "nic", "", "nic"); ?>
                </div>
                <div style='color:red'> <label id="err_nic"></label> </div>

                <div class="pt-2">
                    <?php inputElementManageUser_id("Mobile Number", "<i class='fa fa-mobile'></i>", "Mobile&nbsp;Number", "mobile_number", "", "mobile_number"); ?>
                </div> 
                <div style='color:red'> <label id="err_mobile_number"></label> </div>
          
                <!-- jQuery UI auto complete-->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

                <div class="pt-2"  id="gn_divisions">
                    <?php inputElementManageUser_id("GN Division", "<i class='fas fa-user'></i>", "GN&nbsp;Division", "gn_division", "", "gn_division"); ?>
                </div>
                
                <div class="pt-2">
                    <?php inputElementManageUser_id("User Name", "<i class='fas fa-user'></i>", "User&nbsp;Name", "user_name", "", "user_name"); ?>
                </div>
                <div style='color:red'> <label id="err_user_name"></label> </div>

                <?php
                $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $str = str_shuffle($str);
                $str = substr($str, 0, 4);
                $str_num="0123456789";
                $str_num = str_shuffle($str_num);
                $str_num = substr($str_num, 0, 4);
                $password = $str_num.$str;
                
                ?>
                
                <div class="pt-2">
                    <?php inputElementManageUser_id("Password", "<i class='fas fa-lock'></i>", "Password", "password", "$password", "password"); ?>
                </div>
                <div style='color:red'> <label id="err_password"></label> </div>


               	<div class="d-flex justify-content-center ">
                    <?php buttonElement('btn-create', 'btn btn-success btn-lg', '<i class="fas fa-plus"></i>', 'create', 'data-toggle="tooltip" data-placement="bottom" title="Create"') ?>
                    <?php buttonElement('btn-update', 'btn btn-secondary btn-lg', '<i class="fas fa-pen-alt"></i>', 'update', 'data-toggle="tooltip" data-placement="bottom" title="Update"') ?>
                    <?php buttonElement('btn-delete', 'btn btn-danger btn-lg', '<i class="fas fa-trash-alt"></i>', 'delete', 'data-toggle="tooltip" data-placement="bottom" title="Delete"') ?>
                    <?php buttonElement('btn-read', 'btn btn-primary btn-lg', '<i class="fas fa-sync"></i>', 'read', 'data-toggle="tooltip" data-placement="bottom" title="Refresh"') ?> 
                </div> 

            </form>                
        </div>
        <div >
            <table class="table table-striped text-white table-dark" id="table" style="width:100%; ">
                <tr>
                    <th>Staff ID</th>
                    <th>Name with Initials</th>
                    <th>NIC</th>
                    <th>Mobile Number</th>
                    <th>User Name</th>
                    <th>GN Division</th>
                    <th>Edit</th>
                </tr>

                <?php
                $result = getData();
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <tr>
                            <td style="color: white"><?php echo $row['staff_id']; ?></td>
                            <td style="color: white"><?php echo $row['name_with_initials']; ?></td>
                            <td style="color: white"><?php echo $row['NIC']; ?></td>
                            <td style="color: white"><?php echo $row['mobile_no']; ?></td>
                            <td style="color: white"><?php echo $row['username']; ?></td>
                            <td hidden=""><?php echo $row['password']; ?></td>
                            <td style="color: white"><?php echo $row['gn_division']; ?></td>
                            <td style="color: white">
                                <div align="center">
                                    <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="View">
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    TextNode("error", 'No details relevant to this NIC number');
                }
                ?>

            </table>
        </div>
    </div>
</main>
<br>
<?php

//get data  from mysql database and display in table
function getData() {
    if (isset($_POST['read'])) {
        $sql = "SELECT * FROM staff_login WHERE user_level=3 ";
    } elseif (isset($_POST['btn_search'])) {
        $NIC = $_POST['search'];
        $sql = "SELECT * FROM staff_login WHERE NIC='$NIC' AND user_level=3 ";
    } else {
        $sql = "SELECT * FROM staff_login WHERE user_level=3  ";
    }
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
}

//insert data to staff_login
function insertData() {
    $userid = $_POST['user_id'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $userlevel = 3;
    $name_with_initials = $_POST['name_with_initials'];
    $nic = $_POST['nic'];
    $mobile_number = $_POST['mobile_number'];
    $gn_division = $_POST['gn_division'];

    $sql_gn = "select gn_division_No FROM gn_division WHERE `gn_division`='$gn_division' ";
    $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);
    if (mysqli_num_rows($result_gn) > 0) {
        while ($row = mysqli_fetch_assoc($result_gn)) {
            $g_division = $row['gn_division_No'];
        }
    } else {
        $g_division = "";
    }


    $sql = "INSERT INTO staff_login(staff_id, username, password, user_level,name_with_initials,NIC,mobile_no,status,gn_division,gn_division_no) "
            . "VALUES ('$userid','$username','$password','$userlevel','$name_with_initials','$nic','$mobile_number','Successfully Registered','$gn_division','$g_division')";

    $result = mysqli_query($GLOBALS['conn'], $sql);
    $query_up = "UPDATE ref_numbers SET officer_ref='$userid' WHERE id=1";
    $result_up = mysqli_query($GLOBALS['conn'], $query_up);

    if ($result AND $result_up) {
       sendsms_officer__registration($mobile_number, $username, $password);
        $_SESSION['status_success'] = "Data inserted successfully";
    } else {

        $_SESSION['status_error'] = "Error Occured, Please check again";
    }
}

function updateData() {

    $userid = $_POST['user_id'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $name_with_initials = $_POST['name_with_initials'];
    $nic = $_POST['nic'];
    $mobile_number = $_POST['mobile_number'];
    $gn_division = $_POST['gn_division'];

    $sql_gn = "select gn_division_No FROM gn_division WHERE `gn_division`='$gn_division' ";
    $result_gn = mysqli_query($GLOBALS['conn'], $sql_gn);
    if (mysqli_num_rows($result_gn) > 0) {
        while ($row = mysqli_fetch_assoc($result_gn)) {
            $g_division = $row['gn_division_No'];
        }
    } else {
        $g_division = "";
        $gn_division = "";
    }

    $sql = "UPDATE staff_login SET username='$username',password='$password',"
            . "name_with_initials='$name_with_initials',NIC='$nic',mobile_no='$mobile_number',"
            . "gn_division='$gn_division',gn_division_no='$g_division' "
            . "WHERE staff_id='$userid' ";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        sendsms_officer__update($mobile_number, $username, $password);
        $_SESSION['status_success_update'] = "Data updated successfully";
    } else {
        $_SESSION['status_error'] = "Error Occured, Please check again";
    }
}

//delete records
function deleteRecord() {
    $userid = $_POST['user_id'];

    $sql = "DELETE FROM staff_login where staff_id='$userid'";

    if (mysqli_query($GLOBALS['conn'], $sql)) {
        $_SESSION['status_success_delete'] = "Data deleted successfully";
    } else {
        $_SESSION['status_error'] = "Error Occured, Please check again";
    }
}

//set id
function setid() {

    $sql = "SELECT officer_ref FROM ref_numbers";

    $getId = mysqli_query($GLOBALS['conn'], $sql);
    $userid = 0;
    if ($getId) {
        while ($row = mysqli_fetch_assoc($getId)) {
            $userid = $row['officer_ref'];
        }
    }
    return ($userid + 1);
}

mysqli_close($GLOBALS['conn']);
?>

<script>

let id = $("input[name*='user_id']");
id.attr("readonly", "readonly");

var table = document.getElementById('table');
for (var i = 1; i < table.rows.length; i++)
{
    table.rows[i].onclick = function ()
    {
        document.getElementById("user_id").value = this.cells[0].innerHTML;
        document.getElementById("name_with_initials").value = this.cells[1].innerHTML;
        document.getElementById("nic").value = this.cells[2].innerHTML;
        document.getElementById("mobile_number").value = this.cells[3].innerHTML;
        document.getElementById("user_name").value = this.cells[4].innerHTML;
        document.getElementById("password").value = this.cells[5].innerHTML;
        document.getElementById("gn_division").value = this.cells[6].innerHTML;


    };
}

$(function () {
    $("#gn_division").autocomplete({
        source: '../search_gn_division.php',
    });
});

</script>

<script src="../js/js_manage_user.js"></script>

<?php
include '../includes/script.php';
require_once 'includes/officer_footer.php';
?>
 
