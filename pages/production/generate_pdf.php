<?php
require '../includes/db.php';
require('fpdf.php');

$workOrderId = $_GET['id'] ?? '';

$sql = "SELECT * FROM work_orders WHERE work_order_id = '$workOrderId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('Work Order not found.');
}

$order = $result->fetch_assoc();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Company Logo
$pdf->Image('logo.png', 10, 10, 30); 
$pdf->Cell(190, 10, 'Company Name', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 5, 'Company Address | Phone: 123-456-7890', 0, 1, 'C');
$pdf->Ln(10);

// Work Order Details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, "Work Order #{$order['work_order_id']}", 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, "Project Name: {$order['project_name']}", 0, 1);
$pdf->Cell(50, 10, "Assigned To: {$order['assigned_to']}", 0, 1);
$pdf->Cell(50, 10, "Due Date: {$order['due_date']}", 0, 1);
$pdf->Cell(50, 10, "Status: {$order['status']}", 0, 1);

$pdf->Output();
?>
