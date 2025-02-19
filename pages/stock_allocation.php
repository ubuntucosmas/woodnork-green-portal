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

<div class="stock-allocation-container">
    <h2>Stock Allocation</h2>

    <!-- Dispatch Button -->
    <button id="openDispatchModal" onclick="openModal('dispatchModal')" class="dispatch-btn">Dispatch Stock</button>

    <!-- Dispatch Table -->
    <h3>Dispatched Stock</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Project</th>
                <th>Destination</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Receiver</th>
                <th>Dispatcher</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="dispatchTableBody">
            <?php
            // Fetch dispatched stock records
            $dispatch_query = "SELECT d.id, s.name AS item_name, d.project, d.destination, d.quantity, d.dispatch_date, d.receiver, d.dispatcher, d.status
                               FROM dispatches d
                               JOIN stock s ON d.stock_id = s.id
                               ORDER BY d.dispatch_date DESC";
            $dispatch_result = $conn->query($dispatch_query);

            if ($dispatch_result->num_rows > 0) {
                while($row = $dispatch_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['project']}</td>
                            <td>{$row['destination']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['dispatch_date']}</td>
                            <td>{$row['receiver']}</td>
                            <td>{$row['dispatcher']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No dispatches yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Stock Allocation Modal -->
<div id="dispatchModal" class="Modal" style="display:none;">
    <div class="dispatch-content">
        <span class="close" onclick="closeModal('dispatchModal')">&times;</span>
        <h2>Dispatch Stock</h2>
        <form id="dispatchForm" action="dispatch_process.php" method="post">
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

            <label for="project">Project:</label>
            <input type="text" id="project" name="project" required>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="dispatch_date">Date:</label>
            <input type="date" id="dispatch_date" name="dispatch_date" required>

            <label for="receiver">Receiver:</label>
            <input type="text" id="receiver" name="receiver" required>

            <label for="dispatcher">Dispatcher:</label>
            <input type="text" id="dispatcher" name="dispatcher" required>

            
            <!-- Hidden input to store status dynamically -->
            <input type="hidden" id="status" name="status" value="out">

            <button type="submit" id="dispatchBtn">Dispatch</button>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
</script>

<?php
$conn->close();
?>
