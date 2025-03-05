<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

// Database Connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excelFile"])) {
        $fileTmpPath = $_FILES["excelFile"]["tmp_name"];

        // Load the Excel file
        $spreadsheet = IOFactory::load($fileTmpPath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Skip header row and insert into the database
        for ($i = 1; $i < count($data); $i++) {
            $date = $data[$i][0];
            $make = $data[$i][1];
            $model = $data[$i][2];
            $serial = $data[$i][3];
            $specs = $data[$i][4];
            $user = $data[$i][5];
            $cost = $data[$i][6];
            $condition = $data[$i][7];

            $stmt = $pdo->prepare("INSERT INTO inventory (date, make, model, serial, specs, user, cost, cond) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$date, $make, $model, $serial, $specs, $user, $cost, $condition]);
        }

        echo "Stock data imported successfully!";
    } else {
        echo "No file uploaded.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
