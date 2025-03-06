<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Stock</title>
</head>
<body>

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

// Fetch available stock items
$stock_query = "SELECT id, name FROM stock WHERE quantity > 0";
$stock_result = $conn->query($stock_query);
?>
    <h2>Update Stock Quantity</h2>
    <form action="process_update_stock.php" method="post">
    <label for="item">Item:</label>
            <select id="item" name="stock_id" required>
                <option value="" disabled selected>Select Item</option>
                <?php
                if ($stock_result->num_rows > 0) {
                    while($row = $stock_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                }
                ?>
            </select>

        <label for="quantity">Quantity to Add/Subtract:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <label for="operation">Operation:</label>
        <select id="operation" name="operation" required>
            <option value="add">Add</option>
            <option value="subtract">Subtract</option>
        </select><br>

        <button type="submit">Update Stock</button>
    </form>
</body>
</html>
