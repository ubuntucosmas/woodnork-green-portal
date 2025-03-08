<?php
require __DIR__ . '/../../../vendor/autoload.php';  // Load PhpSpreadsheet library
include "../includes/db.php"; // Database connection


use PhpOffice\PhpSpreadsheet\IOFactory;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    try {
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Skip the first row if it contains headers
        unset($data[0]);

        // Prepare insert query
        foreach ($data as $row) {
            $item_name = $row[0]; // Assuming first column is 'item_name'
            $category = $row[1]; // Second column is 'category'
            $quantity = $row[2]; // Third column is 'quantity'
            $unit_of_measure = $row[3]; // Fourth column
            $price_per_unit = $row[4]; // Fifth column
            $total_price = $quantity * $price_per_unit; // Calculate total price

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO stock (item_name, category, quantity, unit_of_measure, price_per_unit, total_price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam("ssdsdd", $item_name, $category, $quantity, $unit_of_measure, $price_per_unit, $total_price);
            $stmt->execute();
        }

        echo "Excel data imported successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
