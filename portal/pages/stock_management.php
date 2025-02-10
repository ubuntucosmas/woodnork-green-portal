<?php
// pages/stock_management.php
?>

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
                    <th>Unit of Measure</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="stock_body">
                <tr><td colspan="5">Loading...</td></tr>
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
            
            <label for="item_name">Date:</label>
            <input type="date" id="date" placeholder="Enter Date" required>

            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" placeholder="Enter item name" required>

            <label for="category">Category:</label>
            <select id="category" required>
                <option value="" disabled selected>Select category</option>
                <option value="Electronics">Electronics</option>
                <option value="Furniture">Furniture</option>
                <option value="Stationery">Stationery</option>
            </select>

            <label for="quantity">Unit Of Measure:</label>
            <input type="text" id="uom" placeholder="Enter Unit of Measure" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" placeholder="Enter quantity" required>

            <label for="quantity">Amount:</label>
            <input type="number" id="price" placeholder="Price per unit" required>

            <label for="quantity">Total Price:</label>
            <input type="number" id="total" placeholder="Enter Total price" required>

            <label for="quantity">Status:</label>
            <input type="text" id="total" placeholder="Enter Total price" required>


            <button type="submit">Save Stock</button>
        </form>
    </div>
</div>

