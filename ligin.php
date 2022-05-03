<?php
session_start();
require "./fpdf.php";
$pdf = new FPDF();
$connect = new PDO("mysql:host=localhost;dbname=pro_analysis", "root", "");


$pdf->AddPage();
$pdf->Line(10, 15, 200, 15);
$pdf->Ln(8);
$pdf->SetFont("Arial", "B", 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 20, "ProAnalysis", 0, 0, "C");
$pdf->Ln();
$pdf->SetFont("Arial", "U", 15);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(180, 20, "Asia", 0, 0, "C");


      
$pdf->Ln(25);
$pdf->SetLeftMargin(10);
$pdf->SetFont("Arial", "", 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(20, 10, "Sl.No", "1", "0", "C");
$pdf->Cell(30, 10, "Website Name", "1", "0", "C");
$pdf->Cell(30, 10, "IP Address", "1", "0", "C");
$pdf->Cell(20, 10, "Country", "1", "0", "C");
$pdf->Cell(30, 10, "Device Type", "1", "0", "C");
$pdf->Cell(20, 10, "OS Name", "1", "0", "C");
$pdf->Cell(20, 10, "Browser", "1", "0", "C");
$pdf->Cell(20, 10, "Date", "1", "0", "C");


$pdf->Ln();
$pdf->SetLeftMargin(10);
$pdf->SetFont("Arial", "", 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(20, 10, "1", "1", "0", "C");
$pdf->Cell(30, 10, "dd", "1", "0", "C");
$pdf->Cell(30, 10, "dg", "1", "0", "C");
$pdf->Cell(20, 10, "sd", "1", "0", "C");
$pdf->Cell(30, 10, "dd", "1", "0", "C");
$pdf->Cell(20, 10, "dg", "1", "0", "C");
$pdf->Cell(20, 10, "sd", "1", "0", "C");
$pdf->Cell(20, 10, "sd", "1", "0", "C");


$pdf->Output();
