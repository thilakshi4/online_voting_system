<?php
$title = 'ballot';
session_start();
require_once 'includes/header.php';
require_once 'db/config.php';
require_once 'php/componenet.php';

$NIC = $_SESSION['NIC'];

$res = mysqli_query($conn, "SELECT party_logo,party_name_short FROM political_party");

function getMobileNumber() {
    $NIC = $_SESSION['NIC'];
    $res_mob = mysqli_query($GLOBALS['conn'], "SELECT mobile_no FROM voter_registration WHERE NIC='$NIC'");

    while ($row = mysqli_fetch_assoc($res_mob)) {
        $mobile = $row['mobile_no'];
    }
    return $mobile;
}

if (isset($_POST['submit'])) {
    if (empty($_POST['selected_value'])) {
        TextNode("error", 'Plese select the political party name by clicking select  button. Then click on submit button');
    } else {
        vote();
    }
}
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
        <a class="navbar-brand" href="sign_out.php.">Log&nbsp;out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
<br>
<div align="center">
    <table border="1" id="table">
        <tr>
            <th>Symbol</th>
            <th>Political Party Name</th>
            <th>Vote</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($res)) {
            ?>
            <tr>
                <td>
                    <div align="center">
                        <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['party_logo']) . '" height="100" width="100"/>'; ?>
                    </div>
                </td>
                <td style="font-size: 20px; font-family: aril; font-weight: 800;padding-left: 20px"> 
                    <?php echo "$row[party_name_short]"; ?>
                </td>
                <td> 
                    <div align="center"> 
                        <input type="button" class="vote_btn btn btn-warning" name="btn_select" value="Select" style="font-size: 20px; font-family: aril; font-weight: 800"/> 
                    </div>
                </td>
            <?php }
            ?>
        </tr>
    </table>
    <div class="style_form label_txt col-sm-6">
        <form action = "" method = "post">
            <font size="5" color="purple">
            You Choose: <input type="text" name="selected_value" id="selected_value" readonly="" >
            </font>
            <br>
            <br>
            <font size="5" color="green">Are You sure about your choice ?. <br>
            Then click on Submit button</font>
            <br>
            <br>
            <input id="submit" class="frm_btn btn btn-primary" type="submit" name="submit" value="Submit">
        </form>
    </div>
    <br>
    <br>
    <br>
    <script>
        var table = document.getElementById('table');
        for (var i = 1; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function ()
            {
                document.getElementById("selected_value").value = this.cells[1].innerHTML;
                document.getElementById("btn_select").value = this.cells[1].innerHTML;
            };
        }
    </script>
</body>

<?php

function vote() {

    $NIC = $_SESSION['NIC'];
    $PartyNameShort = $_POST['selected_value'];
    $PartyNameShort_trim = trim($PartyNameShort);
    $mobile = getMobileNumber();

    $query_1 = "INSERT INTO vote(party_name_short) VALUES('$PartyNameShort_trim')";
    $query_2 = "INSERT INTO vote_details( NIC, province, e_district,p_division, g_division )"
            . "SELECT `NIC`,`province`,`e_district`,`p_division`,`g_division` from voter_registration where NIC='$NIC'";
    $query_3 = "INSERT INTO vote_details_party( party_name_short, province, e_district,p_division, g_division )"
            . "SELECT '$PartyNameShort_trim',`province`,`e_district`,`p_division`,`g_division` from voter_registration where NIC='$NIC'";

    $result_1 = mysqli_query($GLOBALS['conn'], $query_1);
    $result_2 = mysqli_query($GLOBALS['conn'], $query_2);
    $result_3 = mysqli_query($GLOBALS['conn'], $query_3);

    if (($result_1) AND ($result_2) AND ($result_3)) {

        sendsms_vote($mobile);
        echo ' <script>setTimeout(function() '
        . '{swal({title: "Successfull Voted",'
        . 'text: "Voting details will send to your mobile number shortly",'
        . 'type: "success"}, '
        . 'function() { window.location = "index.php";});}, 500);</script>';
    } else {
        TextNode("error", 'Error Occured. Please try again');
    }
    mysqli_close($GLOBALS['conn']);
}
?>


<?php
require_once 'includes/footer.php';
