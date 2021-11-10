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
    if(isset($_POST['websiteName']) and isset($_POST['websiteUrl'])){
        extract($_POST);
        $userID=$_SESSION['userID'];
        $date=date("Y-m-d");
        $websiteName=strtolower($websiteName);
        //check whether the website is already exist
        $checkDup = "SELECT * FROM tbl_website WHERE website_domain = '$websiteUrl' and website_status!=0";
        if(mysqli_query($connect, $checkDup))
        {
            $insertWebsite="INSERT INTO `tbl_website`(`user_id`, `website_name`, `website_domain`, `website_created_at`) VALUES ('$userID','$websiteName','$websiteUrl','$date')";
            if(mysqli_query($connect, $insertWebsite))
            {
                echo "success";
            }
            else
            {
                echo "error";
            }
        }
        else
        {
            echo "website already registered";
        }
       
    }
}
