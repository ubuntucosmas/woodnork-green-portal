<div class="container">
    <h2 class="text-center mb-4">Inventory</h2>

    <div class="d-flex justify-content-between">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inventoryModal">+ Add Inventory</button>
        <form action="pages/stores/store-actions/import_inventory.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
            <input type="file" name="excelFile" accept=".xlsx, .xls" class="form-control me-2" required>
            <button type="submit" class="btn btn-primary">📥 Upload & Import</button>
        </form>
    </div>

    <div id="loadingSpinner" class="spinner-border text-primary d-none my-3"></div>

    <!-- Inventory Table -->
    <div class="table-responsive mt-3">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Make/Manufacturer</th>
                    <th>Model</th>
                    <th>Serial No.</th>
                    <th>Specifications</th>
                    <th>User</th>
                    <th>Cost</th>
                    <th>Condition</th>
                    <th>Actions</th>  
                </tr>
            </thead>
            <tbody id="inventory_body">
                <tr><td colspan="10" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Inventory Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">📋 Add Inventory</h5>
                <span class="close-x" data-bs-dismiss="modal" aria-label="Close">×</span>
            </div>
            <div class="modal-body p-4">
                <form id="inventoryForm" onsubmit="submitInventory(event)">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-semibold">📅 Date:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="col-md-6">
                            <label for="make" class="form-label fw-semibold">Make/Manufacturer:</label>
                            <input type="text" class="form-control" id="make" name="make" required>
                        </div>

                        <div class="col-md-6">
                            <label for="model" class="form-label fw-semibold">Model:</label>
                            <input type="text" class="form-control" id="model" name="model" required>
                        </div>

                        <div class="col-md-6">
                            <label for="serial" class="form-label fw-semibold">Serial Number:</label>
                            <input type="text" class="form-control" id="serial" name="serial" required>
                        </div>

                        <div class="col-md-6">
                            <label for="specs" class="form-label fw-semibold">⚙️ Specifications:</label>
                            <input type="text" class="form-control" id="specs" name="specs" required>
                        </div>

                        <div class="col-md-6">
                            <label for="user" class="form-label fw-semibold">👤User:</label>
                            <input type="text" class="form-control" id="user" name="user" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cost" class="form-label fw-semibold">Cost:</label>
                            <input type="number" class="form-control" id="cost" name="cost" required>
                        </div>

                        <div class="col-md-6">
                            <label for="condition" class="form-label fw-semibold">Condition:</label>
                            <select class="form-select" id="condition" name="condition" required>
                                <option value="" disabled selected>-- Select Condition --</option>
                                <option value="New">New</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Damaged">Damaged</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">✅ Save Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/inventory.js"></script>