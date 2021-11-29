<?php
$title = 'Change Voters Personnal Details';
require_once 'includes/header.php';
require_once 'php/componenet.php';
require_once 'db/config.php';


session_start();

$NIC = $_SESSION['NIC'];
$res = mysqli_query($conn, "SELECT * FROM voter_registration WHERE NIC='$NIC'");


if (isset($_POST['update'])) {

    updateData();
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-sm navbar navbar-dark bg-primary">

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <div ><a class="navbar-brand" href="voters_change_basic_details.php.">&nbsp;&nbsp;Back</a></div>
            </li>   
        </ul>
    </div>
    <div >
        <a class="navbar-brand" href="sign_out.php.">Log out&nbsp;&nbsp;</a>
    </div>
</nav>
<br>
</br>
<div class="container">
    <div class="row">
        <div class="col-sm-3" >
        </div>

        <div class="col-sm-6" >
            <div class="style_form">
                <form  action="" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                    <div class="alert alert-primary" role="alert">

                        <hr>
                        <p   ><h6 style="text-align:center">To change other residential details please <a href="voters_change_residential_details.php" style="color:red"> click here </a></h6></p>
                        <hr>
                    </div>

                    <br>
                    <br>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        ?>

                        <div class="mb-3">
                            <label for="InputNIC" class="form-label">NIC</label>
                            <input type="text" class="form-control"  id='nic' name='nic' value='<?php echo "$row[NIC]"; ?>' >  
                        </div>
                        <div style='color:red'> <label id="err_nic"></label> </div>

                        <div class="mb-3">
                            <label for="InputFull Name)" class="form-label">Full Name</label>
                            <input type="text" class="form-control"  id="full_name" name="full_name" value="<?php echo "$row[full_name]"; ?>">
                        </div>
                        <div style='color:red'> <label id="err_full_name"></label> </div>

                        <div class="mb-3">
                            <label for="InputName with Initials" class="form-label"> Name with Initials</label>
                            <input type="text" class="form-control"  id="name_with_initials" name="name_with_initials" value="<?php echo "$row[name_with_initials]"; ?>">
                        </div>
                        <div style='color:red'> <label id="err_name_with_initials"></label> </div>

                        <div class="mb-3">
                            <div ><label for="InputGender" class="form-label">Gender &nbsp; &nbsp;</label></div>
                            <select class="form-select" id="gender" name="gender" value="<?php echo "$row[gender]"; ?>" >  
                                <?php
                                $gender = $row['gender'];
                                echo "<option selected value='$gender'>$gender</option>" . "<BR>";
                                echo "<option value=Male>Male</option>";
                                echo "<option value=Female>Female</option>";
                                ?>
                            </select>
                        </div>
                        <div style='color:red'> <label id="err_gender"></label> </div>

                        <?php
                    }
                    ?>

                    <div class="mb-3">
                        <label for="InputEvidence" class="form-label">Attach Evidence  </label>
                        <input type="file" class="form-control" name="myfile" id="myfile" />
                    </div>
                    <div style='color:red'> <label id="err_myfile"></label> </div>

                    <br>
                    <div>
                        <input id="update" class="frm_btn btn btn-primary" type="submit" name="update" value="Submit" >
                    </div>

                </form>           
            </div>
        </div>
        <div class="col-sm-3" >
        </div>
    </div>

</div>
<br>
<?php

function updateData() {
    $nic_no = $_POST['nic'];
    $fullname = $_POST['full_name'];
    $namewithinitials = $_POST['name_with_initials'];
    $gender = $_POST['gender'];
    $NIC = $_SESSION['NIC'];

    $update = date("Ymdhis");
    //echo $update;
    // name of the uploaded file
    $filename = $update . "-" . $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        TextNode("error", "You file extension must be .zip, .pdf or .docx");
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        TextNode("error", "File too large");
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO voter_update_requests(old_NIC,NIC,full_name,name_with_initials,gender,name, size) "
                    . "VALUES ('$NIC','$nic_no','$fullname','$namewithinitials','$gender','$filename', $size)";
            if (mysqli_query($GLOBALS['conn'], $sql)) {
                echo ' <script>setTimeout(function() '
                . '{swal({title: "Request Sent ",'
                . 'text: "Your request send to futher processing ",'
                . 'type: "success"}, '
                . 'function() { window.location = "voters_portal.php";});}, 500);</script>';
            }
        } else {
            TextNode("error", "Error occured. Please try again shortly");
        }
    }
}
?>

<script>
    function printError(elemId, hintMsg) {
        document.getElementById(elemId).innerHTML = hintMsg;
    }

    function checkForm(form)
    {
        // validation fails if the inputs are blank
        if (form.nic.value === "") {
            printError("err_nic", " * Please enter NIC number");
            form.nic.focus();
            return false;
        }

        if (form.full_name.value === "") {
            printError("err_full_name", "  * Please Enter Full Name");
            form.full_name.focus();
            return false;
        }

        if (form.name_with_initials.value === "") {
            printError("err_name_with_initials", " * Please Enter Name with Initials");
            form.name_with_initials.focus();
            return false;
        }

        if (form.gender.value === '--Select--') {
            printError("err_gender", " * Please Select the Gender");
            form.gender.focus();
            return false;
        }

        if (form.myfile.value === "") {
            printError("err_myfile", " * Please Attach Relevent Documents");
            form.myfile.focus();
            return false;
        }

        //-- regular expression to match NIC number--
        var re_nic = /^[V0-9]{9,12}$/;
        if (!re_nic.test(form.nic.value)) {
            printError("err_nic", " * Please Enter Valid NIC Number");
            form.nic.focus();
            return false;
        }

        //-- regular expression to match valid full name letters and space--
        var re_name = /^[A-Za-z\s]/;
        if (!re_name.test(form.full_name.value)) {
            printError("err_full_name", " * Please Enter Valid Name");
            form.full_name.focus();
            return false;
        }
        // validation was successful
        return true;
    }

</script>