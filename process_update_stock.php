<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch and sanitize input data
$stock_id = intval($_POST['stock_id']);
$quantity = intval($_POST['quantity']);
$operation = $_POST['operation'];
$status = ($operation === 'add') ? 'in' : 'out';

// Check if stock item exists
$stock_query = "SELECT quantity FROM stock WHERE id = ?";
$stmt = $conn->prepare($stock_query);
$stmt->bind_param("i", $stock_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) {
    // Prepare update query
    if ($operation === 'add') {
        $update_query = "UPDATE stock SET quantity = quantity + ?, status = ? WHERE id = ?";
    } elseif ($operation === 'subtract') {
        $update_query = "UPDATE stock SET quantity = quantity - ?, status = ? WHERE id = ?";
    } else {
        die("Invalid operation.");
    }

    // Prepare and execute the stock update statement
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("isi", $quantity, $status, $stock_id);

    if ($stmt->execute()) {
        // Insert into transactions table
        $transaction_query = "INSERT INTO transactions (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status)
                              VALUES (?, NULL, NULL, ?, NOW(), NULL, NULL, ?)";

        $stmt = $conn->prepare($transaction_query);
        $stmt->bind_param("iis", $stock_id, $quantity, $status);

        if ($stmt->execute()) {
            echo "Stock updated and recorded in transactions successfully.";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error inserting into transactions: " . $conn->error;
        }
    } else {
        echo "Error updating stock: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Stock item not found.";
}

// Close the database connection
$conn->close();
?>
