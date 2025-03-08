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
// $stock_id = intval($_POST['stock_id']);
// $project = $conn->real_escape_string($_POST['project']);
// $destination = $conn->real_escape_string($_POST['destination']);
// $quantity = intval($_POST['quantity']);
// $dispatch_date = $conn->real_escape_string($_POST['dispatch_date']);
// $receiver = $conn->real_escape_string($_POST['receiver']);
// $dispatcher = $conn->real_escape_string($_POST['dispatcher']);
// $status = $conn->real_escape_string($_POST['status']);

// // Check if the stock item exists and fetch current quantity
// $stock_query = "SELECT quantity FROM stock WHERE id = $stock_id";
// $stock_result = $conn->query($stock_query);

// if ($stock_result->num_rows > 0) {
//     $stock = $stock_result->fetch_assoc();
//     $current_quantity = $stock['quantity'];

//     if ($current_quantity >= $quantity) {
//         // Deduct the dispatched quantity from the stock
//         $new_quantity = $current_quantity - $quantity;
//         $update_query = "UPDATE stock SET quantity = $new_quantity WHERE id = $stock_id";

//         if ($conn->query($update_query) === TRUE) {
//             // Insert into dispatches table
//             $dispatch_query = "INSERT INTO dispatches (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status)
//                                VALUES ($stock_id, '$project', '$destination', $quantity, '$dispatch_date', '$receiver', '$dispatcher', '$status')";

//             if ($conn->query($dispatch_query) === TRUE) {
//                 // Insert into transactions table
//                 $transaction_query = "INSERT INTO transactions (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status)
//                                       VALUES ($stock_id, '$project', '$destination', $quantity, '$dispatch_date', '$receiver', '$dispatcher', '$status')";

//                 if ($conn->query($transaction_query) === TRUE) {
//                     echo "Stock dispatched successfully and recorded in transactions.";
//                     // header("Location: dashboard.php");
//                     exit();
//                 } else {
//                     echo "Error inserting into transactions: " . $conn->error;
//                 }
//             } else {
//                 echo "Error inserting into dispatches: " . $conn->error;
//             }
//         } else {
//             echo "Error updating stock: " . $conn->error;
//         }
//     } else {
//         echo "Insufficient stock quantity.";
//     }
// } else {
//     echo "Stock item not found.";
// }

// // Close the database connection
// $conn->close();


// Retrieve form data
$dispatch_date = $_POST['dispatch_date'];
$project_name = $_POST['project_name'];
$destination = $_POST['destination'];
$dispatcher = $_POST['dispatcher'];
$receiver = $_POST['receiver'];
$items = $_POST['items']; // Array of stock item IDs
$quantities = $_POST['quantities']; // Array of quantities

// Start Transaction
$conn->begin_transaction();
try {
    // Loop through each dispatched item
    for ($i = 0; $i < count($items); $i++) {
        $stock_id = $items[$i];
        $quantity = $quantities[$i];

        // Check if stock is available
        $stock_check = $conn->query("SELECT quantity FROM stock WHERE id = $stock_id");
        $stock_row = $stock_check->fetch_assoc();
        if (!$stock_row || $stock_row['quantity'] < $quantity) {
            throw new Exception("Insufficient stock for item ID: $stock_id");
        }

        // Insert dispatch record
        $stmt = $conn->prepare("INSERT INTO dispatches (stock_id, project, destination, quantity, dispatch_date, receiver, dispatcher, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 'Out')");
        $stmt->bind_param("ississs", $stock_id, $project_name, $destination, $quantity, $dispatch_date, $receiver, $dispatcher);
        $stmt->execute();

        // Subtract dispatched stock from available stock
        $conn->query("UPDATE stock SET quantity = quantity - $quantity WHERE id = $stock_id");
    }

    // Commit transaction if everything is successful
    $conn->commit();
   // Redirecting user to dashboard.php with a page parameter
header("Location: http://localhost/woodnork-green-portal/dashboard.php?page=stock_allocation");
} catch (Exception $e) {
    // Rollback transaction on failure
    $conn->rollback();
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='index.php';</script>";
}

// Close connection
$conn->close();
?>
