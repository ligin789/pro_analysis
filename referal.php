<?php
session_start();
include('cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: auth/");
    die();
} else {
    $fetchAverageCount = "SELECT * from tbl_data where data_created_at > current_date - interval 7 day";
    $fetchAverageCountRes = mysqli_query($connect, $fetchAverageCount);
    $fetchAverageCountResC = mysqli_num_rows($fetchAverageCountRes);
    $average = $fetchAverageCountResC / 7;
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Pro Analysis | Referal</title>
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/vectors/Logo.svg" />
        <style>
            #map {
                height: 100%;
                width: 100%;
            }

            .barchart button {
                background-color: #4CAF50;
                color: white;
                padding: 2px 5px;
                margin: 1px 0;
                border: none;
                cursor: pointer;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <script src="./assets/scripts/heatmap.js"></script>

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.uikit.min.css">
        <link rel="stylesheet" href="./assets/css/dashboardstyle.css" />
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <style>

        </style>

        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvtz1GjcbeOzhVK9Q09SQXcicu8pi--_o&callback=initMap"></script> -->


    </head>

    <body onunload="logout()">
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
                                    <a class="nav-link" href="#"><?php echo ucwords($_SESSION['userName']); ?> <i class="fas fa-user-circle"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./auth/logoutController.php">Logout <i class="fas fa-sign-out-alt"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!--Main content-->
                <center>
                    <h2>Invite your friends to Pro Analysis</h2>
                    <h5>Invite friends to Pro Analysis and get 100 Pro Analysis Token <br> <br> when your friends add his first website and they will get 50 pro Analysis Token</h5>

                    <div id="referal" class="image-one">
                        <label for="referalID">Tap to Copy Referal Id</label>
                        <?php
                        $fetchRefer="SELECT user_referal_id from tbl_user where `user_id` = '$_SESSION[userID]'";
                        $fetchReferRes = mysqli_query($connect, $fetchRefer);
                        $fetchReferResC = mysqli_fetch_array($fetchReferRes);
                        echo '<input type="text" value="'.$fetchReferResC["user_referal_id"].'" name="referalID" id="referalID">';
                        ?>
                    </div>
                </center>
                <!--data table end-->
            </div>
        </div>
        </div>
        <script src="./assets/scripts/lottie.js"></script>
        <script src="./assets/scripts/app.js"></script>


        <!-- char js CDN - Full-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <!-- jQuery CDN - Full-->
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.js"></script>

        <!-- data table CDN - Full-->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $('#exampleTable').DataTable();
            });
            let websiteStatus = false;
            $(document).ready(function() {
                $("#sidebarCollapse").on("click", function() {
                    $("#sidebar").toggleClass("active");
                });
            });


            //script for hiding salutation message
            setTimeout(changeGreeting, 4000);

            function changeGreeting() {
                document.getElementById('greetingMessage').innerHTML = "<i class='mdi mdi-view-dashboard'></i> Dashboard";
            }
            /* Data points defined as an array of LatLng objects */
        </script>
        <script src="./ajaxRequest.js"></script>
        <script src="./assets/scripts/chart.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=visualization&callback=initMap">
        </script>
        <script type="text/javascript">
            function logout() {
                console.log("logout");
            }
        </script>
    </body>

    </html>
<?php
}
?>