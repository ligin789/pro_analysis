<button id="rzp-button1">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var amt=50*100;
var options = {
    "key": "rzp_test_rHL7LKby0aHazx", // Enter the Key ID generated from the Dashboard
    "amount": amt, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "ProAnalysis Ltd",
    "description": "Test Transaction",
    "image": "./assets/vectors/Logo.svg",
    "handler": function (response){
       
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>