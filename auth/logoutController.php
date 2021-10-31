<?php
session_start();
unset($_SESSION["proAnalysisSession"]);
header("Location: ../index.html");
?>
