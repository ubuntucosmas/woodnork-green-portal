<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "portal_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}

// Fetch low stock items (Quantity < 10)
$query = "SELECT name, category_id, description, quantity, unit_of_measure, price_per_unit, (quantity * price_per_unit) AS total_price 
          FROM stock WHERE quantity < 10";
$stmt = $pdo->prepare($query);
$stmt->execute();
$lowStockItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($lowStockItems);
?>
