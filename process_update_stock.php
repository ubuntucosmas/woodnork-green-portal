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

// Fetch and sanitize input data
$stock_id = intval($_POST['stock_id']);
$quantity = intval($_POST['quantity']);
$operation = $_POST['operation'];

// Determine the SQL operation
if ($operation === 'add') {
    $update_query = "UPDATE stock SET quantity = quantity + ? WHERE id = ?";
} elseif ($operation === 'subtract') {
    $update_query = "UPDATE stock SET quantity = quantity - ? WHERE id = ?";
} else {
    die("Invalid operation.");
}

// Prepare and execute the statement
$stmt = $conn->prepare($update_query);
$stmt->bind_param("ii", $quantity, $stock_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error updating stock: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
