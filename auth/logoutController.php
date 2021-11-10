<?php
session_start();
unset($_SESSION["proAnalysisSession"]);
unset($_SESSION["userName"]);
unset($_SESSION["userID"]);
header("Location: ../index.html");
?>
