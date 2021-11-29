
function printError(elemId, hintMsg) {
    document.getElementById(elemId).innerHTML = hintMsg;
}

function checkForm(form)
{
    // validation fails if the inputs are blank
    if (form.name_with_initials.value === "") {
        printError("err_name_with_initials", " * Please Enter Name with Initials");
        form.name_with_initials.focus();
        return false;
    }

    if (form.nic.value === "") {
        printError("err_nic", " * Please Enter NIC Number");
        form.nic.focus();
        return false;
    }

    if (form.mobile_number.value === "") {
        printError("err_mobile_number", " * Please Enter Mobile Number");
        form.mobile_number.focus();
        return false;
    }

    if (form.user_level.value === '--------Please Select-------') {
        printError("err_user_level", " * Please Select User Type");
        form.user_level.focus();
        return false;
    }

    if (form.user_name.value === "") {
        printError("err_user_name", " * Please Enter Username");
        form.user_name.focus();
        return false;
    }

    if (form.password.value === "") {
        printError("err_password", " * Please Enter Password");
        form.password.focus();
        return false;
    }

    // regular expression to match NIC number
    var re_nic = /^[0-9V]{9,12}$/;
    if (!re_nic.test(form.nic.value)) {
        printError("err_nic", " * Please Enter Valid NIC Number");
        form.nic.focus();
        return false;
    }

    // regular expression to match mobile number
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.mobile_number.value)) {
        printError("err_mobile_number", " * Please Enter Valid Mobile Number");
        form.mobile_number.focus();
        return false;
    }

    // regular expression to match password
    var re_pass = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
    if (!re_pass.test(form.password.value)) {
        printError("err_password", "* Please Enter Valid Password. Password should contain atleast 8 character with letters and numbers");
        form.password.focus();
        return false;
    }
    // validation was successful
    return true;
}