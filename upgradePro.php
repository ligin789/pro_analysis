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
        <title>Pro Analysis | Dashboard</title>
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
                <!--Main content-->
                <div class="welcome-msg pt-1 pb-4">
                    <h3 id='greetingMessage'>Pro Upgrade Plans <span class='text-primary'></h3>
                </div>
                <div class="text-center">
                    <div class="container">
                        <div class="row pt-4">
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-header">
                                        <h4 class="my-0 font-weight-normal">Free</h4>
                                    </div>
                                    <div class="card-body">
                                        <h1><b>0 Rs</b><small class="text-muted"></small></h1>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <li>Can add 2 website</li>
                                            <li>Email support</li>
                                            <li>Help center access</li>
                                            <li>""</li>
                                        </ul> <a href="./dashboard.php"><button type="button" class="btn btn-lg btn-block btn-outline-info">Continue with this plan</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-header">
                                        <h4 class="my-0 font-weight-normal">Basic</h4>
                                    </div>
                                    <div class="card-body">
                                        <h1><b>100 Rs </b><small class="text-muted"></small></h1>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <li>10 Website</li>
                                            <li>Ads price 20% off </li>
                                            <li>Priority email support</li>
                                            <li>Help center access</li>
                                        </ul> <a href="./walletPayment.php"><button type="button" class="btn btn-lg btn-block btn-primary">Upgrade</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-header">
                                        <h4 class="my-0 font-weight-normal">Premium</h4>
                                    </div>
                                    <div class="card-body">
                                        <h1><b>500 Rs</b><small class="text-muted"></small></h1>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <li>UnLimied website</li>
                                            <li>Ads price 50% off </li>
                                            <li>Phone and email support</li>
                                            <li>Help center access</li>
                                        </ul> <a href="./walletPayment.php"><button type="button" class="btn btn-lg btn-block btn-primary">Upgrade</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <!-- jQuery CDN - Full-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <script type="text/javascript">
            function getValue(Id) {
                if (Id.value == 1) {
                    $('#planValue').html(100 + 'Rs');

                } else {
                    $('#planValue').html(500 + 'Rs');
                }
            }

            function nextStep() {
                $('#planSelect').hide();
                $.ajax({
                    url: "./server/upgradeProServer.php",
                    type: "POST",
                    data: {
                        seeee: "dummy",
                    },
                    success: function(data, status) {
                        $('#planValue').html("Balance in wallet " + data);
                        $('#head').html('Select the payment method');
                    },
                    error: function(responseData, textStatus, errorThrown) {
                        console.log(responseData, textStatus, errorThrown);
                    }
                });

            }
        </script>
    </body>

    </html>
<?php
}
?>