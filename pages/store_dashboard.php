<div class="store-dashboard">
    <h2>Store Dashboard</h2>
    
    <div class="store-stats">
        <div class="stat-box">
            <h3>Total Stock Items</h3>
            <p id="total_stock"></p>
        </div>
        <div class="stat-box">
            <h3>Low Stock Alerts</h3>
            <p id="low_stock"></p>
        </div>
        <div class="stat-box">
            <h3>Recent Transactions</h3>
            <p id="recent_transactions"></p>
        </div>
    </div>

    <!-- Filter Section -->
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

    <!-- Recent Transactions Table -->
    <h3 class="section-title">Recent Transactions</h3>
    <div class="transactions-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Stock Quantity Available </th>
                    <th>Unit of Measure</th>
                    <th>Date</th>
                    <th>Recent Transactions Status</th>
                </tr>
            </thead>
            <tbody id="transactions_body">
                <tr><td colspan="5">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>


