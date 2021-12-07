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
                <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
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

        $getWebsite = "SELECT * FROM tbl_website WHERE   `user_id` = '$userID' and website_status!=0";
        $getWebsiteResult = mysqli_query($connect, $getWebsite);
        $items = "<table id='exampleTable' class='table table-striped table-bordered' style='min-width: 100%'>
        <thead id='thead'>
            <tr>
                <th>#</th>
                <th>Website Name</th>
                <th>Website Url</th>
                <th>Website created</th>
                <th>Website Updated</th>
                <th>Website Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>";
        $count = 1;
        if (mysqli_num_rows($getWebsiteResult) > 0) {
            while ($row = mysqli_fetch_assoc($getWebsiteResult)) {
                if ($row['website_status'] == 1) {
                    $status = "<button class='btn btn-success' disabled>Active</button>";
                } else {
                    $status = "<button class='btn btn-warning' disabled>Inactive</button>";
                }
                $items .= " <tr>
                <td>" . $count . "</td>
                <td>" . substr($row['website_name'], 0, 6) . "</td>
                <td>" . substr($row['website_domain'], 0, 11) . "</td>
                <td>" . $row['website_created_at'] . "</td>
                <td>" . $row['website_updated_at'] . "</td>
                <td>" . $status . "</td>
                <td><button class='btn btn-secondary' value='" . $row['website_id'] . "' onclick='editItem(this)'><i class='fas fa-edit'></i></button></td>
                <td><button class='btn btn-danger' onclick='deleteItem(this)' value='" . $row['website_id'] . "' ><i class='fas fa-trash-alt'></i></button></td>
            </tr>";
                $count++;
            }
            $items .= "</tbody></table>
            <script>
            $('#exampleTable').DataTable();
        </script>";
            $data = array("status" => "1", "message" => "success", "items" => $items);
            echo json_encode($data);
        }
    }
    //load modal of edit item
    if (isset($_POST['editItem']) and isset($_POST['itemid'])) {
        extract($_POST);
        $selectQuery = "SELECT * from tbl_website where website_id='$itemid' and website_status!=0";
        $selectQueryResult = mysqli_query($connect, $selectQuery);
        $selectQueryRow = mysqli_fetch_array($selectQueryResult);
        $data = array("status" => "1", "website_name" => $selectQueryRow['website_name'], "domain" => $selectQueryRow['website_domain'], "itemid" => $itemid);
        echo json_encode($data);
    }
    //update Website
    if (isset($_POST['UwebsiteName']) and isset($_POST['UwebsiteUrl'])) {
        extract($_POST);
        $updateItem = "UPDATE tbl_website SET `website_name`='$UwebsiteName',`website_domain`='$UwebsiteUrl' where website_id='$HiddenId'";
        $updateItemResult = mysqli_query($connect, $updateItem);
    }
    //delete website
    if (isset($_POST['deleteItem']) and isset($_POST['itemid'])) {
        extract($_POST);
        $deleteItem = "UPDATE tbl_website SET `website_status`='0' where website_id='$itemid'";
        $deleteItemResult = mysqli_query($connect, $deleteItem);
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