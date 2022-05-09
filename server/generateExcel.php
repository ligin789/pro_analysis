<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    $userId = $_SESSION['userID'];
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
                $fileName = "Data between " . $fromDate . " and " . $toDate;
            }
        } else {
            header("Location: ../export.php");
            $_SESSION['noExcelData'] = "No data found in this option";
            die();
        }
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $fileName . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo ucwords($columnHeader) . "\n" . $setData . "\n";
    }
    if (isset($_POST['PDFSubmitRegion'])) {
        require "../fpdf.php";
        extract($_POST);
        $pdf = new FPDF();
        $conn = new PDO("mysql:host=localhost;dbname=pro_analysis", "root", "");


        $pdf->AddPage();
        $pdf->Line(10, 15, 200, 15);
        $pdf->Ln(8);
        $pdf->SetFont("Arial", "B", 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 20, "ProAnalysis", 0, 0, "C");
        $pdf->Ln();
        $pdf->SetFont("Arial", "U", 15);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(180, 20, $conti, 0, 0, "C");



        $pdf->Ln(25);
        $pdf->SetLeftMargin(10);
        $pdf->SetFont("Arial", "", 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(20, 10, "Sl.No", "1", "0", "C");
        $pdf->Cell(30, 10, "Website Name", "1", "0", "C");
        $pdf->Cell(30, 10, "IP Address", "1", "0", "C");
        $pdf->Cell(20, 10, "Country", "1", "0", "C");
        $pdf->Cell(30, 10, "Device Type", "1", "0", "C");
        $pdf->Cell(20, 10, "OS Name", "1", "0", "C");
        $pdf->Cell(20, 10, "Browser", "1", "0", "C");
        $pdf->Cell(20, 10, "Date", "1", "0", "C");

        extract($_POST);
        $fetchDetailSql = "SELECT * from tbl_data where data_Contient_name='$conti' and data_status!=0 and data_user_id='$userId'";
        $result = $conn->prepare($fetchDetailSql);
        $result->execute();
        if ($result->rowCount() != 0) {
            $count=1;
            while ($row = $result->fetch()) {
                $data_website_id = $row['data_website_id'];
                $fetchWebsiteSql = "SELECT website_name from tbl_website where website_id='$data_website_id'";
                $fetchWebsiteResult = mysqli_query($connect, $fetchWebsiteSql);
                $fetchWebsiteRow = mysqli_fetch_array($fetchWebsiteResult);
                $website_name = $fetchWebsiteRow['website_name'];
                $pdf->Ln();
                $pdf->SetLeftMargin(10);
                $pdf->SetFont("Arial", "", 10);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(20, 10, $count, "1", "0", "C");
                $pdf->Cell(30, 10, ucwords($website_name), "1", "0", "C");
                $pdf->Cell(30, 10, $row['data_ip'], "1", "0", "C");
                $pdf->Cell(20, 10, ucwords($row['data_country']), "1", "0", "C");
                $pdf->Cell(30, 10, $row['data_device_type'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['os_name'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['data_browser'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['data_created_at'], "1", "0", "C");
                $count++;
            }
        }

        $pdf->Output();
    }

    //date pdf
    if (isset($_POST['PDFSubmitdate'])) {
        $fdate=$_POST['fromDate'];
        $tdate=$_POST['toDate'];
        require "../fpdf.php";
        extract($_POST);
        $pdf = new FPDF();
        $conn = new PDO("mysql:host=localhost;dbname=pro_analysis", "root", "");

        $pdf->AddPage();
        $pdf->Line(10, 15, 200, 15);
        $pdf->Ln(8);
        $pdf->SetFont("Arial", "B", 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 20, "ProAnalysis", 0, 0, "C");
       
        $pdf->Ln(25);
        $pdf->SetLeftMargin(10);
        $pdf->SetFont("Arial", "", 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(20, 10, "Sl.No", "1", "0", "C");
        $pdf->Cell(30, 10, "Website Name", "1", "0", "C");
        $pdf->Cell(30, 10, "IP Address", "1", "0", "C");
        $pdf->Cell(20, 10, "Country", "1", "0", "C");
        $pdf->Cell(30, 10, "Device Type", "1", "0", "C");
        $pdf->Cell(20, 10, "OS Name", "1", "0", "C");
        $pdf->Cell(20, 10, "Browser", "1", "0", "C");
        $pdf->Cell(20, 10, "Date", "1", "0", "C");

        extract($_POST);
        $fetchDetailSql = "SELECT * from tbl_data where (data_created_at BETWEEN '$fdate' and '$tdate') and data_status!=0 and data_user_id='$userId'";
        $result = $conn->prepare($fetchDetailSql);
        $result->execute();
        if ($result->rowCount() != 0) {
            $count=1;
            while ($row = $result->fetch()) {
                $data_website_id = $row['data_website_id'];
                echo $fetchWebsiteSql = "SELECT website_name from tbl_website where website_id='$data_website_id'";
                $fetchWebsiteResult = mysqli_query($connect, $fetchWebsiteSql);
                $fetchWebsiteRow = mysqli_fetch_array($fetchWebsiteResult);
                $website_name = $fetchWebsiteRow['website_name'];
                $pdf->Ln();
                $pdf->SetLeftMargin(10);
                $pdf->SetFont("Arial", "", 10);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(20, 10, $count, "1", "0", "C");
                $pdf->Cell(30, 10, ucwords($website_name), "1", "0", "C");
                $pdf->Cell(30, 10, $row['data_ip'], "1", "0", "C");
                $pdf->Cell(20, 10, ucwords($row['data_country']), "1", "0", "C");
                $pdf->Cell(30, 10, $row['data_device_type'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['os_name'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['data_browser'], "1", "0", "C");
                $pdf->Cell(20, 10, $row['data_created_at'], "1", "0", "C");
                $count++;
            }
        }
        else if($result->rowCount() == 0){
            $pdf->Ln();

            $pdf->SetLeftMargin(10);
                    $pdf->SetFont("Arial", "B", 10);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(190, 10, "no Data Found", "1", "0", "C");
        }

        $pdf->Output();
    }

}
