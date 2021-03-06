<?php
session_start();
include('cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: auth/");
    die();
} else {
    if (isset($_POST['fetchNewWebsite'])) {
        $websiteID = $_POST['fetchNewWebsite'];
        //fetch date of last 7 days
        $array = array();
        $dataPoints1 = array();
        $dataPoints2 = array();
        array_push($array, date("Y-m-d", strtotime("-0 day")));
        array_push($array, date("Y-m-d", strtotime("-1 day")));
        array_push($array, date("Y-m-d", strtotime("-2 day")));
        array_push($array, date("Y-m-d", strtotime("-3 day")));
        array_push($array, date("Y-m-d", strtotime("-4 day")));
        array_push($array, date("Y-m-d", strtotime("-5 day")));
        array_push($array, date("Y-m-d", strtotime("-6 day")));
        array_push($array, date("Y-m-d", strtotime("-7 day")));
        foreach ($array as $date) {
            $FetchDataMonth = "SELECT * from tbl_data where `data_website_id`='$websiteID' and `data_created_at`='$date' and `data_status`!=0";
            $FetchDataMonthResult = mysqli_query($connect, $FetchDataMonth);
            $count = mysqli_num_rows($FetchDataMonthResult);
            $temparray = array("label" => $date, "y" => $count);
            array_push($dataPoints1, $temparray);
        }
        foreach ($array as $date) {
            $FetchDataMonth = "SELECT DISTINCT data_ip from tbl_data where `data_website_id`='$websiteID' and `data_created_at`='$date' and `data_status`!=0";
            $FetchDataMonthResult = mysqli_query($connect, $FetchDataMonth);
            $count = mysqli_num_rows($FetchDataMonthResult);
            $temparray = array("label" => $date, "y" => $count);
            array_push($dataPoints2, $temparray);
        }
    } else {
        // header("Location: auth/logoutController.php");
    }

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.uikit.min.css">
        <link rel="stylesheet" href="./assets/css/dashboardstyle.css" />
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvtz1GjcbeOzhVK9Q09SQXcicu8pi--_o&callback=initMap"></script> -->
        <style>
            #map {
                height: 300px;
                /* The height is 400 pixels */
                width: 100%;
                /* The width is the width of the web page */
            }
        </style>
        <script>
            //fucntion for starting modal and looking data
            let fetchEachDataInModal = (dataID) => {
                $.ajax({
                    url: "./server/analysis.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        fetchDataModal: "Fsds",
                        dataID: dataID
                    },
                    success: function(data, status) {
                        var platFormImg="<img src='./assets/vectors/winLogo.png'";
                        var platFormImg="<img src='./assets/vectors/android.png'";
                        $("#isp-wrapper").html("<b>Internet Provider</b> : " + data.data_network_provider);
                        $("#location-wrapper").html("<b>Ip address</b> : " + data.data_ip);
                        $("#platform-wrapper").html("<b>Platform </b>: " + data.os_name);
                        $("#date-wrapper").html("<b>Date </b> : " + data.data_created_at);
                        $("#browser-wrapper").html("<b>Browser Details</b> : " + data.data_browser + data.data_browser_version);
                        $("#country-wrapper").html("<b>Country</b> : " + data.data_country);
                        $("#device-wrapper").html("<b>Device</b> : " + data.data_device_type);
                        $("#timzone-wrapper").html("<b>TimeZone</b> : " + data.data_timezone);
                        $('#eachDataModal').modal('show');
                        longitude = data.data_longitude;
                        latitude = data.data_latitude;
                        initMap(longitude,latitude);
                    },
                    error: function(responseData, textStatus, errorThrown) {
                        console.log(responseData, textStatus, errorThrown);
                    }
                });
            }
            // Initialize and add the map
            function initMap(longitude=1.2,latitude=1.2) {
                // The location of Uluru
                var uluru = {
                    lat: parseInt(latitude),
                    lng: parseInt(longitude)
                };
                // The map, centered at Uluru
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 4,
                    center: uluru,
                });
                // The marker, positioned at Uluru
                const marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                });
            }
        </script>
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
                    <h3>Website Analysis</h3>
                </div>
                <div class="dashboardContent">
                    <div class="heading-content" id="websiteLoad">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                    <div id="AllDataFeilds" class="tableContiner">

                    </div>
                    <!--end of small box-->

                    <!--data table end-->
                </div>
            </div>
        </div>
        <!--Modal starts-->
        <div class="modal fade bd-example-modal-lg" id="eachDataModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content mx-auto">
                    <center>
                        <h4>Location of user</h4>
                        <div class="mapWrapper">
                            <div id="map"></div>
                        </div>
                    </center>
                    <div class="info-wrapper">
                        <div class="d-flex flex-info">
                            <ul class="list-ul">
                                <li id="isp-wrapper">
                                    Isp :Bsnl
                                </li>
                                <li id="location-wrapper">
                                    Location :Kerala
                                </li>
                                <li id="platform-wrapper">
                                    Platform :Windows
                                </li>
                                <li id="date-wrapper">
                                    Date :2021-11-27
                                </li>
                            </ul>
                            <ul class="list-ul">
                                <li id="browser-wrapper">
                                    Browser :Chrome
                                </li>
                                <li id="country-wrapper">
                                    Country :India
                                </li>
                                <li id="device-wrapper">
                                    Device :Phone
                                </li>
                                <li id="timzone-wrapper">
                                    TimeZone :Asia/Kolkata
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal ends-->
        <script>
            window.onload = function() {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Last 7 days View"
                    },
                    axisY: {
                        includeZero: true
                    },
                    legend: {
                        cursor: "pointer",
                        verticalAlign: "center",
                        horizontalAlign: "right",
                        itemclick: toggleDataSeries
                    },
                    data: [{
                        type: "column",
                        name: "Total View",
                        indexLabel: "{y}",
                        yValueFormatString: "#0.##",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                    }, {
                        type: "column",
                        name: "Unique View",
                        indexLabel: "{y}",
                        yValueFormatString: "#0.##",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();

                function toggleDataSeries(e) {
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }

            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=visualization&callback=initMap">
        </script>

        <!--canvas js-->
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

        <!-- jQuery CDN - Full-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.js"></script>

        <!-- data table CDN - Full-->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></script>



        <script>
            $(document).ready(function() {
                $("#sidebarCollapse").on("click", function() {
                    $("#sidebar").toggleClass("active");
                });
            });
            $(document).ready(function() {
                $.ajax({
                    url: "./server/analysis.php",
                    type: "POST",
                    data: {
                        fetchAllDetailsEach: "fetchAllDetails",
                        websiteId: <?php echo $websiteID; ?>
                    },
                    success: function(data, status) {
                        $('#AllDataFeilds').html(data);
                    },
                    error: function(responseData, textStatus, errorThrown) {
                        console.log(responseData, textStatus, errorThrown);
                    }
                });
            });
        </script>


    </body>

    </html>
<?php
}
?>