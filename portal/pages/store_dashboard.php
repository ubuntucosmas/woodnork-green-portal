<div class="store-dashboard">
    <h2>Store Dashboard</h2>
    
    <div class="store-stats">
        <div class="stat-box">
            <h3>Total Stock Items</h3>
            <p id="total_stock">Loading...</p>
        </div>
        <div class="stat-box">
            <h3>Low Stock Alerts</h3>
            <p id="low_stock">Loading...</p>
        </div>
        <div class="stat-box">
            <h3>Recent Transactions</h3>
            <p id="recent_transactions">Loading...</p>
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
        <button onclick="loadStoreData()">Apply Filters</button>
    </div>

    <!-- Recent Transactions Table -->
    <h3 class="section-title">Recent Transactions</h3>
    <div class="transactions-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="transactions_body">
                <tr><td colspan="5">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function loadStoreData() {
        let item = document.getElementById("search_item").value;
        let type = document.getElementById("filter_type").value;
        let date = document.getElementById("filter_date").value;

        fetch(`pages/store_overview.php?item=${item}&type=${type}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("total_stock").innerText = data.total_stock;
                document.getElementById("low_stock").innerText = data.low_stock;
                document.getElementById("recent_transactions").innerText = data.recent_transactions;

                let transactionsTable = document.getElementById("transactions_body");
                transactionsTable.innerHTML = "";

                if (data.transactions.length > 0) {
                    data.transactions.forEach((transaction, index) => {
                        transactionsTable.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${transaction.item_name}</td>
                                <td>${transaction.quantity}</td>
                                <td class="${transaction.type === 'in' ? 'in' : 'out'}">${transaction.type.toUpperCase()}</td>
                                <td>${transaction.date}</td>
                            </tr>`;
                    });
                } else {
                    transactionsTable.innerHTML = `<tr><td colspan="5">No transactions found.</td></tr>`;
                }
            })
            .catch(error => console.error('Error fetching store data:', error));
    }

    loadStoreData();
</script>
