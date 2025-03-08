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

// Fetch stock items for the dropdown
$sqlItems = "SELECT id, name FROM stock";
$stmtItems = $db->prepare($sqlItems);
$stmtItems->execute();
$stockItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

?>


<!-------============================================================================================================== -->
<div class="container stock-management">
        <h2 class="text-center">Stock Management</h2>
        
        <div class="d-flex justify-content-between my-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal">+ Add New Stock</button>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateStockModal">Update Stock</button>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success" onclick="window.location.href='pages/stores/store-actions/export_stock.php'">Export to Excel</button>
            <button class="btn btn-danger" onclick="window.location.href='pages/stores/store-actions/export_stock_pdf.php'">Export to PDF</button>
        </div>
        
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-grey">
                    <tr>
                        <th>#</th>
                        <th>DATE</th>
                        <th>ITEM NAME</th>
                        <th>CATEGORY</th>
                        <th>DESCRIPTION</th>
                        <th>UoM</th>
                        <th>QUANTITY</th>
                        <th>PRICE/UNIT</th>
                        <th>TOTAL PRICE</th>
                    </tr>
                </thead>
                <tbody id="stock_body">
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<!-- Fancy Add/Edit Stock Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Enlarged for better UI -->
        <div class="modal-content shadow-lg border-0 rounded-4" style="background:white; backdrop-filter: blur(10px); color: black;">
            
            <!-- Modal Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title text-uppercase fw-bold" style="letter-spacing: 1px;">
                    <i class="fas fa-box-open text-primary"></i> Add Stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="pages/stores/store-actions/save_stock.php" method="POST">
                    
                    <div class="row g-3">
                        <!-- Date -->
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control bg-grey text-black border-1" required>
                        </div>

                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="stock_item">Stock Item</label>
                            <select id="stock_item" name="stock_item" class="form-select" required>
                                <option value="" disabled selected>Select an item</option>
                                <?php foreach ($stockItems as $item): ?>
                                    <option value="<?= htmlspecialchars($item['id']) ?>">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id" class="form-select bg-grey text-black border-1" required>
                                <option value="" disabled selected>Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control bg-grey text-black border-1" rows="2"></textarea>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control bg-grey text-black border-1" required>
                        </div>

                        <!-- Unit of Measure -->
                        <div class="col-md-6">
                            <label for="unit_of_measure" class="form-label">Unit of Measure</label>
                            <select id="unit_of_measure" name="unit_of_measure" class="form-select bg-grey text-black border-1" required>
                                <option value="pcs">Pieces</option>
                                <option value="kg">Kilograms</option>
                                <option value="liters">Liters</option>
                                <option value="meters">Meters</option>
                                <option value="boxes">Boxes</option>
                                <option value="packs">Packs</option>
                            </select>
                        </div>

                        <!-- Price Per Unit -->
                        <div class="col-md-6">
                            <label for="price_per_unit" class="form-label">Price Per Unit</label>
                            <input type="number" step="0.01" id="price_per_unit" name="price_per_unit" class="form-control bg-grey text-black border-1" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select bg-grey text-black border-1">
                                <option value="Available">IN</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fas fa-save"></i> Save Stock
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Update Stock Modal -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Stock Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label>Item</label>
                            <select class="form-select" required>
                                <option value="" disabled selected>Select Item</option>
                                <?php foreach ($stocks_available as $item): ?>
                                    <option value="<?= htmlspecialchars($item['id']) ?>">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Operation</label>
                            <select class="form-select" required>
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Update Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
<!-- js for the above is in stores.js -->

<script src="store.js"></script>

