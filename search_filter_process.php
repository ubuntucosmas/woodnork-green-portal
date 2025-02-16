<?php
include 'db_connection.php'; // Ensure this file contains your DB connection

$search_item = isset($_GET['search_item']) ? $_GET['search_item'] : '';
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

$query = "SELECT * FROM transactions WHERE 1";  //WHERE 1 clause acts as a true condition, allowing all rows to pass through the filter.

if (!empty($search_item)) {
    $query .= " AND item_name LIKE '%$search_item%'";
}

if (!empty($filter_type)) {
    $query .= " AND status = '$filter_type'";
}

if (!empty($filter_date)) {
    $query .= " AND DATE(created_at) = '$filter_date'";
}

$result = $conn->query($query);
$stock_data = [];

while ($row = $result->fetch_assoc()) {
    $stock_data[] = $row;
}

echo json_encode($stock_data);
?>
