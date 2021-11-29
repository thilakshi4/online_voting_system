<?php

//input text feild
function inputElementManageUser($label, $icon, $placeholder, $name, $value) {
    $element = "
        <div class=\"input-group mb-3\">
            <div class=\"input-group-prepend\">
                <div class=\"input-group-text bg-warning\">$label &nbsp;$icon</div>
            </div>
        <input type=\"text\" name='$name'  value='$value' autocomplete=\"off\" class=\"form-control\"  placeholder='$placeholder'>
         </div>
         ";
    echo $element;
}

//input text feild with id attribute
function inputElementManageUser_id($label, $icon, $placeholder, $name, $value,$id) {
    $element = "
        <div class=\"input-group mb-3\">
            <div class=\"input-group-prepend\">
                <div class=\"input-group-text bg-warning\">$label &nbsp;$icon</div>
            </div>
        <input type=\"text\" name='$name' id='$id' value='$value' autocomplete=\"off\" class=\"form-control\"  placeholder='$placeholder'>
         </div>
         ";
    echo $element;
}

//input text feild with id attribute
function inputElementManageUser_idp($label, $icon, $placeholder, $name, $value,$id) {
    $element = "
        <div class=\"input-group mb-3\">
            <div class=\"input-group-prepend\">
                <div class=\"input-group-text bg-warning\">$label &nbsp;$icon</div>
            </div>
        <input type=\"password\" name='$name' id='$id' value='$value' autocomplete=\"off\" class=\"form-control\"  placeholder='$placeholder'>
         </div>
         ";
    echo $element;
}

function buttonElement($btnid, $styleclass, $text, $name, $attr) {
    $btn = "
	<button name='$name' '$attr' class='$styleclass' id='$btnid'>$text</button >
";
    echo $btn;
}

function TextNode($classname, $msg) {
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


function TableText($classname, $msg) {
    $element = "<i><b><h5 class='$classname'>$msg</h5></b></i>";
    echo $element;
}

function sendsms_forget_password($mobile, $username, $pass) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Your account details for online voting system is updated. Now you can access your account by providing follwing "
            . "username " . '"' . $username . '"' . " and password " . '"' . $pass . '"');
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//send sms to new register until approve
function sendsms_for_registation($mobile, $ref_number) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Your registration on progress. The futher details will send to registered mobile number shortly. "
            . "Your Reference No is " . $ref_number);
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//send meassage about voting
function sendsms_vote($mobile) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Your vote is recorded successfully");
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//send meassage about candidate registration
function sendsms_candidate_registration($mobile) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Candidate registration success.");
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//send sms successfull registration of political party 
function sendsms_political_party_registation_details($mobile, $username, $pass) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Your political party registration success. Now you can access your account by providing follwing "
            . "username " . '"' . $username . '"' . " and password " . '"' . $pass . '"');
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//send sms to success registraion
function sendsms_registation_success($mobile, $username, $pass) {
    $user = "94711354383";
    $password = "9833";
      $text = urlencode("Your registration for online electoral system is completed successfully. Now you can access your account by providing user name and password. "
            . "username " . '"' . $username . '"' . " and password " . '"' . $pass . '"' );
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Message Sent Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//reject registration
function sendsms_registation_reject($mobile, $comments) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("You registration not accepted. Information provided is not valid. ( " . $comments . " ) Please re-register. ");
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

//officer registration via department 
function sendsms_officer__registration($mobile, $username, $pass) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("New account is created for online voting system. Now you can access your account by providing follwing "
            . "username " . '"' . $username . '"' . " and password " . '"' . $pass . '"');
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully ');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}

function sendsms_officer__update($mobile, $username, $pass) {
    $user = "94711354383";
    $password = "9833";
    $text = urlencode("Your account details for online voting system is updated. Now you can access your account by providing follwing "
            . "username " . '"' . $username . '"' . " and password " . '"' . $pass . '"');
    $to = $mobile;

    $baseurl = "http://www.textit.biz/sendmsg";
    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
    $ret = file($url);

    $res = explode(":", $ret[0]);

    if (trim($res[0]) == "OK") {
        TextNode("success", 'Details Sent to Registered Mobile Number Successfully');
    } else {
        TextNode("error", 'Error Occured.Message Not Delivered');
    }
}
