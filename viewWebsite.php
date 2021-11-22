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

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="./assets/css/dashboardstyle.css" />

        <!-- Font Awesome JS -->

        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    </head>

    <body onload="loadWebsite()">
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
                <h2>Website You have registered</h2>
                <div id="heading-content">
                    <!--Each small box-->
                    <center>
                        <div id="anim" class="image-one">
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <!--Modal-->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Your Website</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Website Name</label>
                                <input type="text" class="form-control" id="website_name" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Domain name</label>
                                <input type="hidden" id="hiddenId">
                                <input type="text" class="form-control" id="website_domain" onblur="checkWebsite(this)" placeholder="Password">
                                <span id="WebsiteError" style="display: none;" class="mt-2 pl-4 text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                                <span id="websiteSuccess" style="display: none;" class="mt-2 pl-4 text-success"><i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                <span id="websiteLoading" style="display: none;" class="mt-2 pl-4 text-warning">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span id="finalAlert" class="ml-2 text-danger" style="display: none;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateCdn()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Modal-->
        <script src="./assets/scripts/lottie.js"></script>
        <script src="./assets/scripts/app.js"></script>

        <!--- Top Bar  -->
        <script src="./assets/scripts/topbar.min.js"></script>
        <!--- Top Bar  end-->

        <!-- data table CDN - Full-->

        <!-- jQuery CDN - Full-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <script type="text/javascript">
            let websiteStatus = false;

            //editItem
            const editItem = (ItemID) => {
                let itemid = ItemID.value;
                $.ajax({
                    url: "./server/manageWebsite.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        editItem: "load",
                        itemid: itemid
                    },
                    success: function(data, status) {
                        $('#website_name').val(data.website_name);
                        $('#website_domain').val(data.domain);
                        $('#hiddenId').val(data.itemid);
                        $('#exampleModal').modal('show');
                    }
                });
            }
            //check url exisit
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
            //update
            //Submit create cdn
            const updateCdn = async () => {
                let webDomain = $('#website_domain');
                $('#finalAlert').css('display', 'none');
                //check website status
                checkWebsite();
                if (websiteStatus) {
                    //check website name is empty or not
                    if ($('#website_name').val() != '') {
                        $.ajax({
                            url: "./server/manageWebsite.php",
                            type: "POST",
                            data: {
                                HiddenId: $('#hiddenId').val(),
                                UwebsiteName: $('#website_name').val(),
                                UwebsiteUrl: $('#website_domain').val()
                            },
                            success: function(data, status) {
                                topbarLoading();
                                $('#exampleModal').modal('hide');
                                loadWebsite();
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
            $(document).ready(function() {
                $("#sidebarCollapse").on("click", function() {
                    $("#sidebar").toggleClass("active");
                });
            });
            const loadWebsite = () => {
                let contte = 'fdsfsdgdgs';
                $.ajax({
                    url: "./server/manageWebsite.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        onLoadContent: contte
                    },
                    success: function(data, status) {
                        setTimeout(() => {
                            $('#heading-content').html(data.items);
                        }, 1500);

                    }
                });
            }
            const deleteItem = (ItemId) => {
                let itemid = ItemId.value;
                $.ajax({
                    url: "./server/manageWebsite.php",
                    type: "POST",
                    data: {
                        deleteItem: "delete",
                        itemid: itemid
                    },
                    success: function(data, status) {
                        topbarLoading();
                        loadWebsite();
                    }
                });
            }

            //script for hiding salutation message
            setTimeout(changeGreeting, 4000);

            function changeGreeting() {
                document.getElementById('greetingMessage').innerHTML = "<i class='mdi mdi-view-dashboard'></i> Dashboard";
            }
            //topbar notification
            const topbarLoading = () => {
                topbar.config({
                    autoRun: false,
                    barThickness: 5,
                    barColors: {
                        '0': 'rgba(26,  188, 156, .7)',
                        '.3': 'rgba(41,  128, 185, .7)',
                        '1.0': 'rgba(231, 76,  60,  .7)'
                    },
                    shadowBlur: 5,
                    shadowColor: 'rgba(0, 0, 0, .5)',
                    className: 'topbar',
                })
                topbar.show();
                (function step() {
                    setTimeout(function() {
                        if (topbar.progress('+.01') < 1) step()
                    }, 16)
                })()
                setTimeout(() => {
                    topbar.hide();
                }, 2000);
            }
        </script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></script>
    </body>

    </html>
<?php
}
?>