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
    
        if (form.username.value === "") {
        printError("err_username", " * Please Enter Username");
        form.username.focus();
        return false;
    }
    
        if (form.password.value === "") {
        printError("err_password", " * Please Enter Password");
        form.password.focus();
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

var provinceObject = {
    "Western": {
        "Colombo": ['Colombo North', 'Colombo Central', 'Borella', 'Colombo East', 'Colombo West', 'Dehiwala', 'Ratmalana', 'Kolonnawa', 'Kotte', 'Kaduwela', 'Awissawella', 'Homagama', 'Maharagama', 'Kesbewa', 'Moratuwa'],
        "Gampaha": ['Wattala', 'Negombo', 'Katana', 'Divulapitiya', 'Meerigama', 'Minuwangoda', 'Attanagalla', 'Gampaha', 'Ja-Ela', 'Mahara', 'Dompe', 'Biyagama', 'Kelaniya'],
        "Kalutara": ['Panadura', 'Bandaragama', 'Horana', 'Bulathsinhala', 'Mathugama', 'Kalutara', 'Beruwala', 'Agalawatta']
    },
    "Southern": {
        "Galle": ['Balapitiya', 'Ambalangoda', 'Karandeniya', 'Bentara-Elpitiya', 'Hiniduma', 'Baddegama', 'Rathgama', 'Galle', 'Akmeemana', 'Habaraduwa'],
        "Matara": ['Deniyaya', 'Hakmana', 'Akuressa', 'Kamburupitiya', 'Devinuwaraa', 'Matara', 'Weligama'],
        "Hambantota": ['Mulkirigala', 'Beliatta', 'Tangalle', 'Thissamaharamaya']
    },
    "Central": {
        "Kandy": ['Galagedara', 'Harispaththuwa', 'Pathadumbara', 'Udadumbara', 'Kundasale', 'Hewaheta', 'Senkadagala', 'Mahanuwara', 'Yatinuwara', 'Udunuwara', 'Gampola', 'Nawalapitiya'],
        "Matale": ['Dambulla', 'Laggala', 'Matale', 'Raththota'],
        "Nuwara-Eliya": ['Nuwara-Eliya', 'Kotmale', 'Hanguranketha', 'Walapane']
    },
    "Eastern": {
        "Batticaloa": ['Kalkuda', 'Batticaloa', 'Paddiruppu'],
        "Digamadulla": ['Ampara', 'Samanthurai', 'Kalmunai', 'Pothuvil'],
        "Trincomalee": ['Seruwil', 'Trincomalee', 'Mutur']
    },
    "North Central": {
        "Anuradhapura": ['Medawachchiya', 'Horowpathana', 'Anuradhapura East', 'Anuradhapura West', 'Kalawewa', 'Mihinthale', 'Kekirawa'],
        "Polonnaruwa": ['Minneriya', 'Medirigiriya', 'Polonnaruwa']
    },
    "North Western": {
        "Kurunegala": ['Galgamuwa', 'Nikaweratiya', 'Yapahuwa', 'Hiriyala', 'Wariyapola', 'Panduwasnuwara', 'Bingiriya', 'Katugampola', 'Kuliyapitiya', 'Dambadeniya', 'Polgahawela', 'Kurunegala', 'Mawathagama', 'Dodangaslanda'],
        "Puttalam": ['Puttalam', 'Anamaduwa', 'Chillaw', 'Naththandiya', 'Wennappuwa']
    },
    "Northern": {
        "Jaffna": ['Kayts', 'Waddukkoddai', 'Kankasanthurai', 'Manipay', 'Kopay', 'Uduppidi', 'Point Pedro', 'Chawakachcheri', 'Nallur', 'Jaffna', 'Kilinochchi'],
        "Vanni": ['Mannar', 'Vavuniya', 'Mullaitivu']
    },
    "Sabaragamuwa": {
        "Ratnapura": ['Eheliyagoda', 'Ratnapura', 'Pelmadulla', 'Balangoda', 'Rakwana', 'Nivithigala', 'Kalawana', 'Kolonna'],
        "Kegalle": ['Dedigama', 'Galigamuwa', 'Kegalle', 'Rambukkana', 'Borella', 'Mawanella', 'Aranayaka', 'Yatiyanthota', 'Ruwanwella', 'Kolonnawa', 'Deraniyagala']
    },
    "Uva": {
        "Badulla": ['Mahiyanganaya', 'Viyaluwa', 'Passara', 'Badulla', 'Hali Ela', 'Uva Paranagama', 'Welimada', 'Bandarawela', 'Haputale'],
        "Moneragala": ['Bibila', 'Moneragala', 'Wellawaya']
    }
}
window.onload = function () {
    var provinceSel = document.getElementById("province");
    var districtSel = document.getElementById("district");
    var divisionSel = document.getElementById("division");
    for (var x in provinceObject) {
        provinceSel.options[provinceSel.options.length] = new Option(x, x);
    }
    provinceSel.onchange = function () {
        $('#district').html('');
        $('#division').html('');
            //empty Province- and District- dropdowns
            divisionSel.length = 1;
            districtSel.length = 1;
        //display correct values
        for (var y in provinceObject[this.value]) {
            districtSel.options[districtSel.options.length] = new Option(y, y);
        }
    }
    districtSel.onchange = function () {
        $('#division').html('');
            //empty Division dropdown
            divisionSel.length = 1;
        //display correct values
        var z = provinceObject[provinceSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
            divisionSel.options[divisionSel.options.length] = new Option(z[i], z[i]);
        }
    }

}

$(function () {
    $("#grama_niladari_division").autocomplete({
        source: '../search_gn_division.php',
    });
});

