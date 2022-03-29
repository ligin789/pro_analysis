<?php
function checksubstription($connect)
{
    //basic
    if ($_SESSION['AccTYPE'] == 2) {
        $userID = $_SESSION['userID'];
        $checkpaymentLog = "SELECT * FROM `tbl_logs` WHERE log_user_id='$userID' and log_type='1'ORDER BY log_updated_At DESC LIMIT 1";
        $checkpaymentLogRes = mysqli_query($connect, $checkpaymentLog);
        $checkpaymentLogRow = mysqli_fetch_assoc($checkpaymentLogRes);
        $paymentDate = $checkpaymentLogRow['log_created_At'];
        $today = date("Y-m-d");
        echo $today - $paymentDate;
    }
    //premium
    if ($_SESSION['AccTYPE'] == 3) {
        $userID = $_SESSION['userID'];
        $checkpaymentLog = "SELECT * FROM `tbl_logs` WHERE log_user_id='$userID' and log_type='1'ORDER BY log_updated_At DESC LIMIT 1";
        $checkpaymentLogRes = mysqli_query($connect, $checkpaymentLog);
        $checkpaymentLogRow = mysqli_fetch_assoc($checkpaymentLogRes);
        $paymentDate = $checkpaymentLogRow['log_created_At'];
        $today = date("Y-m-d");
        $remains = 365 - (round((strtotime($today) - strtotime($paymentDate)) / 86400, 0));
        if ($remains <= 31 and $remains > 0) {
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#exampleModal').modal('show');
           });
           console.log('done');
        </script>";
        } else if ($remains < 0) {
            $updateUserSubStatus = "UPDATE `tbl_user` SET `acc_type`=1 WHERE `user_id`='$userID'";
            if (mysqli_query($connect, $updateUserSubStatus)) {
                $_SESSION['AccTYPE'] = 1;
                echo "<script type='text/javascript'>
                      $(document).ready(function(){
                      $('#exampleModal2').modal('show');
                     });
                     console.log('done');
                  </script>";
            }
        }
    }
}
