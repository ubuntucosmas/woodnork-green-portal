<?php
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

// Fetch low stock items (Quantity < 10)
$query = "SELECT name, category_id, description, quantity, unit_of_measure, price_per_unit, 
                 (quantity * price_per_unit) AS total_price 
          FROM stock 
          WHERE quantity < 10";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $lowStockItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<div class="store-dashboard">
    <h2>Store Dashboard</h2>

    <div class="store-stats">
    <div class="stat-box">
        <h3>Total Stock</h3>
        <p id="total_stock">-</p>
    </div>
    <div id="lowStockTrigger" class="stat-box" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#lowStockModal">
        <h3 >
            Low Stock
        </h3>
        <p id="low_stock">-</p>
    </div>
    <div class="stat-box">
        <h3>Recent Transactions</h3>
        <p id="recent_transactions">-</p>
    </div>
</div>


    <div class="filter-section">
        <input type="text" id="search_item" placeholder="Search by Item">
        <select id="filter_type">
            <option value="">All Types</option>
            <option value="in">IN</option>
            <option value="out">OUT</option>
        </select>
        <input type="date" id="filter_date">
        <button onclick="loadSearchData()">Apply Filters</button>
    </div>

    <h3 class="text-center mb-4">Recent Transactions</h3>

    <div class="transactions-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Available Stock</th>
                        <th>UoM</th>
                        <th>Date</th>
                        <th>Transactions status</th>
                    </tr>
                </thead>
                <tbody id="transactions_body">
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .modal-dialog {
        max-width: 90vw; /* Make the modal wider */
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto; /* Center horizontally */
    }

    .modal-content {
        width: 90%; /* Expand modal width */
        max-width: 1200px; /* Set maximum width */
        overflow: hidden; /* Remove unnecessary scroll */
        margin: auto; /* Center the modal content */
    }

    .modal-body {
        max-height: none !important; /* Remove height restriction */
        overflow-x: hidden !important; /* Hide horizontal scroll */
        overflow-y: auto; /* Allow vertical scroll if necessary */
        text-align: center; /* Ensure content is centered */
    }

    .modal-body table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
    }
</style>


<!-- Low Stock Modal -->
<div class="modal fade" id="lowStockModal" tabindex="-1" aria-labelledby="lowStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lowStockModalLabel">Low Stock Items</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>

            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>UoM</th>
                            <th>Price/Unit</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody id="lowStockTableBody">
                        <?php if (!empty($lowStockItems)): ?>
                            <?php foreach ($lowStockItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['category_id']) ?></td>
                                    <td><?= htmlspecialchars($item['description']) ?></td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= htmlspecialchars($item['unit_of_measure']) ?></td>
                                    <td><?= number_format($item['price_per_unit'], 2) ?></td>
                                    <td><?= number_format($item['total_price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">No low stock items found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



