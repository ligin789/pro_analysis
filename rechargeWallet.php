<?php
session_start();
include('cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: auth/");
    die();
} else {
    $userId = $_SESSION['userID'];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Pro Analysis | Wallet</title>
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/vectors/Logo.svg" />

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="./assets/css/dashboardstyle.css" />

        <!-- Font Awesome JS -->

        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    </head>

    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <?php include('layout/dashBoardHead.php'); ?>

            <!-- Page Content  -->
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btnInfo">
                            <i class="fas fa-align-left"></i>
                            <span></span>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-align-justify"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Profile <i class="fas fa-user-circle"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./auth/logoutController.php">Logout <i class="fas fa-sign-out-alt"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <h2>Recharge Wallet </h2>
                <form>
                    <div class="card mx-auto mt-5 rounded px-2" style="width: 22rem;">
                        <h3 class="mx-auto mt-3">Select the amount</h3>

                        <div class="radio my-2 h6 mx-auto"><input type="radio" name="amt" class="ml-4" id="amt100" value="100" required>100
                            <input type="radio" name="amt" value="500" class="ml-4" id="amt500" required>500
                            <input type="radio" name="amt" value="1000" class="ml-4" id="amt1000" required>1000
                        </div>


                        <div class="mx-auto mb-3">
                            <button type="submit" id="payment" class="btn btn-success">Pay</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            document.getElementById('payment').onclick = function(e) {
                if (document.getElementById('amt1000').checked) {
                    amt = 1000 * 100;
                } else if (document.getElementById('amt500').checked) {
                    amt = 500 * 100;
                } else if (document.getElementById('amt100').checked) {
                    amt = 100 * 100;
                }
                var options = {
                    "key": "rzp_test_rHL7LKby0aHazx", // Enter the Key ID generated from the Dashboard
                    "amount": amt, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                    "currency": "INR",
                    "name": "ProAnalysis Ltd",
                    "description": "Wallet Recharge",
                    "image": "./assets/vectors/Logo.svg",
                    "handler": function(response) {
                        //success function
                        $.ajax({
                            url: "./server/upgradeProServer.php",
                            type: "POST",
                            data: {
                                razorpay_payment_id: response.razorpay_payment_id,
                                Amt:amt
                            },
                            success: function(data, status) {
                                console.log(data);
                                window.location.href = "./proWallet.php";
                            },
                            error: function(responseData, textStatus, errorThrown) {
                                console.log(responseData, textStatus, errorThrown);
                            }
                        });
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
                e.preventDefault();
            }
        </script>
    </body>

    </html>
<?php
}
?>