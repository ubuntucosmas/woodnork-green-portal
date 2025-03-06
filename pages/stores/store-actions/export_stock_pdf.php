<?php
require 'vendor/autoload.php'; // If using Composer: require 'vendor/autoload.php';

// Database connection
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stock data
$result = $conn->query("SELECT name, category_id, quantity, price_per_unit, total_price FROM stock");

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'WoodNork Green Stock Report', 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(40, 10, 'Category', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Price/Unit', 1);
$pdf->Cell(40, 10, 'Total Price', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['name'], 1);
    $pdf->Cell(40, 10, $row['category_id'], 1);
    $pdf->Cell(30, 10, $row['quantity'], 1);
    $pdf->Cell(40, 10, $row['price_per_unit'], 1);
    $pdf->Cell(40, 10, $row['total_price'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Stock_Report.pdf'); // 'D' forces download

$conn->close();
?>
