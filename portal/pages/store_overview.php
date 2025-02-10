<?php
include '../includes/db.php'; // Adjust based on your structure

$response = [
    'total_stock' => 0,
    'low_stock' => 0,
    'recent_transactions' => 0,
    'transactions' => []
];

// Get total stock items
$totalStockQuery = $conn->query("SELECT COUNT(*) AS total FROM stock");
if ($row = $totalStockQuery->fetch_assoc()) {
    $response['total_stock'] = $row['total'];
}

// Get low stock alerts
$lowStockQuery = $conn->query("SELECT COUNT(*) AS low FROM stock WHERE quantity < 10");
if ($row = $lowStockQuery->fetch_assoc()) {
    $response['low_stock'] = $row['low'];
}

// Get recent transactions (last 5 entries)
$transactionsQuery = $conn->query("SELECT t.item_name, t.quantity, t.type, t.date 
                                   FROM transactions t 
                                   ORDER BY t.date DESC 
                                   LIMIT 5");
while ($row = $transactionsQuery->fetch_assoc()) {
    $response['transactions'][] = $row;
}

// Count recent transactions
$response['recent_transactions'] = count($response['transactions']);

echo json_encode($response);
?>
