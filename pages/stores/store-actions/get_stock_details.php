<?php
header("Content-Type: application/json");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Select all stock details including category name
$sql = "SELECT stock.*, category.name AS category_name 
FROM stock 
LEFT JOIN category ON stock.category_id = category.id 
ORDER BY stock.created_at ASC";

$result = $conn->query($sql);

$stocks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stocks[] = $row;
    }
    echo json_encode(["success" => true, "data" => $stocks]);
} else {
    echo json_encode(["success" => false, "message" => "No stock data available"]);
}

$conn->close();
?>
