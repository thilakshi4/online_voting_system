
$("#user_level").change(function () {
    let user_level = this.value; //get state

    $('.user-level-form').hide(); //hide all forms

    $("#form-" + user_level).show(); //show only related form
});

$(function () {
    $("#search_gn_division").autocomplete({
        source: 'search_gn_division.php',
    });
});
$(function () {
    $("#search_d_division").autocomplete({
        source: 'search_d_division.php',
    });
});

function printError(elemId, hintMsg) {
    document.getElementById(elemId).innerHTML = hintMsg;
}

function checkForm(form)
{
    // validation fails if the inputs are blank
    if (form.gn_name_with_initials.value === "") {
        printError("gn_err_name", " * Please enter name with initials");
        form.gn_name_with_initials.focus();
        return false;
    }

    if (form.gn_NIC.value === "") {
        printError("gn_err_nic", " * Please enter NIC number");
        form.gn_NIC.focus();
        return false;
    }

    if (form.gn_mobile_number.value === "") {
        printError("gn_err_mob", " * Please enter mobile number");
        form.gn_mobile_number.focus();
        return false;
    }

    if (form.gn_password.value === "") {
        printError("gn_err_pass", " * Please enter password with atleast 8 characters");
        form.gn_password.focus();
        return false;
    }

    if (form.gn_re_password.value === "") {
        printError("gn_err_rpass", " * Please retype password");
        form.gn_re_password.focus();
        return false;
    }

    if (form.search_gn_division.value === "") {
        printError("gn_err_gndiv", " * Please correctly select grama niladhari division");
        form.search_gn_division.focus();
        return false;
    }
    // regular expression to match NIC number
    var re_nic = /^[0-9V]{9,12}$/;
    if (!re_nic.test(form.gn_NIC.value)) {
        printError("gn_err_nic", " * Please enter valid NIC number");
        form.gn_NIC.focus();
        return false;
    }

    // regular expression to match mobile number
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.gn_mobile_number.value)) {
        printError("gn_err_mob", " * Please enter valid mobile number");
        form.gn_mobile_number.focus();
        return false;
    }

    // regular expression to match password
    var re_pass = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
    if (!re_pass.test(form.gn_password.value)) {
        printError("gn_err_pass", "* Please Enter Valid Password. Password should contain atleast 8 character with letters and numbers");
        form.gn_password.focus();
        return false;
    }

    // check whether match both password feilds
    if (form.gn_password.value !== form.gn_re_password.value) {
        printError("gn_err_rpass", "* Password you entered do not match. ");
        form.gn_re_password.focus();
        return false;
    }
    // validation was successful
    return true;
}
function checkForm_d(form)
{
    // validation fails if the input is blank
    if (form.d_name_with_initials.value === "") {
        printError("d_err_name", " * Please enter name with initials");
        form.d_name_with_initials.focus();
        return false;
    }

    if (form.d_NIC.value === "") {
        printError("d_err_nic", " * Please enter NIC number");
        form.d_NIC.focus();
        return false;
    }

    if (form.d_mobile_number.value === "") {
        printError("d_err_mob", " * Please enter mobile number");
        form.d_mobile_number.focus();
        return false;
    }

    if (form.d_password.value === "") {
        printError("d_err_pass", " * Please enter password with atleast 8 characters");
        form.d_password.focus();
        return false;
    }

    if (form.d_re_password.value === "") {
        printError("d_err_rpass", " * Please retype password");
        form.d_re_password.focus();
        return false;
    }

    if (form.search_d_division.value === "") {
        printError("d_err_district", " * Please correctly select district");
        form.search_d_division.focus();
        return false;
    }
    // regular expression to match NIC number
    var re_nic = /^[0-9V]{9,12}$/;
    if (!re_nic.test(form.d_NIC.value)) {
        printError("d_err_nic", " * Please enter valid NIC number");
        form.d_NIC.focus();
        return false;
    }

    // regular expression to match mobile number
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.d_mobile_number.value)) {
        printError("d_err_mob", " * Please enter valid mobile number");
        form.d_mobile_number.focus();
        return false;
    }

    // regular expression to match password
    var re_pass = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
    if (!re_pass.test(form.d_password.value)) {
        printError("d_err_pass", "* Please Enter Valid Password. Password should contain atleast 8 character with letters and numbers");
        form.d_password.focus();
        return false;
    }

    // check whether match both password feilds
    if (form.d_password.value !== form.d_re_password.value) {
        printError("d_err_rpass", "* Password you entered do not match. ");
        form.d_re_password.focus();
        return false;
    }
    // validation was successful
    return true;
}

function checkForm_e(form)
{
    // validation fails if the input is blank
    if (form.ec_name_with_initials.value === "") {
        printError("e_err_name", " * Please enter name with initials");
        form.ec_name_with_initials.focus();
        return false;
    }

    if (form.ec_NIC.value === "") {
        printError("e_err_nic", " * Please enter NIC number");
        form.ec_NIC.focus();
        return false;
    }

    if (form.ec_mobile_number.value === "") {
        printError("ec_err_mob", " * Please enter mobile number");
        form.ec_mobile_number.focus();
        return false;
    }

    if (form.ec_password.value === "") {
        printError("e_err_pass", " * Please enter password with atleast 8 characters");
        form.ec_password.focus();
        return false;
    }

    if (form.ec_re_password.value === "") {
        printError("e_err_rpass", " * Please retype password");
        form.ec_re_password.focus();
        return false;
    }

    // regular expression to match NIC number
    var re_nic = /^[0-9V]{9,12}$/;
    if (!re_nic.test(form.ec_NIC.value)) {
        printError("e_err_nic", " * Please enter valid NIC number");
        form.ec_NIC.focus();
        return false;
    }

    // regular expression to match mobile number
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.ec_mobile_number.value)) {
        printError("ec_err_mob", " * Please enter valid mobile number");
        form.ec_mobile_number.focus();
        return false;
    }

    // regular expression to match password
    var re_pass = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
    if (!re_pass.test(form.ec_password.value)) {
        printError("e_err_pass", "* Please Enter Valid Password. Password should contain atleast 8 character with letters and numbers");
        form.ec_password.focus();
        return false;
    }

    // check whether match both password feilds
    if (form.ec_password.value !== form.ec_re_password.value) {
        printError("e_err_rpass", "* Password you entered do not match. ");
        form.ec_re_password.focus();
        return false;
    }
    // validation was successful
    return true;
}

