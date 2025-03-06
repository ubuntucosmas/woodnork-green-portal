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
// Fetch inventory data
$query = "SELECT id, date, make, model, serial, specs, user, cost, cond FROM inventory ORDER BY date DESC";
$result = $conn->query($query);

$inventory = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $inventory[] = $row;
    }
}

echo json_encode(["success" => true, "data" => $inventory]);

$conn->close();
?>