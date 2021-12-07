<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    //load registered website on load
    if (isset($_POST['fetchCountOfUser'])) {
        $userID = $_SESSION['userID'];
        $date = date("Y-m-d");
        $res = "SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0 and `data_created_at`='$date'";
        $res2 = "SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0";
        $sqlRes = mysqli_query($connect, $res);
        $sqlRes2 = mysqli_query($connect, $res2);
        $count = mysqli_num_rows($sqlRes);
        $count2 = mysqli_num_rows($sqlRes2);
        $data = array("count" => $count, "count2" => $count2);
        echo json_encode($data);
    }
    //check count of website
    if (isset($_POST['fetchCountOfWebsite'])) {
        $userID = $_SESSION['userID'];
        $res = "SELECT * from tbl_website where `user_id`='$userID' and `website_status`!=0";
        $sqlRes = mysqli_query($connect, $res);
        echo $count = mysqli_num_rows($sqlRes);
    }
    //fetch chart data
    if (isset($_POST['chartFetch'])) {
        $userID = $_SESSION['userID'];
        $date = date("Y-m-d");
        $fetcharray = "SELECT DISTINCT data_Contient_name from tbl_data where data_user_id='$userID' and data_status!=0";
        $sqlRes = mysqli_query($connect, $fetcharray);
        $fetcharrayRowCount = mysqli_num_rows($sqlRes);
        $data = array();
        while($fetcharrayRow = mysqli_fetch_array($sqlRes))
        {
            $value=$fetcharrayRow['data_Contient_name'];
            $fetchIndContinent="SELECT * from tbl_data where data_user_id='$userID' and data_status!=0 and data_Contient_name='$value'";
            $fetchIndContinentRes=mysqli_query($connect,$fetchIndContinent);
            $CountConti=mysqli_num_rows($fetchIndContinentRes);
            $tempArray= array($value => $CountConti);
            array_push($data,$tempArray);
        }
        echo json_encode($fetcharrayRow);
    }
    //fetch all details
    if (isset($_POST['fetchAllDetails'])) {
        $userID = $_SESSION['userID'];
        $res = "SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0 ORDER BY data_updated_at DESC";
        $sqlRes = mysqli_query($connect, $res);
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
        if (mysqli_num_rows($sqlRes) > 0) {
            $count = 0;
            while ($row = mysqli_fetch_assoc($sqlRes)) {
                //fetch website name
                $websiteID = $row['data_website_id'];
                $resWebsite = "SELECT website_name from tbl_website where `website_id`='$websiteID'";
                $resWebsite = mysqli_query($connect, $resWebsite);
                $rowWebsite = mysqli_fetch_assoc($resWebsite);
                $websiteName = $rowWebsite['website_name'];
                $data .= '<tr>
                            <td>' . ++$count . '</td>
                            <td>' . ucwords($websiteName) . '</td>
                            <td>' . $row['data_ip'] . '</td>
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
        }
        echo $data;
    }
    if (isset($_POST['fetchAllDetailsEach']) and isset($_POST['websiteId'])) {
        $userID = $_SESSION['userID'];
        extract($_POST);
        $res = "SELECT * from tbl_data where `data_user_id`='$userID' and `data_website_id`='$websiteId' and `data_status`!=0 ORDER BY data_updated_at DESC";
        $sqlRes = mysqli_query($connect, $res);
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
        if (mysqli_num_rows($sqlRes) > 0) {
            $count = 0;
            while ($row = mysqli_fetch_assoc($sqlRes)) {
                //fetch website name
                $websiteID = $row['data_website_id'];
                $resWebsite = "SELECT website_name from tbl_website where `website_id`='$websiteID'";
                $resWebsite = mysqli_query($connect, $resWebsite);
                $rowWebsite = mysqli_fetch_assoc($resWebsite);
                $websiteName = $rowWebsite['website_name'];
                $data .= '<tr onclick="fetchEachDataInModal(' . $row['data_id'] . ')" title="Click to view Details">
                            <td>' . ++$count . '</td>
                            <td>' . ucwords($websiteName) . '</td>
                            <td>' . $row['data_ip'] . '</td>
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
        }
        echo $data;
    }
    if (isset($_POST['heatMapDatas'])) {
        $userID = $_SESSION['userID'];
        $res = "SELECT `data_latitude`,`data_longitude` from tbl_data where `data_user_id`='$userID' and `data_status`!=0";
        $sqlRes = mysqli_query($connect, $res);
        $i = 0;
        $latitude = array();
        $longitude = array();
        while ($row = mysqli_fetch_array($sqlRes)) {
            $latitude[$i] = $row['data_latitude'];
            $longitude[$i] = $row['data_longitude'];
            $i++;
        }
        $data = array("lati" => $latitude, "longi" => $longitude);
        echo json_encode($data);
    }
    //fetch data to modal
    if (isset($_POST['fetchDataModal']) and isset($_POST['dataID'])) {
        extract($_POST);
        $fetchDataSql = "SELECT * from tbl_data where `data_id`='$dataID' and data_status!=0";
        $fetchDataSqlRes = mysqli_query($connect, $fetchDataSql);
        $fetchDataSqlRow = mysqli_fetch_array($fetchDataSqlRes);
        $_SESSION['latitude'] = $fetchDataSqlRow['data_latitude'];
        $_SESSION['longitude'] = $fetchDataSqlRow['data_longitude'];
        echo json_encode($fetchDataSqlRow);
    }
}
