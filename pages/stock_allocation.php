<div class="stock-allocation-container">
    <h2>Stock Allocation</h2>

    <!-- Dispatch Button -->
    <button id="openDispatchModal" class="dispatch-btn">Dispatch Stock</button>

    <!-- Dispatch Table -->
    <h3>Dispatched Stock</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Project</th>
                <th>Destination</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Receiver</th>
                <th>Dispatcher</th>
            </tr>
        </thead>
        <tbody id="dispatchTableBody">
            <tr><td colspan="6">No dispatches yet.</td></tr>
        </tbody>
    </table>
</div>

<!-- Stock Allocation Modal -->
<div id="dispatchModalx">
    <div class="dispatch-content">
        <span class="x">&times;</span>
        <h2>Dispatch Stock</h2>
        <form id="dispatchForm">
            <label for="item">Item:</label>
            <select id="item" required>
                <option value="" disabled selected>Select Item</option>
                <option value="Laptop">Laptop</option>
                <option value="Printer">Printer</option>
                <option value="Stationery">Stationery</option>
            </select>

            <label for="Project">Project:</label>
            <input type="text" id="project" required>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" required>

            <label for="date">Date:</label>
            <input type="date" id="date" require>

            <label for="receiver">Receiver:</label>
            <input type="text" id="receiver" required>

            <label for="Dispatcher">Dispatcher:</label>
            <input type="text" id="Dispatcher" required>

            <button type="submit" id="dispatchBtn">Dispatch</button>
        </form>
    </div>
</div>