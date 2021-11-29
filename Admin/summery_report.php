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

$pdf->SetFont('Arial', 'B', 20);
$pdf->Ln(10);
$pdf->Cell(35);
$pdf->SetTextColor(0, 0, 139);
$pdf->SetFillColor(151, 203, 209);
$pdf->Cell(155, 20, 'Presidential Election 2021 Vote Distribution', 0, 1, 'C', true);
$pdf->Line(10, 45, 200, 45);
$pdf->Ln(10);
$pdf->Cell(160);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$date = 'Date :' . date("m/d/Y");
$pdf->Cell(10, 05, $date, 0, 1, 'C');


$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Southern Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='southern' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Western Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Western' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Central Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Central' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Eastern Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Eastern' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - North Central Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='North Central' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - North Western Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='North Western' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Northern Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Northern' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Sabaragamuwa Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Sabaragamuwa' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}

$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(217, 246, 252);
$pdf->Cell(10);
$pdf->Cell(170, 200, '', 1, 0, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 207);
$pdf->Cell(20);
$pdf->Cell(150, 10, 'Vote Distribution - Uva Province', 1, 1, 'C', true);

$query ="SELECT `party_name_short`,COUNT(`party_name_short`) AS Votes FROM `vote_details_party` WHERE `province`='Uva' GROUP BY `party_name_short`  ORDER BY party_name_short ASC";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(131, 247, 154);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["party_name_short"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}


$pdf->Output("report.pdf", "I");
