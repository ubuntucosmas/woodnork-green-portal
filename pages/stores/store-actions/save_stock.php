<?php
// Include database connection
include "../../../includes/db.php";

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance()->getConnection();

    // Retrieve form data safely
    $stock_id = $_POST['stock_id'] ?? null;
    $name = $_POST['stock_item'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $description = $_POST['description'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $unit_of_measure = $_POST['unit_of_measure'] ?? null;
    $price_per_unit = $_POST['price_per_unit'] ?? null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    // Validate required fields
    if (!$name || !$category_id || !$quantity || !$unit_of_measure || !$price_per_unit) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit();
    }

    // Calculate total price
    $total_price = $quantity * $price_per_unit;

    if (!empty($stock_id)) {
        // **UPDATE existing stock**
        $sql = "UPDATE stock SET 
                    name = :name, 
                    category_id = :category_id, 
                    description = :description, 
                    quantity = :quantity, 
                    unit_of_measure = :unit_of_measure, 
                    total_price = :total_price, 
                    price_per_unit = :price_per_unit, 
                    status = :status
                WHERE id = :stock_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':stock_id', $stock_id);
    } else {
        // **INSERT new stock**
        $sql = "INSERT INTO stock (name, category_id, description, quantity, unit_of_measure, total_price, price_per_unit, status, created_at) 
                VALUES (:name, :category_id, :description, :quantity, :unit_of_measure, :total_price, :price_per_unit, :status, NOW())";

        $stmt = $db->prepare($sql);
    }

    // Bind common parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':unit_of_measure', $unit_of_measure);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':price_per_unit', $price_per_unit);
    $stmt->bindParam(':status', $status);

    // Execute query
    if ($stmt->execute()) {
        $message = !empty($stock_id) ? "Stock updated successfully" : "Stock added successfully";
    
        // Send JSON response (no redirect)
        echo json_encode(["success" => true, "message" => $message]);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save stock data."]);
        exit();
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
