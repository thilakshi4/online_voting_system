function printError(elemId, hintMsg) {
    document.getElementById(elemId).innerHTML = hintMsg;
}

function checkForm(form)
{
    // validation fails if the inputs are blank
    if (form.NIC.value === "") {
        printError("err_NIC", " * Please Enter NIC Number");
        form.NIC.focus();
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

    if (form.dob.value === "") {
        printError("err_dob", " * Please Enter Date of Birth");
        form.dob.focus();
        return false;
    }

    if (form.address.value === "") {
        printError("err_address", " * Please Enter Address");
        form.address.focus();
        return false;
    }
    if (form.mobile.value === "") {
        printError("err_mobile", " * Please Enter Mobile Number");
        form.mobile.focus();
        return false;
    }

    if (form.email.value === "") {
        printError("err_email", " * Please Enter Email Address");
        form.email.focus();
        return false;
    }

    if (form.image.value === "") {
        printError("err_image", " * Please Enter Present Photo");
        form.image.focus();
        return false;
    }

    //-- regular expression to match NIC number--
    var re_nic = /^[V0-9]{9,12}$/;
    if (!re_nic.test(form.NIC.value)) {
        printError("err_NIC", " * Please Enter Valid NIC Number");
        form.NIC.focus();
        return false;
    }

    // --regular expression to match mobile number--
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.mobile.value)) {
        printError("err_mobile", " * Please Enter Valid Mobile Number");
        form.mobile.focus();
        return false;
    }


    //-- regular expression to match valid full name letters and space--
    var re_name = /\S+@\S+\.\S+/;
    if (!re_name.test(form.email.value)) {
        printError("err_email", " * Please Enter Valid E-mail");
        form.email.focus();
        return false;
    }

    // validation was successful
    return true;
}

$(document).ready(function () {
    $('#insert').click(function () {
        var image_name = $('#image').val();
        if (image_name === '')
        {
            printError("err_image", " * Please select an image");
            return false;
        } else
        {
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) === -1)
            {
                alert('Invalid Image File');
                $('#image').val('');
                return false;
            }
        }
    });
});