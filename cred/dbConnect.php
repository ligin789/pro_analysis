<?php
// Add mySQL math

// $path = str_replace('www', '', getcwd());
// system('"'.$path'mysql\bin\mysqld.exe"');

$username = "root";
$servername = "localhost";
$password = "";
$db = "pro_analysis";
global $connect;
$connect = mysqli_connect($servername, $username, $password, $db);
// $username = "id17921288_root";
// $servername = "localhost";
// $password = "Puthiyedathu@123";
// $db = "id17921288_proanalysis";
// $connect = mysqli_connect($servername, $username, $password, $db);

?>