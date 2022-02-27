<?php
session_start();
include('cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: auth/");
    die();
} else {
    $userId=$_SESSION['userID'];

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
                    <?php
                    date_default_timezone_set('Asia/Calcutta');
                    // 24-hour format of an hour without leading zeros (0 through 23)
                    $Hour = date('G');

                    if ($Hour >= 5 && $Hour <= 11) {
                        echo "<h3 id='greetingMessage'>Good Morning <span class='text-primary'>" . ucwords($_SESSION['userName']) . "</span>, Welcome Back</h3>";
                    } else if ($Hour >= 12 && $Hour <= 18) {
                        echo "<h3 id='greetingMessage'>Good Afternoon <span class='text-primary'>" . ucwords($_SESSION['userName']) . "</span>, Welcome Back</h3>";
                    } else if ($Hour >= 19 || $Hour <= 4) {
                        echo "<h3 id='greetingMessage'>Good Evening <span class='text-primary'>" . ucwords($_SESSION['userName']) . "</span>, Welcome Back</h3>";
                    }
                    ?>
                </div>
                <?php
                $websiteCountSql="SELECT website_id from tbl_website where user_id='$userId'";
                $websiteCountResult=mysqli_query($connect,$websiteCountSql);
                if(mysqli_num_rows($websiteCountResult)>2)
                {
                   ?>
                   <div id="dashboardContainer">
                    <div class="form-group col-5">
                        <h2 class="my-3">Free Limit Over</h2>
                        <input type="text" class="form-control" id="websiteName" aria-describedby="emailHelp" placeholder="Enter your Website name" />
                    </div>
                    <div class="form-group my-4 col-5 d-flex">
                        <input type="text" class="form-control" id="websiteUrl" placeholder="Enter Website Url" onblur="checkWebsite(this)" />
                        <span id="WebsiteError" style="display: none;" class="mt-2 pl-4 text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                        <span id="websiteSuccess" style="display: none;" class="mt-2 pl-4 text-success"><i class="fa fa-check" aria-hidden="true"></i>
                        </span>
                        <span id="websiteLoading" style="display: none;" class="mt-2 pl-4 text-warning">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                    </div>

                    <button type="button" onclick="createCdn()" class="btn btn-primary ml-3">Create CDN</button>
                    <span id="finalAlert" class="ml-2 text-danger" style="display: none;">Hello</span>
                </div>
                   <?php
                }
                else
                {
                    ?>
                <div id="dashboardContainer">
                    <div class="form-group col-5">
                        <h2 class="my-3">Add New Website</h2>
                        <input type="text" class="form-control" id="websiteName" aria-describedby="emailHelp" placeholder="Enter your Website name" />
                    </div>
                    <div class="form-group my-4 col-5 d-flex">
                        <input type="text" class="form-control" id="websiteUrl" placeholder="Enter Website Url" onblur="checkWebsite(this)" />
                        <span id="WebsiteError" style="display: none;" class="mt-2 pl-4 text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                        <span id="websiteSuccess" style="display: none;" class="mt-2 pl-4 text-success"><i class="fa fa-check" aria-hidden="true"></i>
                        </span>
                        <span id="websiteLoading" style="display: none;" class="mt-2 pl-4 text-warning">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                    </div>

                    <button type="button" onclick="createCdn()" class="btn btn-primary ml-3">Create CDN</button>
                    <span id="finalAlert" class="ml-2 text-danger" style="display: none;">Hello</span>
                </div>
                <?php
                }
                ?>
                <!--Clipboard content start-->
                <div id="clipboardContainer" style="display: none;">
                    <div class="text-info">*****Copy the code and place in your website*****</div>
                    <div class='cdn-container' id='cdn-container'>
                        <textarea class='cdn-box' id='cdn-box' cols='100' rows='10'> <!--Analysis file (should be placed in head)-->
                <!--Skip the jqueryfile if already exisit-->
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
                <script type='text/javascript'>
                  let UserId = 'qg==';
                  let WebsiteId='qtI=';
                </script>
                <script src='https://proanalysis.000webhostapp.com/counter.js'></script>
                <!--End of Analysis file--></textarea>
                        <button id='copyContent' onclick="copyContent()" class='btn btnInfo mb-4'><i class='fas fa-clipboard'></i></button>
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
            let websiteStatus = false;
            $(document).ready(function() {
                $("#sidebarCollapse").on("click", function() {
                    $("#sidebar").toggleClass("active");
                });
            });
            //copy textarea content
            const copyContent = () => {
                let textarea = document.querySelector('#cdn-box');
                textarea.select();
                document.execCommand('copy');
                $('#copyContent').text('Copied!');
                setTimeout(() => {
                    $('#copyContent').text('Copy');
                }, 2000);
            }

            //check Url exisit or not
            function checkWebsite(Url) {
                //hide all icon and start loading
                $('#WebsiteError').css('display', 'none');
                $('#websiteSuccess').css('display', 'none');
                $('#websiteLoading').css('display', 'inline-block');
                //check using ajax
                $.ajax({
                    url: "./server/manageWebsite.php",
                    type: "POST",
                    data: {
                        Url: Url.value
                    },
                    success: function(data, status) {
                        $('#websiteLoading').css('display', 'none');
                        if (data == 404) {
                            websiteStatus = false;
                            $('#WebsiteError').css('display', 'inline-block');

                        } else if (data == 200) {
                            websiteStatus = true;
                            $('#websiteSuccess').css('display', 'inline-block');
                        }
                    }
                });
            }
            //extract domain name
            function extractHostname(url) {
                var hostname;
                //find & remove protocol (http, ftp, etc.) and get hostname

                if (url.indexOf("//") > -1) {
                    hostname = url.split('/')[2];
                } else {
                    hostname = url.split('/')[0];
                }

                //find & remove port number
                hostname = hostname.split(':')[0];
                //find & remove "?"
                hostname = hostname.split('?')[0];

                return hostname;
            }
            //Submit create cdn
            const createCdn = () => {
                $('#finalAlert').css('display', 'none');
                //check website status
                if (websiteStatus) {
                    let domain_name=extractHostname($('#websiteUrl').val());

                    //check website name is empty or not
                    if ($('#websiteName').val() != '') {
                        $.ajax({
                            url: "./server/manageWebsite.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                websiteName: $('#websiteName').val(),
                                websiteUrl: domain_name
                            },
                            success: function(data, status) {
                                if (data.status == 1) {
                                    $('#dashboardContainer').css('display', 'none');
                                    $('#clipboardContainer').css('display', 'block');
                                    document.getElementById("cdn-box").innerHTML = data.message;
                                } else if (data.status == '2') {
                                    document.getElementById("finalAlert").innerHTML = data.message;
                                    $('#finalAlert').css('display', 'inline-block');
                                } else if (data.status == '3') {
                                    document.getElementById("finalAlert").innerHTML = data.message;
                                    $('#finalAlert').css('display', 'inline-block');
                                }
                            }
                        });
                    } else {
                        $('#finalAlert').html('Website name is required');
                        $('#finalAlert').css('display', 'inline-block');
                    }
                } else {
                    $('#finalAlert').html('Website Url invalid');
                    $('#finalAlert').css('display', 'inline-block');
                }
            }
            //script for hiding salutation message
            setTimeout(changeGreeting, 4000);

            function changeGreeting() {
                document.getElementById('greetingMessage').innerHTML = "<i class='mdi mdi-view-dashboard'></i> Dashboard";
            }
        </script>
    </body>

    </html>
<?php
}
?>