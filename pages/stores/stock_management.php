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
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#stockModal">Update Stock</button>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Stock Category</button>
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#stockModal">+ Add New Stock</button>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-outline-success" onclick="window.location.href='pages/stores/store-actions/export_stock.php'">Export to Excel</button>
            <button class="btn btn-outline-danger" onclick="window.location.href='pages/stores/store-actions/export_stock_pdf.php'">Export to PDF</button>
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
                <th>ACTIONS</th> <!-- New column for Edit/Delete -->
            </tr>
        </thead>
        <tbody id="stock_body">
            <!-- table content -->
        </tbody>
    </table>
</div>


<!-- Add Stock Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4" style="background:white; backdrop-filter: blur(10px); color: black;">
            
            <!-- Modal Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modal-title" style="letter-spacing: 1px;"> Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="stockForm" action="pages/stores/store-actions/save_stock.php" method="POST">
                    
                    <input type="hidden" id="stock_id" name="stock_id"> <!-- Hidden input for stock ID -->

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control bg-grey text-black border-1" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock_item">Stock Item</label>
                            <input type="text" id="stock_item" name="stock_item" class="form-control bg-grey text-black border-1" required>
                        </div>

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

                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control bg-grey text-black border-1" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control bg-grey text-black border-1" required>
                        </div>

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

                        <div class="col-md-6">
                            <label for="price_per_unit" class="form-label">Price Per Unit</label>
                            <input type="number" step="0.01" id="price_per_unit" name="price_per_unit" class="form-control bg-grey text-black border-1" required>
                        </div>

                        <input type="hidden" id="status" name="status" value="In">
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary w-50 py-2 fw-bold" id="newupdate">
                            <i class="fas fa-save"></i> Save Stock
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header text-black">
                <h5 class="modal-title" id="addCategoryModalLabel"></> Add Stock Category</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="pages/stores/store-actions/add_category.php" method="POST">
                    
                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-bold">Category Name</label>
                        <input type="text" id="category_name" name="category_name" class="form-control shadow-sm" placeholder="Enter category name" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-primary w-50">
                            <i class="bi bi-save"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
<!-- js for the above is in stores.js -->

<script src="store.js"></script>
<script src="assets/js/stock-management.js" defer></script>

