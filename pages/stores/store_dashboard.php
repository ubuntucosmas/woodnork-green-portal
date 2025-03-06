<div class="store-dashboard">
    <h2>Store Dashboard</h2>
    
    <div class="store-stats">
        <div class="stat-box" id="totalStock">
            <h3>Total Stock Items</h3>
            <p id="total_stock"></p>
        </div>
        <div class="stat-box" id="lowStock">
            <h3>Low Stock Alerts</h3>
            <p id="low_stock"></p>
        </div>
        <div class="stat-box" id="recentTransactions">
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



<!-- Modal for displaying low stock items -->
<div class="modal fade" id="lowStockModal" tabindex="-1" aria-labelledby="lowStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lowStockModalLabel">Low Stock Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Reorder Level</th>
                            </tr>
                        </thead>
                        <tbody id="lowStockTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#lowStock").click(function () {
                // Fetch data from the PHP script
                $.ajax({
                    url: "fetch_low_stock.php", // The PHP script to get low stock data
                    method: "GET",
                    dataType: "json",
                    success: function (data) {
                        var tableBody = $("#lowStockTableBody");
                        tableBody.empty(); // Clear previous data

                        if (data.length > 0) {
                            data.forEach(function (item) {
                                var row = "<tr>" +
                                    "<td>" + item.name + "</td>" +
                                    "<td>" + item.category + "</td>" +
                                    "<td>" + item.quantity + "</td>" +
                                    "<td>" + item.reorder_level + "</td>" +
                                    "</tr>";
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append("<tr><td colspan='4' class='text-center'>No low stock items found.</td></tr>");
                        }

                        $("#lowStockModal").modal("show"); // Show the modal
                    },
                    error: function () {
                        alert("Error fetching low stock data.");
                    }
                });
            });
        });
    </script>



