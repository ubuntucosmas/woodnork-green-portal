<?php
include '../includes/db.php';

$query = $conn->query("SELECT * FROM stock ORDER BY id DESC");
$stockData = [];

while ($row = $query->fetch_assoc()) {
    $stockData[] = $row;
}

echo json_encode($stockData);
?>
