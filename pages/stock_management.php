<?php
// Include database connection
include "../includes/db.php";

// Get database instance
$db = Database::getInstance()->getConnection();

// Fetch categories using PDO
$sql = "SELECT id, name FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch stock records
$sqlStock = "SELECT stock.*, category.name AS category_name 
             FROM stock 
             LEFT JOIN category ON stock.category_id = category.id 
             ORDER BY stock.created_at ASC";
$stmtStock = $db->prepare($sqlStock);
$stmtStock->execute();
$stocks = $stmtStock->fetchAll(PDO::FETCH_ASSOC);
?>

<!-------============================================================================================================== -->
<div class="stock-management">
    <h2>Stock Management</h2>

    <!-- Add Stock Button -->
    <button class="add-stock-btn" onclick="openStockModal()">+ Add New Stock</button>


    <div class="export-buttons">
        <button onclick="exportStock('excel')">Export to Excel</button>
        <button onclick="exportStock('pdf')">Export to PDF</button>
    </div>

    <div id="loadingSpinner" class="spinner" style="display: none;"></div>

    <!-- Stock Table -->
    <div class="stock-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Unit of Measure</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="stock_body">
                <!-- Stock items will be dynamically loaded here via JavaScript -->
                <?php foreach ($stocks as $stock): ?>
                    <tr>
                        <td><?= htmlspecialchars($stock['id']) ?></td>
                        <td><?= htmlspecialchars($stock['created_at']) ?></td>
                        <td><?= htmlspecialchars($stock['name']) ?></td>
                        <td><?= htmlspecialchars($stock['category_name']) ?></td>
                        <td><?= htmlspecialchars($stock['description']) ?></td>
                        <td><?= htmlspecialchars($stock['unit_of_measure']) ?></td>
                        <td><?= htmlspecialchars($stock['quantity']) ?></td>
                        <td><?= htmlspecialchars($stock['price_per_unit']) ?></td>
                        <td><?= htmlspecialchars($stock['total_price']) ?></td>
                        <td><?= htmlspecialchars($stock['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Stock Modal -->
<div id="stockModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeStockModal()">&times;</span>
        <h3 id="modalTitle">Add Stock</h3>

        <form id="stockForm">
            <input type="hidden" id="stock_id">

            <label for="date">Date:</label>
            <input type="date" id="date" name="date">

            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>

                        <!-- Category Dropdown -->
            <label for="Category">Category:</label>
            <select id="category" name="category" required>
                <option value="" disabled selected>Select category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="unit_of_measure">Unit of Measure:</label>
            <select id="unit_of_measure" name="unit_of_measure" required>
                <option value="pcs">Pieces</option>
                <option value="kg">Kilograms</option>
                <option value="liters">Liters</option>
                <option value="meters">Meters</option>
                <option value="boxes">Boxes</option>
                <option value="packs">Packs</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="price_per_unit">Price per Unit:</label>
            <input type="number" id="price_per_unit" name="price_per_unit" required>

            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" readonly>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="available">Available</option>
                <option value="out_of_stock">Out of Stock</option>
                <option value="discontinued">Discontinued</option>
            </select>

            <button type="submit">Save Stock</button>
        </form>
    </div>
</div>

<script src="store.js"></script>
