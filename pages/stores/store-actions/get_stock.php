<?php
// Include database connection
// include "../includes/db.php";

// // Get database instance
// $db = Database::getInstance()->getConnection();

// // Fetch stock items using a JOIN to get category names
// $sql = "SELECT s.id, s.created_at, s.name, c.name AS category, s.description, 
//                s.unit_of_measure, s.quantity, s.price_per_unit, s.total_price, s.status
//         FROM stock s
//         JOIN category c ON s.category_id = c.id
//         ORDER BY s.created_at DESC";

// $stmt = $db->prepare($sql);
// $stmt->execute();
// $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Return data as JSON
// header('Content-Type: application/json');
// echo json_encode($stocks);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available stock items
$stock_query = "SELECT id, name FROM stock WHERE quantity > 0";
$stock_result = $conn->query($stock_query);

$items = [];

if ($stock_result->num_rows > 0) {
    while ($row = $stock_result->fetch_assoc()) {
        $items[] = $row;  // Store stock items in an array
    }
}

// Set response header to JSON
header('Content-Type: application/json');
echo json_encode($items); // Convert to JSON
?>