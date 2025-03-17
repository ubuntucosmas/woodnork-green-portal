<?php
header("Content-Type: application/json"); // ✅ Set JSON response header

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Set UTF-8 encoding for proper character handling
$conn->set_charset("utf8");

// Fetch inventory data
$query = "SELECT id, date, make, model, serial, specs, user, cost, cond FROM inventory ORDER BY date DESC";
$result = $conn->query($query);

// Check if the query was successful5
if (!$result) {
    echo json_encode(["success" => false, "message" => "Error fetching inventory: " . $conn->error]);
    exit();
}

// ✅ Convert result to an array
$inventory = [];

while ($row = $result->fetch_assoc()) {
    $inventory[] = $row;
}

// ✅ Return JSON response
echo json_encode(["success" => true, "data" => $inventory], JSON_UNESCAPED_UNICODE);

// ✅ Close database connection
$conn->close();
?>
