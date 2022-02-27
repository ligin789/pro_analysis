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
                $insertIntoDB = "INSERT INTO `tbl_data`(`data_user_id`, `data_website_id`, `data_Contient_name`, `data_ip`, 
                `os_name`, `data_browser`, `data_device_type`, `data_country`, `data_browser_version`, `data_timezone`, 
                `data_created_at`, `data_network_provider`,`data_region`,`data_latitude`,`data_longitude`) VALUES 
                ('$userIdOrginal','$websiteidOrginal','$continment','$ipAddress','$osName','$browser_name','$devicetype',
                '$country_name','$browser_version','$timeZone','$date','$network_provider','$region','$latitude','$longitude')";
                $insertResult = mysqli_query($connect, $insertIntoDB);
                //fetch id of the last inserted data
                $last_id = mysqli_insert_id($connect);
                $insertWebPage = "INSERT INTO `tbl_pages`(`website_id`, `page_name`, `page_created_at`) VALUES ('$last_id','$page','$date')";
                $insertWebPageResult = mysqli_query($connect, $insertWebPage);
            } else {
                $error = "ip address is invalid";
            }
        } else {
            $error = "domain name is invalid";
        }
    }
    $data = array("websiteid" => $error, "userid" => $userIdOrginal, "last_id" => $last_id);
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
