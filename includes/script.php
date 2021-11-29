
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<?php
//Details add successfully
if (isset($_SESSION['status_success']) && ($_SESSION['status_success']) != '') {
    ?>
    <script>
        swal({
            title: "Details Added Successfully!",
            text: " <?php echo $_SESSION['status_success'] ?>",
            icon: "success",
            button: "OK",
        });
    </script>
    <?php
    //echo $_SESSION['status'];
    unset($_SESSION['status_success']);
}
?>

<?php
//Details update successfully
if (isset($_SESSION['status_success_update']) && ($_SESSION['status_success_update']) != '') {
    ?>
    <script>
        swal({
            title: "Details Updated Successfully!",
            text: " <?php echo $_SESSION['status_success_update'] ?>",
            icon: "success",
            button: "OK",
        });
    </script>
    <?php
    //echo $_SESSION['status'];
    unset($_SESSION['status_success']);
}
?>

    <?php
//Details delete successfully
if (isset($_SESSION['status_success_delete']) && ($_SESSION['status_success_delete']) != '') {
    ?>
    <script>
        swal({
            title: "Details Deleted!",
            text: " <?php echo $_SESSION['status_success_delete'] ?>",
            icon: "success",
            button: "OK",
        });
    </script>
    <?php
    //echo $_SESSION['status'];
    unset($_SESSION['status_success']);
}
?>

<?php
//Registered Successfullly
if (isset($_SESSION['status_registration']) && ($_SESSION['status_registration']) != '') {
    ?>
    <script>
        swal({
            title: "Registation Successfully Completed",
            text: " <?php echo $_SESSION['status_registration'] ?>",
            icon: "success",
            button: "OK",
        });
    </script>
    <?php
    //echo $_SESSION['status'];
    unset($_SESSION['status_registration']);
}
?>



<?php
//Error Occuerd
if (isset($_SESSION['status_error']) && ($_SESSION['status_error']) != '') {
    ?>
    <script>
        swal({
            title: "Error!",
            text: " <?php echo $_SESSION['status_error'] ?>",
            icon: "error",
            button: "OK",
        });
    </script>
    <?php
    //echo $_SESSION['status'];
    unset($_SESSION['status_error']);
}
?>
