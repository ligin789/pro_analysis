<?php
session_start();
unset($_SESSION["proAnalysisSession"]);
unset($_SESSION["userName"]);
unset($_SESSION["userID"]);
unset($_SESSION['AccTYPE']);
header("Location: ../index.html");
?>
