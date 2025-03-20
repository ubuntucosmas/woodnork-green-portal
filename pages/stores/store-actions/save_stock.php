<?php
include "../../../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance()->getConnection();

    $stock_id = $_POST['stock_id'] ?? null;
    $name = $_POST['stock_item'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $description = $_POST['description'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $unit_of_measure = $_POST['unit_of_measure'] ?? null;
    $price_per_unit = $_POST['price_per_unit'] ?? null;
    $status = $_POST['status'] ?? 'active';

    if (!$name || !$category_id || !$quantity || !$unit_of_measure || !$price_per_unit) {
        http_response_code(400);
        exit("Missing required fields");
    }

    $total_price = $quantity * $price_per_unit;

    try {
        if (!empty($stock_id)) {
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
            $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO stock (name, category_id, description, quantity, unit_of_measure, total_price, price_per_unit, status, created_at) 
                    VALUES (:name, :category_id, :description, :quantity, :unit_of_measure, :total_price, :price_per_unit, :status, NOW())";

            $stmt = $db->prepare($sql);
        }

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_of_measure', $unit_of_measure);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':price_per_unit', $price_per_unit);
        $stmt->bindParam(':status', $status);

        $stmt->execute();
        
        http_response_code(200);
        exit("Success"); // ✅ Return something so JS knows it worked
    } catch (PDOException $e) {
        http_response_code(500);
        exit("Database error");
    }
}
?>
