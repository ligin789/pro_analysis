<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    //load registered website on load
    if (isset($_POST['regionSelect'])) {
        $userID = $_SESSION['userID'];
        extract($_POST);
        $selectData = "SELECT * from tbl_data where data_Contient_name='$regionSelect' and data_user_id='$userID' and data_status!=0";
        $selectDataResult = mysqli_query($connect, $selectData);
        $data = "<table id='exampleTable' class='uk-table uk-table-hover uk-table-striped' style='width:98%'>
        <thead id='thead'>
            <tr>
                <th>#</th>
                <th>Website Name</th>
                <th>Ip Address Of User</th>
                <th>Country</th>
                <th>Region</th>
                <th>Device Type</th>
                <th>Os Name</th>
                <th>Browser</th>
                <th>Date </th>
            </tr>
        </thead>
        <tbody>";
        $count=0;
        while ($row = mysqli_fetch_array($selectDataResult)) {
            $data_website_id=$row['data_website_id'];
            $fetchWebsiteSql="SELECT website_name from tbl_website where website_id='$data_website_id'";
            $fetchWebsiteResult=mysqli_query($connect,$fetchWebsiteSql);
            $fetchWebsiteRow=mysqli_fetch_array($fetchWebsiteResult);
            $website_name=$fetchWebsiteRow['website_name'];
            $data .= '<tr>
            <td>' . ++$count . '</td>
            <td>' . ucwords($website_name) . '</td>
            <td>' . substr($row['data_ip'], 0, 17) . '</td>
            <td>' . $row['data_country'] . '</td>
            <td>' . $row['data_region'] . '</td>
            <td>' . $row['data_device_type'] . '</td>
            <td>' . $row['os_name'] . '</td>
            <td>' . $row['data_browser'] . '</td>
            <td>' . $row['data_created_at'] . '</td>
            </tr>';
            
        }
        $data .= "</tbody></table>
            <script>
            $('#exampleTable').DataTable();
            </script>";
        echo $data;
    }
}
