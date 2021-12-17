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
                        $RandomString=getName($n);
                        $name = strtolower($firstname) . " " . strtolower($lastname);
                        $password = md5($password);
                        $date = date("Y-m-d");
                        //Insert into database
                        $insertDb = "INSERT INTO `tbl_user`(`user_email`, `user_name`, `user_mobile`, `user_password`, `user_created_at`,`user_referal_id`) VALUES ('$email','$name','$mobile','$password','$date','$RandomString')";
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
                $_SESSION['proAnalysisSession'] = session_id();
                $_SESSION['userName'] = $userData['user_name'];
                $_SESSION['userID'] = $userData['user_id'];
                header("Location: ../dashboard.php");
                die();
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
}
