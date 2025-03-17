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

// Ensure it's a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $stock_id = $_GET['id'] ?? null;

    if (!$stock_id) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid stock ID"]);
        exit;
    }

    // Prepare and execute the delete query
    $query = "DELETE FROM stock WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "SQL error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $stock_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Stock deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to delete stock"]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
