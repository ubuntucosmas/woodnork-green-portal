<?php
header("Content-Type: application/json"); // Return JSON response

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Get form data
$id = isset($_POST['inventory_id']) ? intval($_POST['inventory_id']) : 0;
$date = isset($_POST['date']) ? $_POST['date'] : "";
$make = isset($_POST['make']) ? $_POST['make'] : "";
$model = isset($_POST['model']) ? $_POST['model'] : "";
$serial = isset($_POST['serial']) ? $_POST['serial'] : "";
$specs = isset($_POST['specs']) ? $_POST['specs'] : "";
$user = isset($_POST['user']) ? $_POST['user'] : "";
$cost = isset($_POST['cost']) ? $_POST['cost'] : "";
$condition = isset($_POST['condition']) ? $_POST['condition'] : "";

// Validate ID
if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid inventory ID."]);
    exit();
}

// Update the inventory record
$sql = "UPDATE inventory SET date=?, make=?, model=?, serial=?, specs=?, user=?, cost=?, cond=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $date, $make, $model, $serial, $specs, $user, $cost, $condition, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Inventory updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update inventory."]);
}

$stmt->close();
$conn->close();
?>
