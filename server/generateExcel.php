<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    //region based prediction
    if(isset($_POST['excelSubmitRegion']))
    {
        extract($_POST);
        $fetchDetailSql="SELECT * from tbl_data";
    }
}
