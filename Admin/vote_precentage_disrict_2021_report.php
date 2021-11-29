<?php

require_once '../db/config.php';
require_once('../fpdf/fpdf.php');
class PDF extends FPDF
{

function Footer()
{

    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image('../images/logo.jpg', 10, 10, -500);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Ln(10);
$pdf->Cell(35);
$pdf->SetTextColor(0, 0, 139);
$pdf->SetFillColor(151, 203, 209);
$pdf->Cell(155, 20, 'Presidential Election 2021 Vote Distribution - District', 0, 1, 'C', true);
$pdf->Line(10, 45, 200, 45);
$pdf->Ln(10);
$pdf->Cell(160);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$date = 'Date :' . date("m/d/Y");
$pdf->Cell(10, 05, $date, 0, 1, 'C');
$pdf->Cell(160);
//$time = 'Time :' .date('m/d/Y h:i:s a', strtotime('+3 hours+30minutes'));
$time = 'Time :' .date(' h:i:s a', strtotime('+3 hours+30minutes'));
$pdf->Cell(10, 05, $time, 0, 1, 'C');

$query = "select e_district,no_of_registered_voters,no_of_votes,concat(ROUND(((no_of_votes/no_of_registered_voters)*100),1),'%') AS percentage FROM v_district_pvn GROUP BY `e_district`";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(111, 163, 247);
$pdf->Cell(5);
$pdf->Cell(60, 10, 'District', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Registered Voters', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Vote Count', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Vote Percentage', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(5);
    $pdf->Cell(60, 5, $row["e_district"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["no_of_registered_voters"], 1, 0, 'C');
    $pdf->Cell(30, 5, $row["no_of_votes"], 1, 0, 'C');
     $pdf->Cell(40, 5, $row["percentage"], 1, 1, 'C');
}


$pdf->Output("report.pdf", "I");
