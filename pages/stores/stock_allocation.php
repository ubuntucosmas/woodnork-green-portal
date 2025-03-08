<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available stock items
$stock_query = "SELECT id, name FROM stock WHERE quantity > 0";
$stock_result = $conn->query($stock_query);
?>

<div class="container mt-4">
    <h2 class="mb-3">Stock Allocation</h2>

    <!-- Dispatch Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#dispatchModal">Dispatch Stock</button>

    <!-- Dispatch Table -->
    <div class="table-responsive">
        <h3>Dispatched Stock</h3>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
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
            <tbody>
                <?php
                $dispatch_query = "SELECT d.id, s.name AS item_name, d.project, d.destination, d.quantity, d.dispatch_date, d.receiver, d.dispatcher, d.status 
                                   FROM dispatches d 
                                   JOIN stock s ON d.stock_id = s.id 
                                   ORDER BY d.dispatch_date DESC";
                $dispatch_result = $conn->query($dispatch_query);

                if ($dispatch_result->num_rows > 0) {
                    while ($row = $dispatch_result->fetch_assoc()) {
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
                    echo "<tr><td colspan='9' class='text-center'>No dispatches yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Stock Allocation Modal -->
    
    <div class="modal fade" id="dispatchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock Dispatch Form</h5>
                    <span class="close-btn" data-bs-dismiss="modal">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="pages/stores/store-actions/dispatch_process.php" method="POST">
                        <label>Date:</label>
                        <input type="date" name="dispatch_date" class="form-control" required>

                        <label>Project Name:</label>
                        <input type="text" name="project_name" class="form-control" required>

                        <label>Destination:</label>
                        <input type="text" name="destination" class="form-control" required>

                        <label>Dispatcher:</label>
                        <input type="text" name="dispatcher" class="form-control" required>

                        <label>Receiver:</label>
                        <input type="text" name="receiver" class="form-control" required>

                        <div id="stock_items">
                            <div class="item-group">
                                <select name="items[]" required>
                                    <option value="">Select Item</option>
                                    <?php while ($row = $stock_result->fetch_assoc()): ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="number" name="quantities[]" min="1" required>
                                <button type="button" class="remove-item">X</button>
                            </div>
                        </div>
                        <button type="button" id="add_item" class="btn btn-secondary mt-2">Add More Items</button>
                        <button type="submit" class="btn btn-primary mt-3 w-100">Submit</button>
                    </form>
                </div>
            </div>
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


