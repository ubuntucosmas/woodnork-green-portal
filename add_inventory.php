<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"] ?? ''; // Get the inventory ID
    $date = $_POST["date"] ?? '';
    $make = $_POST["make"] ?? '';
    $model = $_POST["model"] ?? '';
    $serial = $_POST["serial"] ?? '';
    $specs = $_POST["specs"] ?? '';
    $user = $_POST["user"] ?? '';
    $cost = $_POST["cost"] ?? '';
    $condition = $_POST["condition"] ?? '';

    if (empty($date) || empty($make) || empty($model)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }

    if (!empty($id)) {
        // Update existing inventory item
        $stmt = $conn->prepare("UPDATE inventory SET date=?, make=?, model=?, serial=?, specs=?, user=?, cost=?, cond=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $date, $make, $model, $serial, $specs, $user, $cost, $condition, $id);
        $operation = "updated";
    } else {
        // Insert new inventory item
        $stmt = $conn->prepare("INSERT INTO inventory (date, make, model, serial, specs, user, cost, cond) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $date, $make, $model, $serial, $specs, $user, $cost, $condition);
        $operation = "added";
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Inventory item $operation successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save inventory"]);
    }

    $stmt->close();
    $conn->close();
}
?>
