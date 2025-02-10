<?php
include '../includes/db.php';

$item_id = $_POST['stock_id'] ?? '';
$item_name = $_POST['item_name'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$category = $_POST['category'] ?? '';

if (!empty($item_id)) {
    // Update existing stock item
    $query = $conn->prepare("UPDATE stock SET item_name=?, quantity=?, category=? WHERE id=?");
    $query->bind_param("sisi", $item_name, $quantity, $category, $item_id);
    $message = "Stock updated successfully!";
} else {
    // Insert new stock item
    $query = $conn->prepare("INSERT INTO stock (item_name, quantity, category) VALUES (?, ?, ?)");
    $query->bind_param("sis", $item_name, $quantity, $category);
    $message = "Stock added successfully!";
}

if ($query->execute()) {
    echo json_encode(["message" => $message]);
} else {
    echo json_encode(["message" => "Error saving stock."]);
}
?>
