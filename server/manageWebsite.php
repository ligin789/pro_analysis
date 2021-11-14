<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    //check website exisit
    if (isset($_POST['Url'])) {
        extract($_POST);
        $headers = @get_headers($Url);

        // Use condition to check the existence of URL
        if ($headers && strpos($headers[0], '200')) {
            echo "200";
        } else {
            echo "404";
        }
    }
    //insert website
    if (isset($_POST['websiteName']) and isset($_POST['websiteUrl'])) {
        extract($_POST);
        $userID = $_SESSION['userID'];
        $date = date("Y-m-d");
        $websiteName = strtolower($websiteName);
        //check whether the website is already exist
        $checkDup = "SELECT * FROM tbl_website WHERE website_domain = '$websiteUrl' and website_status!=0";
        $checkDupResult = mysqli_query($connect, $checkDup);
        if (mysqli_num_rows($checkDupResult) < 1) {
            $insertWebsite = "INSERT INTO `tbl_website`(`user_id`, `website_name`, `website_domain`, `website_created_at`) VALUES ('$userID','$websiteName','$websiteUrl','$date')";
            if (mysqli_query($connect, $insertWebsite)) {
                $websiteId=mysqli_insert_id($connect);
                $data = array("status" => "1", "message" => " <!--Analysis file (should be placed in head)-->
                <!--Skip the jqueryfile if already exisit-->
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
                <script type='text/javascript'>
                  let UserId = '".$userID."';
                  let WebsiteId='".$websiteId."';
                </script>
                <script src='https://proanalysis.000webhostapp.com/counter.js'></script>
                <!--End of Analysis file-->");
            } else {
                $data = array("status" => "2", "message" => "Error");
            }
        } else {
            //else website already 
            $data = array("status" => "3", "message" => "Website already exisit");
        }
        echo json_encode($data);
        
    }
}
