<?php
// Include database connection
include "../includes/db.php";

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance()->getConnection();

    // Retrieve form data
    $name = $_POST['item_name'];
    $category_id = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $price_per_unit = $_POST['price_per_unit'];
    $total_price = $quantity * $price_per_unit;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    // if (empty($status)) {
    //     die("Error: Status field is missing or empty."); //for debuging
    // }


    // Prepare the SQL statement using PDO
    $sql = "INSERT INTO stock (name, category_id, description, quantity, unit_of_measure, total_price, price_per_unit, status, created_at) 
            VALUES (:name, :category_id, :description, :quantity, :unit_of_measure, :total_price, :price_per_unit, :status, NOW())";
    // print_r($_POST); // Debugging: Check what data is received
    // exit; // Stop execution to view output
    
    $stmt = $db->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':unit_of_measure', $unit_of_measure);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':price_per_unit', $price_per_unit);
    $stmt->bindParam(':status', $status);
    

    // Execute query+
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Stock added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error adding stock"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
