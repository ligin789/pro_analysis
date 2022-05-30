<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
   if(isset($_POST['fetchAllDetailsEach']))
   {
       extract($_POST);
       $fetchDetails="SELECT * from `tbl_ads_click` where `click_ads_id`='$ads_id' and click_status!=0";
         $fetchDetailsRes=mysqli_query($connect,$fetchDetails);
         if(mysqli_num_rows($fetchDetailsRes)>0)
         {
               
                $i=1;
                $data="<table id='exampleTable' class='table table-striped table-bordered' style='min-width: 100%'>
                <thead id='thead'>
                    <tr>
                        <th>#</th>
                        <th>Website Name</th>
                        <th>Visited user IP</th>
                        <th>Website created</th>
                        
                    </tr>
                </thead>
                <tbody>";
                while($fetchDetailsRow=mysqli_fetch_array($fetchDetailsRes))
                {
                    $id=$fetchDetailsRow['click_website_id'];
                    $fetchWebsiteName="SELECT website_name from tbl_website where website_id='$id'";
                    $fetchWebsiteNameRes=mysqli_query($connect,$fetchWebsiteName);
                    $fetchWebsiteNameRow=mysqli_fetch_array($fetchWebsiteNameRes);
                    $data.="<tr>";
                    $data.="<td>".$i."</td>";
                    $data.="<td>".$fetchWebsiteNameRow['website_name']."</td>";
                    $data.="<td>".$fetchDetailsRow['click_user_ip']."</td>";
                    $data.="<td>".$fetchDetailsRow['click_updated_at']."</td>";
                    // $data.="<td>".$fetchDetailsRow['click_country']."</td>";
                    // $data.="<td>".$fetchDetailsRow['click_region']."</td>";
                    // $data.="<td>".$fetchDetailsRow['click_device_type']."</td>";
                    $data.="</tr>";
                    $i++;
                }
                $data .= "</tbody></table>
                <script>
                $('#exampleTable').DataTable();
            </script>";
                echo $data;
            }
            else
            {
                echo "No Data Found";
         }
   }
}
