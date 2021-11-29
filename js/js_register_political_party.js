  
 function printError(elemId, hintMsg) {
    document.getElementById(elemId).innerHTML = hintMsg;
}
 
function checkForm(form)
{
    // validation fails if the inputs are blank
    if (form.ppfullname.value === "") {
        printError("err_ppfullname", " * Please enter political party name");
        form.ppfullname.focus();
        return false;
    }

    if (form.ppshortname.value === "") {
        printError("err_ppshortname", "  * Please enter political party abbrevation");
        form.ppshortname.focus();
        return false;
    }
    
    if (form.favcolor.value === "#a8aaad") {
        printError("err_favcolor", " * Please select the color");
        form.favcolor.focus();
        return false;
    }

    if (form.prsedient_name.value === "") {
        printError("err_prsedient_name", " * Please enter secretary name");
        form.prsedient_name.focus();
        return false;
    }

    if (form.NIC.value === "") {
        printError("err_NIC", " * Please enter NIC number");
        form.NIC.focus();
        return false;
    }
    if (form.mobile.value === "") {
        printError("err_mobile", " * Please enter mobile number");
        form.mobile.focus();
        return false;
    }

    if (form.address.value === "") {
        printError("err_address", " * Please enter address");
        form.address.focus();
        return false;
    }

    //-- regular expression to match NIC number--
    var re_nic = /^[V0-9]{9,12}$/;
    if (!re_nic.test(form.NIC.value)) {
        printError("err_NIC", " * Please Enter Valid NIC Number");
        form.NIC.focus();
        return false;
    }

    //-- regular expression to match valid full name letters and space--
    var re_name = /^[A-Za-z\s]/;
    if (!re_name.test(form.ppfullname.value)) {
        printError("err_ppfullname", " * Please Enter Valid Name");
        form.ppfullname.focus();
        return false;
    }

    // --regular expression to match mobile number--
    var re_mob = /^([0]{1})([7]{1})([0-9]{8})$/;
    if (!re_mob.test(form.mobile.value)) {
        printError("err_mobile", " * Please Enter Valid Mobile Number");
        form.mobile.focus();
        return false;
    }

    // validation was successful
    return true;
}

 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name === '')  
           {  
                 printError("err_image", " * Please select an image"); 
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });