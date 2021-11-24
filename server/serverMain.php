<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
if(isset($_POST['websiteid']) and isset($_POST['userid']) and isset($_POST['browser_name']) and isset($_POST['browser_version'])){
    extract($_POST);
   
    if(isset($network_provider))
    {
        
    }
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
        $fetchCurrentWebsite="SELECT * from tbl_webiste where website_id='$websiteidOrginal'";
        $fetchCurrentWebsiteResult=mysqli_query($connect,$fetchCurrentWebsite);
        if(mysqli_num_rows($fetchCurrentWebsiteResult)>0)
        {
            $fetchCurrentRow=mysqli_fetch_array($fetchCurrentWebsiteResult);
            $savedWebsitedomain=$fetchCurrentRow['website_domain'];
            $savedUserID=$fetchCurrentRow['user_id'];
            //check whether hosted domain and registed are same
            if($currentdomain==$savedWebsitedomain and $savedUserID==$userIdOrginal)
            {
                $date = date("Y-m-d");
                $insertIntoDB="INSERT INTO `tbl_data`(`data_user_id`, `data_website_id`, `data_Contient_name`, `data_ip`, `os_name`, `data_browser`, `data_device_type`, `data_country`, `data_browser_version`, `data_timezone`, `data_created_at`, `data_network_provider`) VALUES 
                ('$userIdOrginal','$currentdomain','$continment','$ipAddress','$osName','$browser_name','$devicetype','$country_name','$browser_version','$timeZone','$date','$network_provider')";
                $insertResult=mysqli_query($connect,$insertIntoDB);
            }
        }
        $data = array("websiteid" => $websiteidOrginal, "userid" => $userIdOrginal);
        echo json_encode($data);
}
