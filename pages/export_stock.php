<?php

require 'libs/fpdf.php'; // Required for PDF generation

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$conn = new mysqli("localhost", "root", "", "portal_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type == 'excel') {
    exportToExcel($conn);
} elseif ($type == 'pdf') {
    exportToPDF($conn);
} else {
    die("Invalid export type.");
}

// ✅ Function to export stock data to an Excel file
function exportToExcel($conn) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Item Name');
    $sheet->setCellValue('C1', 'Quantity');
    $sheet->setCellValue('D1', 'Category');
    $sheet->setCellValue('E1', 'Created At');

    // Fetch stock data
    $sql = "SELECT id, name, quantity, category_id, created_at FROM stock ORDER BY created_at ASC";
    $result = $conn->query($sql);

    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['name']);
        $sheet->setCellValue('C' . $row, $data['quantity']);
        $sheet->setCellValue('D' . $row, $data['category_id']);
        $sheet->setCellValue('E' . $row, $data['created_at']);
        $row++;
    }

    // Set header to download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="stock_data.xlsx"');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// ✅ Function to export stock data to a PDF file
function exportToPDF($conn) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Stock Data', 1, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Item Name', 1);
    $pdf->Cell(30, 10, 'Quantity', 1);
    $pdf->Cell(30, 10, 'Category', 1);
    $pdf->Cell(50, 10, 'Created At', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);

    $sql = "SELECT id, name, quantity, category_id, created_at FROM stock ORDER BY created_at ASC";
    $result = $conn->query($sql);

    while ($data = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $data['id'], 1);
        $pdf->Cell(50, 10, $data['name'], 1);
        $pdf->Cell(30, 10, $data['quantity'], 1);
        $pdf->Cell(30, 10, $data['category_id'], 1);
        $pdf->Cell(50, 10, $data['created_at'], 1);
        $pdf->Ln();
    }

    // Output the PDF for download
    $pdf->Output('D', 'stock_data.pdf');
    exit;
}
?>
