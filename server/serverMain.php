<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
//cross checking with last inserted data
if (isset($_POST['ValidateData'])) {
    extract($_POST);
    include "../cred/dbConnect.php";
    //fetch the last inserted data
    $lastInsertedData = mysqli_query($connect, "SELECT * FROM `tbl_data` WHERE data_id='$ValidateData'");
    $lastInsertedDataArray = mysqli_fetch_assoc($lastInsertedData);
    //success of function
    if ($lastInsertedDataArray['data_Contient_name'] == $continment) {
        if ($lastInsertedDataArrayp['os_name'] == $osName) {
            if ($lastInsertedDataArray['data_browser'] == $browser_name) {
                if ($lastInsertedDataArray['data_browser_version'] == $browser_version) {
                    if ($lastInsertedDataArray['data_device_type'] == $devicetype) {
                        $data = array("last_id" => "Sucessssssss");
                    } else {
                        //update data to deactivate status
                        $data = array("last_id" => "error");
                        $resError = mysqli_query($connect, "UPDATE `tbl_data` SET `data_status`=0 WHERE data_id='$ValidateData'");
                    }
                } else {
                    //update data to deactivate status
                    $data = array("last_id" => "error");
                    $resError = mysqli_query($connect, "UPDATE `tbl_data` SET `data_status`=0 WHERE data_id='$ValidateData'");
                }
            } else {
                //update data to deactivate status
                $data = array("last_id" => "error");
                $resError = mysqli_query($connect, "UPDATE `tbl_data` SET `data_status`=0 WHERE data_id='$ValidateData'");
            }
        } else {
            //update data to deactivate status
            $resError = mysqli_query($connect, "UPDATE `tbl_data` SET `data_status`=0 WHERE data_id='$ValidateData'");
            $data = array("last_id" => "error");
        }
    } else {
        //update data to deactivate status
        $resError = mysqli_query($connect, "UPDATE `tbl_data` SET `data_status`=0 WHERE data_id='$ValidateData'");
        $data = array("last_id" => "error");
    }
    //error means deactivated
    echo json_encode($data);
}
if (isset($_POST['dummy'])) {
    extract($_POST);
    include "../cred/dbConnect.php";
    $error = '';
    //unencrypt the website id and userid
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    // Non-NULL Initialization Vector for encryption
    $decryption_iv = '1234567891011121';
    // Store the encryption key
    $decryption_key = "SADCAT";
    $websiteidOrginal = openssl_decrypt(
        $websiteid,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );
    $userIdOrginal = openssl_decrypt(
        $userid,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );
    //fetch the domain name is correct or not
    $fetchCurrentWebsite = "SELECT * from tbl_website where website_id='$websiteidOrginal'";
    $fetchCurrentWebsiteResult = mysqli_query($connect, $fetchCurrentWebsite);
    if (mysqli_num_rows($fetchCurrentWebsiteResult) > 0) {
        $fetchCurrentRow = mysqli_fetch_array($fetchCurrentWebsiteResult);
        $savedWebsitedomain = $fetchCurrentRow['website_domain'];
        $savedUserID = $fetchCurrentRow['user_id'];
        //check whether hosted domain and registed are same
        if ($currentdomain == $savedWebsitedomain) {
            //check whether ip address is valid or not
            if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
                $date = date("Y-m-d");
                //ad creation
                $fetchadvDetails = "SELECT * FROM `tbl_ads` where ads_status!=0";
                $fetchadvDetailsResult = mysqli_query($connect, $fetchadvDetails);
                if (mysqli_num_rows($fetchadvDetailsResult) > 0) {
                    $adsIdwiththisRegion = array();
                    $regionArray = array();
                    while ($fetchadvDetailsRow = mysqli_fetch_array($fetchadvDetailsResult)) {
                        //check with selected region
                        array_push($regionArray, $fetchadvDetailsRow['ads_region']);
                        if (in_array($country_name, $regionArray)) {
                            array_push($adsIdwiththisRegion, $fetchadvDetailsRow['ads_id']);
                        }
                        //check with expiry date
                        shuffle($adsIdwiththisRegion);
                        $selectedItem = $adsIdwiththisRegion[0];
                        $fetchSElectedSql = "SELECT * FROM `tbl_ads` WHERE ads_id='$selectedItem'";
                        $fetchSElectedResult = mysqli_query($connect, $fetchSElectedSql);
                        $fetchSElectedRow = mysqli_fetch_array($fetchSElectedResult);
                        $imgUrl = 'https://proanalysis.000webhostapp.com/proAn/' . $fetchSElectedRow['ads_banner_url'];
                        $adsdBox = "<a onclick='adsOnClick(" . $selectedItem . ")'><div style='position: absolute; right:10px;bottom:10px; box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;'><img src='" . $imgUrl . "' width='150' height='150' alt='adsImage'></div></a>
                        ";
                    }
                }
                $insertIntoDB = "INSERT INTO `tbl_data`(`data_user_id`, `data_website_id`, `data_Contient_name`, `data_ip`, 
                `os_name`, `data_browser`, `data_device_type`, `data_country`, `data_browser_version`, `data_timezone`, 
                `data_created_at`, `data_network_provider`,`data_region`,`data_latitude`,`data_longitude`) VALUES 
                ('$userIdOrginal','$websiteidOrginal','$continment','$ipAddress','$osName','$browser_name','$devicetype',
                '$country_name','$browser_version','$timeZone','$date','$network_provider','$region','$latitude','$longitude')";
                $insertResult = mysqli_query($connect, $insertIntoDB);
                $last_id = mysqli_insert_id($connect);
                //fetch id of the last inserted data
                if ($page == "") {
                    $insertWebPage = "INSERT INTO `tbl_pages`(`website_id`, `page_name`, `page_created_at`) VALUES ('$last_id','index.html','$date')";
                } else {
                    $insertWebPage = "INSERT INTO `tbl_pages`(`website_id`, `page_name`, `page_created_at`) VALUES ('$last_id','$page','$date')";
                }


                $insertWebPageResult = mysqli_query($connect, $insertWebPage);
            } else {
                $error = "ip address is invalid";
            }
        } else {
            $error = "domain name is invalid";
        }
    }
    $data = array("websiteid" => "dasd", "userid" => $userIdOrginal, "last_id" => $last_id, "printData" => $adsdBox);
    echo json_encode($data);
}
if ($_POST['page'] && $_POST['name']) {
    extract($_POST);
    include "../cred/dbConnect.php";
    $date = date("Y-m-d");
    $insertWebPage = "INSERT INTO `tbl_pages`(`website_id`, `page_name`, `page_created_at`) VALUES ('$last_id','$page','$date')";
    $insertWebPageResult = mysqli_query($connect, $insertWebPage);
    $last_id = mysqli_insert_id($connect);
    $data = array("last_id" => $last_id);
    echo json_encode($data);
}
//ads click and reveneue

if ($_POST['AdsID'] && $_POST['WebsiteId'] && $_POST['UserIp']) {
    extract($_POST);
    include "../cred/dbConnect.php";
    //check whether user with same ip had clicked on this ads or not
    $fetchAdsClicksql="SELECT `click_id` FROM `tbl_ads_click` WHERE `click_user_ip`='$UserIp' and `click_website_id`='$WebsiteId' and `click_status`!=0";
    $fetchAdsClickResult=mysqli_query($connect,$fetchAdsClicksql);
    if(mysqli_num_rows($fetchAdsClickResult)==0){
        //insert into click count table
        $date = date("Y-m-d");
        $insertClickCount="INSERT INTO `tbl_ads_click`( `click_user_ip`, `click_website_id`, `click_ads_id`, `click_created_at` ) VALUES ('$UserIp','$WebsiteId','$AdsID','$date')";
        $insertClickCountResult=mysqli_query($connect,$insertClickCount);

        //update website owner balance
        $fetchWebsiteOwnerSql="SELECT `user_id` FROM `tbl_website` WHERE `website_id`='$WebsiteId'";
        $fetchWebsiteOwnerResult=mysqli_query($connect,$fetchWebsiteOwnerSql);
        $fetchWebsiteOwnerRow=mysqli_fetch_array($fetchWebsiteOwnerResult);
        $websiteOwnerId=$fetchWebsiteOwnerRow['user_id'];
        //update his balance
        $updateOwnerBalnce="UPDATE `tbl_user` SET `user_wallet_balance`=`user_wallet_balance`+'o.1' WHERE `user_id`='$websiteOwnerId'";
        $updateOwnerBalnceResult=mysqli_query($connect,$updateOwnerBalnce);
        
    //update ads click count
    $updateAdsClickCount = "UPDATE `tbl_ads` SET `ads_click_count`=ads_click_count+1 WHERE ads_id='$AdsID'";
    $updateAdsClickCountResult = mysqli_query($connect, $updateAdsClickCount);
    //website ads click count
    $websiteAdsSql = "UPDATE `tbl_website` SET `ads_click_count`=ads_click_count+1 WHERE website_id='$WebsiteId'";
    $websiteAdsResult = mysqli_query($connect, $websiteAdsSql);
    }
}
