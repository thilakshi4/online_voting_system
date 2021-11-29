<?php
$title = 'Voter Requests';
require_once '../db/config.php';
require_once '../php/componenet.php';
include 'downloads.php';

require_once 'includes/admin_header.php';

if (isset($_POST['update'])) {
    update();
}
if (isset($_POST['delete'])) {
    delete();
}

?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">
    <div ><a class="navbar-brand" href="dashboard.php.">&nbsp;&nbsp;Back</a></div>
    <div class="collapse navbar-collapse" id="collapsibleNavbar"></div>
    <div ><a class="navbar-brand" href="../sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a></div>
</nav>
<br>
<div align="center" class="style_form ">
    <form action = "" method = "post">
        <table border="1" id="table" style="width:90%">
            <tr>
                <th style="width:20%">oldNIC Number</th>
                <th style="width:20%">NIC Number</th>
                <th style="width:30%">Full Name</th>
                <th style="width:25%">Name with Initials</th>
                <th style="width:15%">Gender</th>
                <th style="width:15%">View Evidence</th>
                <th colspan="2" style="width:35%">Action</th>

            </tr>

            <?php foreach ($files as $file): ?>
                <tr>
                    <td ><?php echo $file['old_NIC']; ?></td>
                    <td><?php echo $file['NIC']; ?></td>
                    <td><?php echo $file['full_name']; ?></td>
                    <td><?php echo $file['name_with_initials']; ?></td>
                    <td><?php echo $file['gender']; ?></td>
                    <td hidden=""><?php echo $file['id']; ?></td>
                    <td style="color: blue"><a href="request_voter_personnal_details_change_requests.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
                    <td> 
                        <div align="center">
                            <input id="update" class="frm_btn btn btn-success" type="submit" name="update" value="Update">
                        </div>
                    </td>
                    <td> 
                        <div align="center">
                            <input id="delete" class="style_btn btn btn-warning" type="submit" name="delete" value="Delete">
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>


        </table>
        <input type="hidden"  name="old_nic" id="old_nic">
        <input type="hidden"  name="nic" id="nic">
        <input  type="hidden" name="full_name" id="full_name">
        <input type="hidden"  name="name_with_initials" id="name_with_initials">
        <input  type="hidden" name="gender" id="gender">
        <input  type="hidden" name="id" id="id">
    </form> 
</div>

</body>
</html>
<?php
function update(){
    
    $old_nic = trim($_POST['old_nic']);
    $nic = trim($_POST['nic']);
    $full_name = $_POST['full_name'];
    $name_with_initials = $_POST['name_with_initials'];
    $gender = $_POST['gender'];
    $id = $_POST['id'];

    $sql = "UPDATE voter_registration SET NIC='$nic',full_name='$full_name',"
            . "name_with_initials='$name_with_initials',"
            . "gender='$gender' WHERE NIC='$old_nic'";
    $result_up = mysqli_query($GLOBALS['conn'], $sql);

    $sql_del = "DELETE FROM voter_update_requests WHERE id='$id'";

    $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
    if (($result_up) AND ($result_del)) {

        echo ' <script>setTimeout(function() '
            . '{swal({title: "Details Updated Successfully ",'
            . 'text: "",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
    } else {
        TextNode("error", "Details are not updated. Please Try again");
    }
}

function delete(){
    
$id = $_POST['id'];
    
    $sql_del = "DELETE FROM voter_update_requests WHERE id='$id'";

    $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
    if  ($result_del) {

        echo ' <script>setTimeout(function() '
            . '{swal({title: "Details Deleted ",'
            . 'text: "",'
            . 'type: "success"}, '
            . 'function() { window.location = "dashboard.php";});}, 500);</script>';
    } else {
        TextNode("error", "Details are not Deleted. Please Try again");
    }
}
?> 

<script>
    var table = document.getElementById('table');
    for (var i = 1; i < table.rows.length; i++)
    {
        table.rows[i].onclick = function ()
        {
            document.getElementById("old_nic").value = this.cells[0].innerHTML;
            document.getElementById("nic").value = this.cells[1].innerHTML;
            document.getElementById("full_name").value = this.cells[2].innerHTML;
            document.getElementById("name_with_initials").value = this.cells[3].innerHTML;
            document.getElementById("gender").value = this.cells[4].innerHTML;
            document.getElementById("id").value = this.cells[5].innerHTML;

        };
    }
</script>

<?php
require_once 'includes/admin_footer.php';
?>
 