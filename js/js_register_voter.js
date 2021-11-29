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

    if (form.address.value === "") {
        printError("err_address", " * Please Enter Permanent Address");
        form.address.focus();
        return false;
    }

    if (form.current_address.value === "") {
        printError("err_current_address", " * Please Enter Current Address");
        form.current_address.focus();
        return false;
    }
    if (form.province.selectedIndex === 0) {
        printError("err_province", " * Please Select Province");
        form.province.focus();
        return false;
    }

    if (form.district.selectedIndex === 0) {
        printError("err_district", " * Please Select District");
        form.district.focus();
        return false;
    }
    if (form.division.selectedIndex === 0) {
        printError("err_division", " * Please Select Polling Division");
        form.division.focus();
        return false;
    }

    if (form.grama_niladari_division.value === "") {
        printError("err_grama_niladari_division", " * Please Enter Grama Niladari Division");
        form.grama_niladari_division.focus();
        return false;
    }

    if (form.house_no.value === "") {
        printError("err_house_no", " * Please Enter House No");
        form.house_no.focus();
        return false;
    }

    if (form.mobile_no.value === "") {
        printError("err_mobile_no", " * Please Enter Mobile Number");
        form.mobile_no.focus();
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

    // --regular expression to match mobile number--
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.mobile_no.value)) {
        printError("err_mobile_no", " * Please Enter Valid Mobile Number");
        form.mobile_no.focus();
        return false;
    }

    // validation was successful
    return true;
}

    function reload1(form)
    {
        var val_nic = form.nic.value;
        var val_fullname = form.full_name.value;
        var val_namewithinitials = form.name_with_initials.value;
        var val_gender = form.gender.options[form.gender.options.selectedIndex].text;
        var val_address = form.address.value;
        var val_caddress = form.current_address.value;
        var val_grama_niladari_division = form.grama_niladari_division.value;
        var val_houseNo = form.house_no.value;
        var val_mobileNo = form.mobile_no.value;
        var val = form.province.options[form.province.options.selectedIndex].value;
        self.location = 'register_voter.php?province=' + val + '&NIC=' + val_nic + '&full_name=' + val_fullname
                + '&name_with_initials=' + val_namewithinitials + '&gender=' + val_gender
                + '&address=' + val_address + '&current_address=' + val_caddress + '&grama_niladari_division=' + val_grama_niladari_division
                + '&house_no=' + val_houseNo + '&mobile_no=' + val_mobileNo;
    }
    function reload3(form)
    {
        var val_nic = form.nic.value;
        var val_fullname = form.full_name.value;
        var val_namewithinitials = form.name_with_initials.value;
        var val_gender = form.gender.options[form.gender.options.selectedIndex].text;
        var val_address = form.address.value;
        var val_caddress = form.current_address.value;
        var val_grama_niladari_division = form.grama_niladari_division.value;
        var val_houseNo = form.house_no.value;
        var val_mobileNo = form.mobile_no.value;
        var val = form.province.options[form.province.options.selectedIndex].value;
        var val2 = form.district.options[form.district.options.selectedIndex].value;

        self.location = 'register_voter.php?province=' + val + '&district=' + val2
                + '&NIC=' + val_nic + '&full_name=' + val_fullname
                + '&name_with_initials=' + val_namewithinitials + '&gender=' + val_gender
                + '&address=' + val_address + '&current_address=' + val_caddress + '&grama_niladari_division=' + val_grama_niladari_division
                + '&house_no=' + val_houseNo + '&mobile_no=' + val_mobileNo;
    }
    $(function () {
        $("#grama_niladari_division").autocomplete({
            source: 'search_gn_division.php',
        });
    });

