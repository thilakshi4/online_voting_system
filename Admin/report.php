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

$query = "SELECT party_name_short as Political_Party,counts as Votes FROM v_vote_count_all ";
$result = mysqli_query($GLOBALS['conn'], $query);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(219, 218, 213);
$pdf->Cell(30);
$pdf->Cell(80, 10, 'Party Name', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vote Count', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $pdf->Cell(30);
    $pdf->Cell(80, 5, $row["Political_Party"], 1, 0, 'C');
    $pdf->Cell(50, 5, $row["Votes"], 1, 1, 'C');
}
$pdf->Cell(30);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(0, 0, 139);
$pdf->SetFillColor(215, 159, 245);
$pdf->Cell(80, 10, 'Total Vote Count', 1, 0, 'C', true);
$query_sum = "SELECT SUM(counts)AS vote_count FROM v_vote_count_all";
$result_sum = mysqli_query($GLOBALS['conn'], $query_sum);
while ($row = mysqli_fetch_array($result_sum)) {

    $pdf->Cell(50, 10, $row["vote_count"], 1, 1, 'C', true);
    $vote_count = $row["vote_count"];
}
 
$pdf->Ln(15);
$pdf->Cell(15);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(213, 214, 224);
$pdf->Cell(60, 8, 'Number of registered voters - ', 0, 0, 'L', true);
$voter_count = "SELECT COUNT(NIC)vote_count FROM voter_registration";
$result_count = mysqli_query($GLOBALS['conn'], $voter_count);
while ($row = mysqli_fetch_array($result_count)) {

    $pdf->Cell(110, 8, $row["vote_count"], 0, 1, 'L', true);
    $reg_voters = $row["vote_count"];
}
$pdf->SetFillColor(122, 123, 125);
$pdf->Cell(15);
$pdf->Cell(60, 8, 'Total number of votes - ', 0, 0, 'L', true);
$pdf->Cell(110, 8, $vote_count, 0, 1, 'L', true);
$pdf->SetFillColor(213, 214, 224);
$pdf->Cell(15);
$pdf->Cell(60, 8, 'Voting Percentage - ', 0, 0, 'L', true);
$vote_amount = round($vote_count / $reg_voters * 100, 2);
$pdf->Cell(110, 8, $vote_amount . '%', 0, 1, 'L', true);

$pdf->Ln(10);
$query_s = "SELECT url FROM image_url WHERE id=1";
$result_s= mysqli_query($GLOBALS['conn'], $query_s);
while ($row = mysqli_fetch_array($result_s)) {

    $url=  $row["url"];
}
 $pdf->Cell( 60, 40, $pdf->Image($url, $pdf->GetX(), $pdf->GetY(), -150,-100,'PNG'), 0, 1, 'L', false );

$pdf->Output("report.pdf", "I");
