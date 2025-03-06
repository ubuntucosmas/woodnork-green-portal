<?php
// Include database connection
include "../../includes/db.php";

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




// Fetch available stock items
$stock_query = "SELECT id, name FROM stock";
$stock_result = $db->prepare($stock_query);
$stock_result->execute();
$stocks_available = $stock_result->fetchAll(PDO::FETCH_ASSOC);
?>

<!-------============================================================================================================== -->
<div class="stock-management">
    <h2>Stock Management</h2>

    <!-- Add Stock Button -->
    <button class="add-stock-btn" onclick="openStockModal()">+ Add New Stock</button>
        <!-- Trigger Button -->
    <button class="btn btn-outline-success" data-toggle="modal" data-target="#updateStockModal">
        Update Stock
    </button>



    <div class="export-buttons">
        <button class="btn btn-success" onclick="window.location.href='/portal/pages/stores/store-actions/export_stock.php'">
            Export to Excel
        </button>

        <button class="btn btn-danger" onclick="window.location.href='/portal/pages/stores/store-actions/export_stock_pdf.php'">
            Export to PDF
        </button>

        

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
                    <!-- <th>Status</th> -->
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
                        <!-- <td><?= htmlspecialchars($stock['status']) ?></td> -->
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

            <!-- <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" readonly> -->

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="in">In</option>
                <!-- <option value="out">Out</option> -->
                <!-- <option value="discontinued">Discontinued</option> -->
            </select>

            <button type="submit">Save Stock</button>
        </form>
    </div>
</div>

<!-- Update Stock Modal -->
<div class="modal fade" id="updateStockModal" tabindex="-1" role="dialog" aria-labelledby="updateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStockModalLabel">Update Stock Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="pages/stores/store-actions/process_update_stock.php" method="post">
                    <div class="form-group">
                        <label for="item">Item:</label>
                        <select id="item" name="stock_id" required>
                            <option value="" disabled selected>Select Item</option>
                            <?php foreach ($stocks_available as $item): ?>
                                <option value="<?= htmlspecialchars($item['id']) ?>">
                                    <?= htmlspecialchars($item['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity to Add/Subtract:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="operation">Operation:</label>
                        <select class="form-control" id="operation" name="operation" required>
                            <option value="add">Add</option>
                            <option value="subtract">Subtract</option>
                        </select>
                    </div>

                    <!-- Hidden input to store status dynamically -->
                    <input type="hidden" id="status" name="status" value="in">

                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- js for the above is in stores.js -->



<script src="store.js"></script>

