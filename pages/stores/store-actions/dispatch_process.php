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
$project = $conn->real_escape_string($_POST['project']);
$destination = $conn->real_escape_string($_POST['destination']);
$quantity = intval($_POST['quantity']);
$dispatch_date = $conn->real_escape_string($_POST['dispatch_date']);
$receiver = $conn->real_escape_string($_POST['receiver']);
$dispatcher = $conn->real_escape_string($_POST['dispatcher']);
$status = $conn->real_escape_string($_POST['status']);

// Check if the stock item exists and fetch current quantity
$stock_query = "SELECT quantity FROM stock WHERE id = $stock_id";
$stock_result = $conn->query($stock_query);

if ($stock_result->num_rows > 0) {
    $stock = $stock_result->fetch_assoc();
    $current_quantity = $stock['quantity'];

    if ($current_quantity >= $quantity) {
        // Deduct the dispatched quantity from the stock
        $new_quantity = $current_quantity - $quantity;
        $update_query = "UPDATE stock SET quantity = $new_quantity WHERE id = $stock_id";

        if ($conn->query($update_query) === TRUE) {
            // Insert into dispatches table
            $dispatch_query = "INSERT INTO dispatches (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status)
                               VALUES ($stock_id, '$project', '$destination', $quantity, '$dispatch_date', '$receiver', '$dispatcher', '$status')";

            if ($conn->query($dispatch_query) === TRUE) {
                // Insert into transactions table
                $transaction_query = "INSERT INTO transactions (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status)
                                      VALUES ($stock_id, '$project', '$destination', $quantity, '$dispatch_date', '$receiver', '$dispatcher', '$status')";

                if ($conn->query($transaction_query) === TRUE) {
                    echo "Stock dispatched successfully and recorded in transactions.";
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Error inserting into transactions: " . $conn->error;
                }
            } else {
                echo "Error inserting into dispatches: " . $conn->error;
            }
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    } else {
        echo "Insufficient stock quantity.";
    }
} else {
    echo "Stock item not found.";
}

// Close the database connection
$conn->close();
?>
