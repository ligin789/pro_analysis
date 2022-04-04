<?php
session_start();
include('cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: auth/");
    die();
} else {


?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Pro Analysis | Dashboard</title>
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/vectors/Logo.svg" />


        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <script src="./assets/scripts/heatmap.js"></script>

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.uikit.min.css">
        <link rel="stylesheet" href="./assets/css/dashboardstyle.css" />
        <link rel="stylesheet" href="./assets/css/ad.css" />
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

                <div class="container-ads">
                    <div class="topbar-ads">
                        <form class="search-container">
                            <input type="text" id="search-bar" placeholder="What can I help you with today?">
                            <a href="#"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>
                        </form>
                    </div>
                    <div class="ads-items-container">
                        <a class="ads-box-empty text-center" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus fa-3x mt-4" aria-hidden="true" title="Add new Ads"></i>
                        </a>
                    </div>
                </div>

                <!--data table end-->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Advertisment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div id="first">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Advertisment Name</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter advertisment">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Advertisment URL</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter advertisment url">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Size of banner</label>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <option default>Select</option>
                                                <option value="1">1 * 1</option>
                                                <option value="2">1 * 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="intensityOfAd">Intensity of ads</label>
                                            <select class="form-control" id="intensityOfAd">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleFormControlSelect1">Category of ads</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="travel" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Travel
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="food" id="flexCheckChecked" >
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Food
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="automobile" id="flexCheckChecked" >
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Automobile
                                                </label>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Country Name</label>
                                            <select class="form-control" id="exampleFormControlSelect1">
                                                <?php
                                                $selectCountry = "SELECT DISTINCT data_country from tbl_data";
                                                $selectCountryRes = mysqli_query($connect, $selectCountry);
                                                if (mysqli_num_rows($selectCountryRes) > 0) {
                                                    while ($countryRow = mysqli_fetch_array($selectCountryRes)) {
                                                ?>
                                                        <option><?php echo $countryRow['data_country']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>


                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1">Poster</label>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                        </div>
                                    </div>
                                    <div id="second" style="display:none">
                                        <label id="Select Month of ads expiry"></label>
                                        <div class="slidecontainer">
                                            <input type="range" min="1" max="12" value="1" class="slider" id="myRange" onchange="priceCalculator(this.value)">
                                        </div>
                                        <div class="label">
                                            Total Month Selected
                                            <label id="month"></label><br>
                                            Total Price
                                            <label id="priceDetails"></label>                                
                                        </div>
                                    </div>
                                    <div id="last"></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="firstButton" onclick="firstPageSuccess()">Next</button>
                                <button type="button" class="btn btn-primary" id="secondButton" style="display: none;">Payment</button>
                                <button type="button" class="btn btn-primary" id="firstBackButton" onclick="secondPageBack()" style="display: none;">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value; // Display the default slider value

            // Update the current slider value (each time you drag the slider handle)
            slider.oninput = function() {
                output.innerHTML = this.value;
            }
            function priceCalculator(val) {
                var planType=<?php echo $_SESSION['AccTYPE'];?>;
                var intensity=$('#intensityOfAd').val();
                document.getElementById('month').innerHTML = val + " Month";
                let totalValue=0;
                var basic=100;
                if(planType==1){
                    totalValue=basic*val*intensity;
                }else if(planType==2){
                    totalValue=basic*val*intensity;
                    var percent=totalValue*20/100;
                    totalValue=totalValue-percent;
                  }
                  else if(planType==3)
                  {
                    totalValue=basic*val*intensity;
                    var percent=totalValue*50/100;
                    totalValue=totalValue-percent;
                  }
                document.getElementById("priceDetails").innerHTML = totalValue + " Rs";
            }
            //page redirection functions
            function firstPageSuccess()
            {
                $('#first').hide();
                $('#second').show();
                $('#firstButton').hide();
                $('#secondButton').show();
                $('#firstBackButton').show();
            }
            function secondPageBack()
            {
                $('#first').show();
                $('#second').hide();
                $('#firstButton').show();
                $('#secondButton').hide();
                $('#firstBackButton').hide();
            }
        </script>
    </body>

    </html>
<?php
}
?>