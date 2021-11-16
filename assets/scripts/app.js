function cpasswordValidate() {
    var pass = document.getElementById('pass').value;
    var cpass = document.getElementById('cpass').value;
    if(pass!=cpass){
       $('#subtext').html("** Password does not match the confirm password");
         $('#subtext').css("color","red");
        return false;
    }
    else
    {
        $('#subtext').html("Signup to make your admin account.");
        $('#subtext').css("color","blue");
    }
    
}