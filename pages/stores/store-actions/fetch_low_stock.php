<?php
// Include database connection
include "../../../includes/db.php";

$db = Database::getInstance()->getConnection();

if (!$db) {
    die(json_encode(["error" => "Database connection not found."]));
}

$response = [
    'total_stock' => 0,
    'low_stock' => 0,
    'low_stock_items' => [],
    'recent_transactions' => 0,
    'transactions' => []
];

// Get total stock count
$totalStockQuery = $db->query("SELECT COUNT(*) AS total FROM stock");
if ($row = $totalStockQuery->fetch(PDO::FETCH_ASSOC)) {
    $response['total_stock'] = $row['total'];
}

// Get low stock count (items with quantity < 10)
$lowStockQuery = $db->query("SELECT COUNT(*) AS low FROM stock WHERE quantity < 10");
if ($row = $lowStockQuery->fetch(PDO::FETCH_ASSOC)) {
    $response['low_stock'] = $row['low'];
}

// Get low stock details (items with quantity < 3)
$lowStockDetailsQuery = $db->query("
    SELECT id, name AS item_name, category_id, description, quantity, unit_of_measure, 
           price_per_unit, total_price, status, created_at 
    FROM stock 
    WHERE quantity < 3
");
$response['low_stock_items'] = $lowStockDetailsQuery->fetchAll(PDO::FETCH_ASSOC);

// Get recent transactions (last 5 entries)
$transactionsQuery = $db->query("
    SELECT id, name AS item_name, category_id, description, quantity, unit_of_measure, 
           total_price, price_per_unit, created_at, status
    FROM stock 
    ORDER BY created_at DESC 
    LIMIT 5
");

while ($row = $transactionsQuery->fetch(PDO::FETCH_ASSOC)) {
    $response['transactions'][] = $row;
}

$response['recent_transactions'] = count($response['transactions']);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
