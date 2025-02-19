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

    $stmt = $conn->prepare("INSERT INTO inventory (date, make, model, serial, specs, user, cost, cond) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $date, $make, $model, $serial, $specs, $user, $cost, $condition);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Inventory added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add inventory"]);
    }

    $stmt->close();
    $conn->close();
}
?>
