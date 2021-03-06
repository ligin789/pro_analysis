<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) == session_id()) {
    header("Location: ../dashboard.php");
    die();
} else {

    // Register check
    if (isset($_POST['registerSubmit'])) {
        // Empty check
        if (!empty($_POST['email']) and !empty($_POST['mobile'])) {
            // Collecting values
            extract($_POST);
            //check password and confirm password
            if ($password == $cpassword) {
                //Check if mobile already exisit
                $checkMobile = "SELECT * FROM `tbl_user` WHERE `user_mobile`='$mobile' and user_status!=0";
                $checkMobileResult = mysqli_query($connect, $checkMobile);
                $checkMobileCount = mysqli_num_rows($checkMobileResult);
                //No user exists
                if ($checkMobileCount == 0) {
                    //CHECK IF EMAIL ALREADY EXISTS
                    $checkEmail = "SELECT * FROM `tbl_user` WHERE `user_email`='$email' and user_status!=0";
                    $checkEmailResult = mysqli_query($connect, $checkEmail);
                    $checkEmailCount = mysqli_num_rows($checkEmailResult);
                    //No user exists
                    if ($checkEmailCount == 0) {
                        //create a random referal code during register
                        $n = 5;
                        function getName($n)
                        {
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $randomString = '';

                            for ($i = 0; $i < $n; $i++) {
                                $index = rand(0, strlen($characters) - 1);
                                $randomString .= $characters[$index];
                            }

                            return $randomString;
                        }
                        $RandomString = getName($n);
                        $name = strtolower($firstname) . " " . strtolower($lastname);
                        $password = md5($password);
                        $date = date("Y-m-d");
                        //Insert into database by checking condition
                        if (isset($referalId)) {
                            $updataBalanceOfAdmin=mysqli_query($connect,"UPDATE `tbl_user` SET `user_wallet_balance`=user_wallet_balance-150 WHERE `user_status`=2");
                            //update the wallet balance of referer and referei
                           $updateWalletBalance = "UPDATE `tbl_user` SET `user_wallet_balance`=user_wallet_balance+100 where user_id='$referalId'";
                            $updateWalletBalanceRes = mysqli_query($connect, $updateWalletBalance);
                            $insertDb = "INSERT INTO `tbl_user`(`user_email`, `user_name`, `user_mobile`, `user_password`, `user_created_at`,`user_referal_id`,`user_refered_status`,`user_wallet_balance`) VALUES ('$email','$name','$mobile','$password','$date','$RandomString','$referalId',50)";
                        } else {
                            $insertDb = "INSERT INTO `tbl_user`(`user_email`, `user_name`, `user_mobile`, `user_password`, `user_created_at`,`user_referal_id`) VALUES ('$email','$name','$mobile','$password','$date','$RandomString')";
                        }
                        $insertDbResult = mysqli_query($connect, $insertDb);
                        if ($insertDbResult) {
                            $_SESSION['loginMessage'] = "Register Success";
                            header("Location: ../dashboard.php");
                            die();
                        } else {
                            $_SESSION['loginMessage'] = "User Register Failed";
                            header("Location: register.php");
                            die();
                        }
                    } else {
                        $_SESSION['loginMessage'] = "User Email Already exisit";
                        header("Location: register.php");
                        die();
                    }
                } else {
                    $_SESSION['loginMessage'] = "User Mobile Already exisit";
                    header("Location: register.php");
                    die();
                }
            } else {
                $_SESSION['loginMessage'] = "Password Mismatch";
                header("Location: register.php");
                die();
            }
        } else {
            $_SESSION['loginMessage'] = "Please fill all fields";
            header("Location: register.php");
            die();
        }
    }
    // Login check
    if (isset($_POST['loginSubmit'])) {
        // Empty check
        if (!empty($_POST['email']) and !empty($_POST['password'])) {
            // Collecting values
            extract($_POST);
            $password = md5($password);
            //Check if mobile already exisit
            $checkLogin = "SELECT * FROM `tbl_user` WHERE `user_email`='$email' and user_password='$password' and user_status!=0";
            $checkLoginResult = mysqli_query($connect, $checkLogin);
            $checkLoginCount = mysqli_num_rows($checkLoginResult);
            //No user exists
            if ($checkLoginCount == 1) {
                $userData = mysqli_fetch_assoc($checkLoginResult);
                //admin login
                if ($userData['user_status'] == 2) {
                    $_SESSION['proAnalysisSessionAdmin'] = session_id();
                    $_SESSION['userName'] = $userData['user_name'];
                    header("Location: ../admin/index.php");
                    die();
                } else {
                    $_SESSION['proAnalysisSession'] = session_id();
                    $_SESSION['userName'] = $userData['user_name'];
                    $_SESSION['userID'] = $userData['user_id'];
                    $_SESSION['AccTYPE'] = $userData['acc_type'];
                    header("Location: ../dashboard.php");
                    die();
                }
            } else {
                $_SESSION['loginMessage'] = "User Login Failed";
                header("Location: index.php");
                die();
            }
        } else {
            $_SESSION['loginMessage'] = "Please fill all fields";
            header("Location: index.php");
            die();
        }
    }
    //check id valid
    if (isset($_POST['referalId'])) {
        extract($_POST);
        $checkReferalId = "SELECT * FROM `tbl_user` WHERE `user_referal_id`='$referalId' and user_status!=0";
        $checkReferalIdResult = mysqli_query($connect, $checkReferalId);
        $checkReferalIdCount = mysqli_num_rows($checkReferalIdResult);
        if ($checkReferalIdCount == 1) {
            $row = mysqli_fetch_array($checkReferalIdResult);
            $dataStatus = "true";
            $referaluserId = $row['user_id'];
        } else {
            $dataStatus = "false";
            $referaluserId = "";
        }
        echo json_encode(array("dataStatus" => $dataStatus, "referaluserId" => $referaluserId));
    }
}
