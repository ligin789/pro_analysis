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
                $websiteId = mysqli_insert_id($connect);
                //emcryption of website id and user id
                // Store the cipher method
                $ciphering = "AES-128-CTR";
                // Use OpenSSl Encryption method
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;
                // Non-NULL Initialization Vector for encryption
                $encryption_iv = '1234567891011121';
                // Store the encryption key
                $encryption_key = "SADCAT";
                // Use openssl_encrypt() function to encrypt the data
                $websiteID = openssl_encrypt(
                    $websiteId,
                    $ciphering,
                    $encryption_key,
                    $options,
                    $encryption_iv
                );
                $USERID = openssl_encrypt(
                    $userID,
                    $ciphering,
                    $encryption_key,
                    $options,
                    $encryption_iv
                );
                $data = array("status" => "1", "message" => " <!--Analysis file (should be placed in head)-->
                <!--Skip the jqueryfile if already exisit-->
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
                <script type='text/javascript'>
                  let UserId = '" . $USERID . "';
                  let WebsiteId='" . $websiteID . "';
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
    //load registered website on load
    if (isset($_POST['onLoadContent'])) {

        $userID = $_SESSION['userID'];

        $getWebsite = "SELECT * FROM tbl_website WHERE `user_id` = '$userID' and website_status!=0";
        $getWebsiteResult = mysqli_query($connect, $getWebsite);
        $items='';
        if (mysqli_num_rows($getWebsiteResult) > 0) {
            while ($row = mysqli_fetch_assoc($getWebsiteResult)) {
                $items .= "<div class='dash-box d-flex mt-2' data-tilt>
               <div class='content-text'>
                   <div class='dailyCount'>1,504</div>bb
               </div>
               <div class='icon-container ml-2 mt-3 text-secondary'>
                   <i class='fas fa-eye fa-3x'></i>
               </div>
             </div>";
            }
            $data = array("status" => "1", "message" => "success", "items" => $items);
            echo json_encode($data);
        }
    }
}

                // // Non-NULL Initialization Vector for decryption
                // $decryption_iv = '1234567891011121';
                // // Store the decryption key
                // $decryption_key = "GeeksforGeeks";
                // // Use openssl_decrypt() function to decrypt the data
                // $decryption = openssl_decrypt(
                //     $encryption,
                //     $ciphering,
                //     $decryption_key,
                //     $options,
                //     $decryption_iv
                // );
                // // Display the decrypted string
                // echo "Decrypted String: " . $decryption;