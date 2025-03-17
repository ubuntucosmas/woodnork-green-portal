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

// Get dispatch ID from URL
$dispatch_id = isset($_GET['dispatch_id']) ? intval($_GET['dispatch_id']) : 0;

if ($dispatch_id > 0) {
    // Fetch dispatch details
    $query = "SELECT d.*, s.name AS stock_name FROM dispatches d 
              JOIN stock s ON d.stock_id = s.id WHERE d.id = $dispatch_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $dispatch = $result->fetch_assoc();
    } else {
        die("Invalid dispatch ID.");
    }
} else {
    die("No dispatch ID provided.");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dispatch Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .receipt-container { width: 60%; margin: auto; padding: 20px; border: 1px solid #000; }
        .receipt-header { text-align: center; font-size: 24px; font-weight: bold; }
        .receipt-details { margin-top: 20px; }
        .receipt-details table { width: 100%; border-collapse: collapse; }
        .receipt-details th, .receipt-details td { border: 1px solid #000; padding: 8px; text-align: left; }
        .print-btn { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="receipt-header">Dispatch Receipt</div>
    
    <div class="receipt-details">
        <p><strong>Dispatch Date:</strong> <?php echo $dispatch['dispatch_date']; ?></p>
        <p><strong>Project:</strong> <?php echo $dispatch['project']; ?></p>
        <p><strong>Destination:</strong> <?php echo $dispatch['destination']; ?></p>
        <p><strong>Dispatcher:</strong> <?php echo $dispatch['dispatcher']; ?></p>
        <p><strong>Receiver:</strong> <?php echo $dispatch['receiver']; ?></p>
        
        <table>
            <tr>
                <th>Stock Name</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td><?php echo $dispatch['stock_name']; ?></td>
                <td><?php echo $dispatch['quantity']; ?></td>
            </tr>
        </table>
    </div>

    <div class="print-btn">
        <button onclick="window.print()">Print Receipt</button>
    </div>
</div>

</body>
</html>
