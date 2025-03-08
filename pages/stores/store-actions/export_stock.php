<?php
require __DIR__ . '/../../../vendor/autoload.php';// Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
$sql = "SELECT name, category_id, description, quantity, unit_of_measure, total_price, price_per_unit, status FROM stock";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headers
    $sheet->setCellValue('A1', 'Name');
    $sheet->setCellValue('B1', 'Category');
    $sheet->setCellValue('C1', 'Description');
    $sheet->setCellValue('D1', 'Quantity');
    $sheet->setCellValue('E1', 'Unit of Measure');
    $sheet->setCellValue('F1', 'Total Price');
    $sheet->setCellValue('G1', 'Price Per Unit');
    $sheet->setCellValue('H1', 'Status');

    // Populate data
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['name']);
        $sheet->setCellValue('B' . $row, $data['category_id']);
        $sheet->setCellValue('C' . $row, $data['description']);
        $sheet->setCellValue('D' . $row, $data['quantity']);
        $sheet->setCellValue('E' . $row, $data['unit_of_measure']);
        $sheet->setCellValue('F' . $row, $data['total_price']);
        $sheet->setCellValue('G' . $row, $data['price_per_unit']);
        $sheet->setCellValue('H' . $row, $data['status']);
        $row++;
    }

    // Generate Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = "stock_data_" . date("Y-m-d") . ".xlsx";

    // Send download headers
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit();
} else {
    echo "No stock data available.";
}
?>
