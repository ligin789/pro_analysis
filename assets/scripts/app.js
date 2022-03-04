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
var animation = bodymovin.loadAnimation({
	container: document.getElementById('anim'),
	renderer: 'svg',
	loop: true,
	autoplay: true,
	path: './assets/vectors/paperplane.json'
})
var animation1 = bodymovin.loadAnimation({
	container: document.getElementById('referal'),
	renderer: 'svg',
	loop: true,
	autoplay: true,
	path: './assets/vectors/referallottie.json'
})
var animation2 = bodymovin.loadAnimation({
	container: document.getElementById('anim3'),
	renderer: 'svg',
	loop: true,
	autoplay: true,
	path: './assets/vectors/walletLottie.json'
})
var animation4 = bodymovin.loadAnimation({
	container: document.getElementById('anim4'),
	renderer: 'svg',
	loop: true,
	autoplay: true,
	path: './assets/vectors/paymentLoading.json'
})