<?php
require_once '../../../includes/db.php'; // Ensure correct database connection

header("Content-Type: application/json");

$response = ["success" => false, "message" => "Something went wrong."];

// Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and validate input
    $stock_id = isset($_POST['stock_id']) ? intval($_POST['stock_id']) : 0;
    $date = isset($_POST['date']) ? trim($_POST['date']) : date("Y-m-d");
    $stock_item = isset($_POST['stock_item']) ? trim($_POST['stock_item']) : '';
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $quantity = isset($_POST['quantity']) ? floatval($_POST['quantity']) : 0;
    $unit_of_measure = isset($_POST['unit_of_measure']) ? trim($_POST['unit_of_measure']) : '';
    $price_per_unit = isset($_POST['price_per_unit']) ? floatval($_POST['price_per_unit']) : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'In';

    // Calculate total price
    $total_price = $quantity * $price_per_unit;

    // Validation checks
    if ($stock_id <= 0 || empty($stock_item) || $category_id <= 0 || $quantity <= 0 || empty($unit_of_measure) || $price_per_unit <= 0) {
        $response["message"] = "Invalid input data. Please check all fields.";
        echo json_encode($response);
        exit;
    }

    // Ensure database connection exists
    if (!isset($conn)) {
        $response["message"] = "Database connection error.";
        echo json_encode($response);
        exit;
    }

    // Prepare update query
    $sql = "UPDATE stock 
            SET date = ?, item_id = ?, category_id = ?, description = ?, 
                quantity = ?, unit_of_measure = ?, price_per_unit = ?, total_price = ?, status = ? 
            WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssisssddsi", $date, $stock_item, $category_id, $description, $quantity, 
                          $unit_of_measure, $price_per_unit, $total_price, $status, $stock_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response["success"] = true;
                $response["message"] = "Stock updated successfully.";
            } else {
                $response["message"] = "No changes made or invalid stock ID.";
            }
        } else {
            $response["message"] = "Failed to update stock. Database error.";
        }

        $stmt->close();
    } else {
        $response["message"] = "Database error: Unable to prepare statement.";
    }

    $conn->close();
} else {
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
?>
