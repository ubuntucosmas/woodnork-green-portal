<?php
// pages/inventory.php
?>

<div class="inventory">
    <h2>Inventory Management</h2>

    <!-- Add Inventory Button -->
    <button class="add-inventory-btn" onclick="openInventoryModal()">+ Add Inventory</button>
    
<div class="export-buttons">
    <button onclick="exportInventory('excel')">Export to Excel</button>
    <button onclick="exportInventory('pdf')">Export to PDF</button>
</div>

    <div id="loadingSpinner" class="spinner" style="display: none;"></div>
    
    <!-- inventory Table -->
    <div class="inventory-container">
        <table>
            <thead>
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
                </tr>
            </thead>
            <tbody id="inventory_body">
                <tr><td colspan="9">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit inventory Modal -->
<div id="inventoryModal" class="inventoryModal">
    <div class="inventory-content">
    <span class="close" onclick="closeModal('inventoryModal')">&times;</span>

    <h2 id="modalTitle">Add inventory</h2>
        
        <form id="inventoryForm">
            <input type="hidden" id="inventory_id">
            
            <label for="date">Date:</label>
            <input type="date" id="date" placeholder="Enter Date" required>

            <label for="make">Make/Manufucturer:</label>
            <input type="text" id="make" placeholder="Enter Make" required>

            <label for="model">Model:</label>
            <input type="text" id="model" placeholder="Enter model" required>

            <label for="serial">Serial Number:</label>
            <input type="text" id="serial" placeholder="Enter Serial" required>

            <label for="specification">Specifications:</label>
            <input type="text" id="specs" placeholder="Enter Spects" required>

            <label for="user">User:</label>
            <input type="text" id="user" placeholder="Enter User" required>

            <label for="cost">Cost:</label>
            <input type="number" id="cost" placeholder="Enter cost" required>

            <label for="condition">Condition:</label>
            <input type="text" id="condition" placeholder="How is the condition" required>


            <button type="submit">Save inventory</button>
        </form>
    </div>
</div>