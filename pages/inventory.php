
<div class="container mt-4">
    <h2 class="text-center">Inventory Management</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#inventoryModal">+ Add Inventory</button>

    <div id="loadingSpinner" class="spinner-border text-primary d-none"></div>

    <!-- Inventory Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Make/Manufacturer</th>
                    <th>Model</th>
                    <th>Serial No:</th>
                    <th>Specifications</th>
                    <th>User</th>
                    <th>Cost</th>
                    <th>Condition</th>
                    <th>Actions</th>  <!-- New Actions Column -->
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
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title fw-bold" id="modalTitle">
                    <span class="icon"></span> Add Inventory
                </h5>
                <span class="close-x" data-bs-dismiss="modal" aria-label="Close">X</span>
            </div>
            <div class="modal-body p-4">
                <form id="inventoryForm" onsubmit="submitInventory(event)">
                    <div class="row g-3">
                        <input type="hidden" id="inventory_id" name="inventory_id">

                        <div class="col-md-6">
                            <label for="date" class="form-label fw-semibold">
                                <span class="icon"></span> Date:
                            </label>
                            <input type="date" class="form-control rounded-3" id="date" name="date" required>
                        </div>

                        <div class="col-md-6">
                            <label for="make" class="form-label fw-semibold">
                                <span class="icon"></span> Make/Manufacturer:
                            </label>
                            <input type="text" class="form-control rounded-3" id="make" name="make" required>
                        </div>

                        <div class="col-md-6">
                            <label for="model" class="form-label fw-semibold">
                                <span class="icon"></span> Model:
                            </label>
                            <input type="text" class="form-control rounded-3" id="model" name="model" required>
                        </div>

                        <div class="col-md-6">
                            <label for="serial" class="form-label fw-semibold">
                                <span class="icon"></span> Serial Number:
                            </label>
                            <input type="text" class="form-control rounded-3" id="serial" name="serial" required>
                        </div>

                        <div class="col-md-6">
                            <label for="specs" class="form-label fw-semibold">
                                <span class="icon"></span> Specifications:
                            </label>
                            <input type="text" class="form-control rounded-3" id="specs" name="specs" required>
                        </div>

                        <div class="col-md-6">
                            <label for="user" class="form-label fw-semibold">
                                <span class="icon"></span> User:
                            </label>
                            <input type="text" class="form-control rounded-3" id="user" name="user" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cost" class="form-label fw-semibold">
                                <span class="icon"></span> Cost:
                            </label>
                            <input type="number" class="form-control rounded-3" id="cost" name="cost" required>
                        </div>

                        <div class="col-md-6">
                            <label for="condition" class="form-label fw-semibold">
                                <span class="icon"></span> Condition:
                            </label>
                            <select class="form-select rounded-3" id="condition" name="condition" required>
                                <option value="" disabled selected>-- Select Condition --</option>
                                <option value="New">New</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Damaged">Damaged</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                             Save Inventory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .close-x {
        font-size: 22px;
        font-weight: bold;
        color: #6c757d; /* Soft gray */
        cursor: pointer;
        margin-right: 10px;
    }
    .close-x:hover {
        color: #999;
    }
    .icon {
        color: #6c757d; /* Subtle icon color */
        font-size: 1rem;
        margin-right: 5px;
    }
</style>

<style>
    .close-x {
        font-size: 24px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        margin-right: 10px;
    }
    .close-x:hover {
        color: #ffcccb;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/inventory.js"></script>

</body>
</html>
