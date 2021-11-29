<form actiom="" method="POST" onsubmit="return validation(this);">
<input type="text" id="name" name="name">
<div style="color: red"><label id="errer"></label> </div>
<input type="submit" value="test" name="test">

</form>
<script>

function printErr(element,himt){
    document.getElementById(element).innerHTML=himt;
}

function validation(form){
    
    if(form.name.value===""){
        printErr('errer','*test');
        form.name.focus();
        return false;
    }
    
        re_test=/^\b\S+.\s\S+$/;
        //re_test=/^(?=.*[0-9]).{3}(?=.*[a-z]).{3,}$/;
    if(!re_test.test(form.name.value))
    {
        printErr('errer','*erreor');
        form.name.focus();
        return false;
    }
    return true;
}
</script>