<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "portal_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dispatch_id = $_POST['dispatch_id'] ?? uniqid();
    $project_name = $_POST['project_name'] ?? 'N/A';
    $destination = $_POST['destination'] ?? 'N/A';
    $dispatcher = $_POST['dispatcher'] ?? 'N/A';
    $receiver = $_POST['receiver'] ?? 'N/A';

    // Validate and process items and quantities
    $items = $_POST['items'] ?? [];
    $quantities = $_POST['quantities'] ?? [];

    if (!is_array($items) || !is_array($quantities) || count($items) !== count($quantities)) {
        die("Invalid item or quantity data.");
    }

    try {
        $pdo->beginTransaction(); // Start transaction

        // Prepare statements
        $updateStockStmt = $pdo->prepare("UPDATE stock SET quantity = quantity - ? WHERE id = ? AND quantity >= ?");
        $insertDispatchStmt = $pdo->prepare("INSERT INTO dispatches (dispatch_id, stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status) 
                                             VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, 'Out')");

        foreach ($items as $index => $stock_id) {
            $quantity = (int)$quantities[$index];

            // Check stock availability
            $checkStockStmt = $pdo->prepare("SELECT quantity FROM stock WHERE id = ?");
            $checkStockStmt->execute([$stock_id]);
            $stockData = $checkStockStmt->fetch(PDO::FETCH_ASSOC);

            if (!$stockData || $stockData['quantity'] < $quantity) {
                throw new Exception("Insufficient stock for item ID: $stock_id");
            }

            // Reduce stock quantity
            $updateStockStmt->execute([$quantity, $stock_id, $quantity]);

            // Insert into dispatches table
            $insertDispatchStmt->execute([$dispatch_id, $stock_id, $project_name, $destination, $quantity, $receiver, $dispatcher]);
        }

        $pdo->commit(); // Commit transaction

        // Convert arrays to JSON for passing via URL
        $items_json = json_encode($items);
        $quantities_json = json_encode($quantities);

        // Redirect to receipt generation
        header("Location: generate_receipt.php?dispatch_id=$dispatch_id&project_name=" . urlencode($project_name) .
            "&destination=" . urlencode($destination) . "&dispatcher=" . urlencode($dispatcher) .
            "&receiver=" . urlencode($receiver) . "&items=" . urlencode($items_json) .
            "&quantities=" . urlencode($quantities_json));
        exit();
    } catch (Exception $e) {
        $pdo->rollBack(); // Rollback transaction on error
        die("Error processing dispatch: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>
