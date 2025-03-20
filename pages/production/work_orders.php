<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-primary fw-normal">Work Orders</h2>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#workOrderModal">Add Work Order</button>
        </div>
        
        <!-- Filters -->
        <div class="row mt-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search Work Orders">
            </div>
            <div class="col-md-4">
                <select class="form-control">
                    <option value="">Filter by Status</option>
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control">
            </div>
        </div>

        <!-- Work Orders Table -->
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Work Order ID</th>
                        <th>Project Name</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>WO001</td>
                        <td>Project Alpha</td>
                        <td>John Doe</td>
                        <td>2025-03-20</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <button class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                            <button class="btn btn-outline-primary btn-sm work-order-btn" data-bs-toggle="modal" data-bs-target="#pdfModal" data-id="WO001">View Order</button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

    <!-- Work Order Modal -->
    <div class="modal fade" id="workOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-normal ">Add Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label>Work Order Title</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Assigned To</label>
                            <select class="form-control">
                                <option>John Doe</option>
                                <option>Jane Smith</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Priority</label>
                            <select class="form-control">
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Start Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Due Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-control">
                                <option>Pending</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary">Save Work Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- work order Preview Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Work Order Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" src="" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.view-order-btn').forEach(button => {
            button.addEventListener('click', function() {
                let workOrderId = this.getAttribute('data-id');
                document.getElementById('pdfFrame').src = 'generate_pdf.php?id=' + workOrderId;
            });
        });
        document.querySelectorAll('.work-order-btn').forEach(button => {
    button.addEventListener('click', function () {
        let workOrderId = this.getAttribute('data-id');
        document.getElementById('pdfFrame').src = 'generate_pdf.php?id=' + workOrderId;
    });
});
async function fetchWorkOrders() {
    const response = await fetch('api/work_orders.php');
    const data = await response.json();

    let tableBody = document.getElementById('workOrderTableBody');
    tableBody.innerHTML = '';

    data.forEach(order => {
        tableBody.innerHTML += `
            <tr>
                <td>${order.work_order_id}</td>
                <td>${order.project_name}</td>
                <td>${order.assigned_to}</td>
                <td>${order.due_date}</td>
                <td><span class="badge bg-${order.status === 'Completed' ? 'success' : order.status === 'Pending' ? 'warning' : 'primary'}">${order.status}</span></td>
                <td>
                    <button class="btn btn-outline-primary btn-sm work-order-btn" data-bs-toggle="modal" data-bs-target="#pdfModal" data-id="${order.work_order_id}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm edit-btn" data-id="${order.work_order_id}">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="${order.work_order_id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

// Load work orders on page load
document.addEventListener('DOMContentLoaded', fetchWorkOrders);

    </script>
</body>
</html>
