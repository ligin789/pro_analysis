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
       $res="SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0 and `data_created_at`='$date'";
       $res2="SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0";
       $sqlRes=mysqli_query($connect,$res);
       $sqlRes2=mysqli_query($connect,$res2);
        $count=mysqli_num_rows($sqlRes);
        $count2=mysqli_num_rows($sqlRes2);
        $data = array("count" => $count, "count2" => $count2);
        echo json_encode($data);
        
    }
    //check count of website
    if (isset($_POST['fetchCountOfWebsite'])) {
       $userID = $_SESSION['userID'];
       $res="SELECT * from tbl_website where `user_id`='$userID' and `website_status`!=0";
       $sqlRes=mysqli_query($connect,$res);
       echo $count=mysqli_num_rows($sqlRes);
    }
    //fetch chart data
    if(isset($_POST['chartFetch'])){
        $userID = $_SESSION['userID'];
        $date = date("Y-m-d");
        $fetcharray="SELECT data_Contient_name from tbl_data where data_user_id='$userID' and data_status!=0";
        $sqlRes=mysqli_query($connect,$fetcharray);
        $fetcharrayRow=mysqli_fetch_array($sqlRes);
        $itemArray=array();
        // for($i=0;$i<mysqli_num_rows($sqlRes);$i++){
        //     $item=$fetcharrayRow[$i];
        //     $count=0;
        //     for($j=0;$j<mysqli_num_rows($sqlRes);$j++)
        //     {
        //         if($j!=$i)
        //         {
        //             if($item==$fetcharrayRow[$j]){
        //                 $count++;
        //             }
        //         }
        //     }
        //     $itemArray=array_push($item);
        // }
        echo json_encode($fetcharrayRow['data_Contient_name']);
    }
    //fetch all details
    if(isset($_POST['fetchAllDetails'])){
        $userID = $_SESSION['userID'];
        $res="SELECT * from tbl_data where `data_user_id`='$userID' and `data_status`!=0 ORDER BY data_updated_at DESC";
        $sqlRes=mysqli_query($connect,$res);
        $data="<table id='exampleTable' class='uk-table uk-table-hover uk-table-striped' style='width:98%'>
        <thead id='thead'>
            <tr>
                <th>Id</th>
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
        if(mysqli_num_rows($sqlRes)>0){
            $count=0;
            while($row=mysqli_fetch_assoc($sqlRes)){
                //fetch website name
                $websiteID=$row['data_website_id'];
                $resWebsite="SELECT website_name from tbl_website where `website_id`='$websiteID'";
                $resWebsite=mysqli_query($connect,$resWebsite);
                $rowWebsite=mysqli_fetch_assoc($resWebsite);
                $websiteName=$rowWebsite['website_name'];
                $data.='<tr>
                            <td>'.++$count.'</td>
                            <td>'.ucwords($websiteName).'</td>
                            <td>'.$row['data_ip'].'</td>
                            <td>'.$row['data_country'].'</td>
                            <td>'.$row['data_region'].'</td>
                            <td>'.$row['data_device_type'].'</td>
                            <td>'.$row['os_name'].'</td>
                            <td>'.$row['data_browser'].'</td>
                            <td>'.$row['data_created_at'].'</td>
                            </tr>';
            }
            $data.="</tbody></table>
            <script>
            $('#exampleTable').DataTable();
        </script>";
        }
        echo $data;
    }
   
}