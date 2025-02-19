<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_POST['date'] ?? '';
$make = $_POST['make'] ?? '';
$model = $_POST['model'] ?? '';
$serial = $_POST['serial'] ?? '';
$specs = $_POST['specs'] ?? '';
$user = $_POST['user'] ?? '';
$cost = $_POST['cost'] ?? '';
$condition = $_POST['condition'] ?? '';

if (empty($date) || empty($make) || empty($model) || empty($serial)) {
    die(json_encode(["success" => false, "message" => "Missing required fields"]));
}

$stmt = $conn->prepare("INSERT INTO inventory (date, make, model, serial, specs, user, cost, `cond`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssis", $date, $make, $model, $serial, $specs, $user, $cost, $condition);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Database insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
