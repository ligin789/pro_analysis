<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    $userId=$_SESSION['userID'];
    //region based prediction
    if (isset($_POST['excelSubmitRegion'])) {
        extract($_POST);
        $fetchDetailSql = "SELECT * from tbl_data where data_Contient_name='$conti' and data_status!=0 and data_user_id='$userId'";
        $fetchDetailResult = mysqli_query($connect, $fetchDetailSql);
        //check count >0
        if (mysqli_num_rows($fetchDetailResult) > 0) {
            $setData = '';
            $columnHeader = '';
            $columnHeader = "Website Name" . "\t" . "Ip address" . "\t" . "Country" . "\t" . "Device Type" . "\t" . "Os Name" . "\t" . "Browser" . "\t" . "Date" . "\t";
            //fetch all datas which satify the condition
            while ($fetchDateRow = mysqli_fetch_assoc($fetchDetailResult)) {
                $data_website_id = $fetchDateRow['data_website_id'];
                $fetchWebsiteSql = "SELECT website_name from tbl_website where website_id='$data_website_id'";
                $fetchWebsiteResult = mysqli_query($connect, $fetchWebsiteSql);
                $fetchWebsiteRow = mysqli_fetch_array($fetchWebsiteResult);
                $website_name = $fetchWebsiteRow['website_name'];
                //excel generation start
                $columnDataFinal = '';
                $columnData = '"' . ucwords($website_name)  . '"' . "\t" . '"' . $fetchDateRow['data_ip'] . '"' . "\t" . '"' . $fetchDateRow['data_country'] . '"' . "\t" . '"' . $fetchDateRow['data_device_type'] . '"' . "\t" . '"' . $fetchDateRow['os_name'] . '"' . "\t" . '"' . $fetchDateRow['data_browser'] . '"' . "\t" . '"' . $fetchDateRow['data_created_at'] . '"' . "\t";
                $columnDataFinal .= $columnData;
                $setData .= trim($columnDataFinal) . "\n";
            }
        } else {
            header("Location: ../export.php");
            die();
        }
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $conti . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo ucwords($columnHeader) . "\n" . $setData . "\n";
    }
    //date based prediction
    if (isset($_POST['excelSubmitdate'])) {
        extract($_POST);
        echo $fetchDetailSql = "SELECT * from tbl_data where (data_created_at BETWEEN '$fromDate' and '$toDate') and data_status!=0 and data_user_id='$userId'";
        $fetchDetailResult = mysqli_query($connect, $fetchDetailSql);
        //check count >0
        if (mysqli_num_rows($fetchDetailResult) > 0) {
            $setData = '';
            $columnHeader = '';
            $columnHeader = "Website Name" . "\t" . "Ip address" . "\t" . "Country" . "\t" . "Device Type" . "\t" . "Os Name" . "\t" . "Browser" . "\t" . "Date" . "\t";
            //fetch all datas which satify the condition
            while ($fetchDateRow = mysqli_fetch_assoc($fetchDetailResult)) {
                $data_website_id = $fetchDateRow['data_website_id'];
                echo $fetchWebsiteSql = "SELECT website_name from tbl_website where website_id='$data_website_id' ";
                $fetchWebsiteResult = mysqli_query($connect, $fetchWebsiteSql);
                $fetchWebsiteRow = mysqli_fetch_array($fetchWebsiteResult);
                $website_name = $fetchWebsiteRow['website_name'];
                //excel generation start
                $columnDataFinal = '';
                $columnData = '"' . ucwords($website_name)  . '"' . "\t" . '"' . $fetchDateRow['data_ip'] . '"' . "\t" . '"' . $fetchDateRow['data_country'] . '"' . "\t" . '"' . $fetchDateRow['data_device_type'] . '"' . "\t" . '"' . $fetchDateRow['os_name'] . '"' . "\t" . '"' . $fetchDateRow['data_browser'] . '"' . "\t" . '"' . $fetchDateRow['data_created_at'] . '"' . "\t";
                $columnDataFinal .= $columnData;
                $setData .= trim($columnDataFinal) . "\n";
                $fileName="Data between ".$fromDate." and ".$toDate;
            }
        } else {
            header("Location: ../export.php");
            $_SESSION['noExcelData']="No data found in this option";
            die();
        }
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $fileName . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo ucwords($columnHeader) . "\n" . $setData . "\n";
    }
}
