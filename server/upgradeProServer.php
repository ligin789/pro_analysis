<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    if (isset($_POST['seeee'])) {
        $userData = $_SESSION['userID'];
        $select = "SELECT * from tbl_user where user_id='$userData'";
        $selectResult = mysqli_query($connect, $select);
        $row = mysqli_fetch_array($selectResult);
        echo $row['user_wallet_balance'];
    }
    //payment
    if (isset($_POST['paymentBtn'])) {
        if ($_POST['option'] == 1) {
            $amt = 100;
        } else if ($_POST['option'] == 2) {
            $amt = 500;
        }
        $userID = $_SESSION['userID'];
        $date = date("Y-m-d");
        $insertLog = "INSERT INTO `tbl_logs`(`log_type`, `log_user_id`, `log_created_At`, `log_amount`) 
        VALUES (1,'$userID','$date','$amt')";
        if (mysqli_query($connect, $insertLog)) {
            //fetch cuurent wallet balance of user
            $fetchCur = "SELECT `user_wallet_balance` from tbl_user where user_id='$userID'";
            $fetchCurRes = mysqli_query($connect, $fetchCur);
            $fetchCurRow = mysqli_fetch_array($fetchCurRes);
            $currentBalance = $fetchCurRow['user_wallet_balance'];
            $newBalance = $currentBalance - $amt;
            if ($amt == 100) {
                $updateUserStatus = "UPDATE `tbl_user` SET `acc_type`=2,`user_wallet_balance`='$newBalance' WHERE user_id='$userID'";
                $_SESSION['AccTYPE'] = 2;
            } else {
                $updateUserStatus = "UPDATE `tbl_user` SET `acc_type`=3,`user_wallet_balance`='$newBalance' WHERE user_id='$userID'";
                $_SESSION['AccTYPE'] = 3;
            }
            if (mysqli_query($connect, $updateUserStatus)) {
                header("Location: ./dashboard.php");
                die();
            }
        }
    }
}
