<?php
$title = 'Poilitical Party';
require_once '../db/config.php';
require_once '../php/componenet.php';
require_once 'includes/admin_header.php';
session_start();

$result = mysqli_query($conn, "SELECT * FROM political_party");

if (isset($_POST['update'])) {
    update();
}
if (isset($_POST['delete'])) {
    delete();
}

if (isset($_POST['reject'])) {
    reject();
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
        <table border="1" id="table" style="width:100%">
            <tr>
                <th style="width:5%">Abbreviation</th>
                <th style="width:20%">Political Party Name</th>
                <th style="width:10%">Logo</th>
                <th style="width:5%">Party Color</th>
                <th style="width:25%">Secretary Name</th>
                <th style="width:10%">Mobile No</th>
                <th colspan="2" style="width:10%">Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>

                    <td><?php echo "$row[party_name_short]"; ?></td>
                    <td><?php echo "$row[party_name_long]"; ?></td>
                    <td>
                        <div align="center">
                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['party_logo']) . '" height="25" width="25"/>'; ?>
                        </div>
                    </td>  
                    <?php
                    $color = $row['colour'];
                    echo "<td bgcolor='$color'>";
                    ?>

                    <td> <?php echo "$row[party_president_name]"; ?></td>
                    <td> <?php echo "$row[contact_no]"; ?></td>

                    <td> 
                        <div align="center">
                            <input id="update" class="frm_btn btn btn-success" type="submit" name="view" value="View">
                        </div>
                    </td>
                    <td> 
                        <div align="center">
                            <input id="delete" class="style_btn btn btn-warning" type="submit" name="delete" value="Delete">
                        </div>
                    </td>
                    <td> 
                        <div align="center">
                            <input id="reject" class="style_btn btn btn-warning" type="submit" name="reject" value="Reject">
                        </div>
                    </td>
                </tr>
            <?php } ?>


        </table>

        <input type="" name="selected_value_hidden" id="selected_value_hidden">
    </form> 
</div>

<?php

function delete() {

    $party_name = $_POST['selected_value_hidden'];

    $sql_del = "DELETE FROM  political_party WHERE party_name_short='$party_name '";

    $result_del = mysqli_query($GLOBALS['conn'], $sql_del);
    if ($result_del) {

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
            document.getElementById("selected_value_hidden").value = this.cells[0].innerHTML;
        };
    }
</script>

<?php
if (isset($_POST['view'])) {

    $party_name = $_POST['selected_value_hidden'];
    $sql = "SELECT * FROM political_party WHERE BINARY party_name_short='$party_name'";

    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        $_SESSION['party_name_short'] = $party_name;
        echo "<script> window.location.assign('view_party_Details.php'); </script>";
    }
}


function reject(){
      $party_name = $_POST['selected_value_hidden'];
     
       $sql = "INSERT INTO political_party_new (ref_number, party_name_short,party_name_long,party_logo,colour,
           party_president_name,party_president_NIC,contact_no,adress,status,username,password,candidate)
            SELECT ref_number, party_name_short,party_name_long,party_logo,colour,party_president_name,party_president_NIC,contact_no,adress,status,'username','password',candidate
            FROM political_party
             WHERE party_name_short='$party_name '";
        $result = mysqli_query($GLOBALS['conn'], $sql);

    $sql_del = "DELETE FROM  political_party WHERE party_name_short='$party_name '";
$result_del= mysqli_query($GLOBALS['conn'], $sql_del);
  
    
 
    
    if (  $result AND  $result_del) {

        echo ' <script>setTimeout(function() '
        . '{swal({title: "Details Removed ",'
        . 'text: "",'
        . 'type: "success"}, '
        . 'function() { window.location = "dashboard.php";});}, 500);</script>';
    } else {
        TextNode("error", "Details are not Deleted. Please Try again");
    }
}
?>  