<?php
// Set response to JSON format
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Check if dispatch_id is provided
if (!isset($_GET['dispatch_id']) || empty($_GET['dispatch_id'])) {
    echo json_encode(["error" => "No dispatch ID provided"]);
    exit();
}

$dispatch_id = $_GET['dispatch_id'];

// SQL Query
$sql = "SELECT id, stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status, dispatch_id 
        FROM dispatches 
        WHERE dispatch_id = ?
        ORDER BY dispatch_date DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit();
}

$stmt->bind_param("s", $dispatch_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON response
if (empty($data)) {
    echo json_encode(["error" => "No records found for Dispatch ID: $dispatch_id"]);
} else {
    echo json_encode(["specific_dispatches" => $data]);
}

exit();
