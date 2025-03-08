<div class="store-dashboard">
    <h2>Store Dashboard</h2>

    <div class="store-stats">
    <div class="stat-box">
        <h3>Total Stock</h3>
        <p id="total_stock">-</p>
    </div>
    <div class="stat-box">
        <h3 id="lowStockTrigger" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#lowStockModal">
            Low Stock
        </h3>
        <p id="low_stock">-</p>
    </div>
    <div class="stat-box">
        <h3>Recent Transactions</h3>
        <p id="recent_transactions">-</p>
    </div>
</div>


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

    <h3 class="text-center mb-4">Recent Transactions</h3>

    <div class="transactions-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Available Stock</th>
                        <th>UoM</th>
                        <th>Date</th>
                        <th>Transactions status</th>
                    </tr>
                </thead>
                <tbody id="transactions_body">
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Low Stock Modal -->
<!-- Low Stock Modal -->
<div class="modal fade" id="lowStockModal" tabindex="-1" aria-labelledby="lowStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- Full-width and centered -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lowStockModalLabel">Low Stock Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive"> <!-- Makes table scrollable on small screens -->
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>UoM</th>
                                <th>Price/Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="lowStockTableBody">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $("#lowStock").click(function () {
            $.ajax({
                url: "fetch_low_stock.php",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var tableBody = $("#lowStockTableBody");
                    tableBody.empty();

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

                    $("#lowStockModal").modal("show");
                },
                error: function () {
                    alert("Error fetching data.");
                }
            });
        });
    });
</script>