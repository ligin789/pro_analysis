
<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) != session_id()) {
    header("Location: ../auth/");
    die();
} else {
    if(isset($_POST['makePayment'])){
        $userID = $_SESSION['userID'];

        extract($_POST);
        echo $adsurl;
        echo $adsBannerSize;
        echo $adsinternsity;
        echo $adsRegion;
        echo $totalPriceHidden;
        $errors= array();
        $file_name = $_FILES['adsBanenr']['name'];
        $file_size =$_FILES['adsBanenr']['size'];
        $file_tmp =$_FILES['adsBanenr']['tmp_name'];
        $file_type=$_FILES['adsBanenr']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['adsBanenr']['name'])));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
           $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 2097152){
           $errors[]='File size must be excately 2 MB';
        }
        
        if(empty($errors)==true){
            $date = date("Y-m-d");
           move_uploaded_file($file_tmp,"../assets/adsPoster/".$file_name);
          $insertAds="INSERT INTO `tbl_ads`(`ads_user_id`,`ads_name`, `ads_url`, `ads_banner_size`, `ads_intensity`, `ads_region`, `ads_banner_url`, `ads_expire`, `ads_created_at`) 
          VALUES ('$userID','$adsname','$adsurl','$adsBannerSize','$adsinternsity','$adsRegion','assets/adsPoster/$file_name','$range','$date')";
          if(mysqli_query($connect,$insertAds)){
            echo "<script>
            alert('Insert Successfully');
            window.location.href='../proAds.php';
            </script>";
          }
        }else{
           print_r($errors);
        }
     }
}
