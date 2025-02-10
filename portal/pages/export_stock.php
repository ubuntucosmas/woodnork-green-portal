<?php
include '../includes/db.php'; // Adjust the path to your DB connection

if (!isset($_GET['type'])) {
    die("Invalid request.");
}

$type = $_GET['type'];

$query = "SELECT * FROM stock"; // Adjust table name if needed
$result = mysqli_query($conn, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

if ($type === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=stock_data.xls");

    echo "ID\tItem Name\tQuantity\tCategory\n";
    foreach ($data as $row) {
        echo "{$row['id']}\t{$row['item_name']}\t{$row['quantity']}\t{$row['category']}\n";
    }
} elseif ($type === 'pdf') {
    require '../vendor/autoload.php'; // Ensure you have mPDF installed via Composer

    $mpdf = new \Mpdf\Mpdf();
    $html = "<h2>Stock Data</h2><table border='1' width='100%'><tr><th>ID</th><th>Item Name</th><th>Quantity</th><th>Category</th></tr>";

    foreach ($data as $row) {
        $html .= "<tr><td>{$row['id']}</td><td>{$row['item_name']}</td><td>{$row['quantity']}</td><td>{$row['category']}</td></tr>";
    }

    $html .= "</table>";
    $mpdf->WriteHTML($html);
    $mpdf->Output("stock_data.pdf", "D"); // Download file
}
?>






























































