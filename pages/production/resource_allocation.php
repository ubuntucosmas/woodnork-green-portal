<div class="container py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary fw-normal">Resource Allocation</h3>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#allocateResourceModal">
            <i class="fas fa-toolbox"></i> Allocate Resource
        </button>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterProject" class="form-label">Filter by Project</label>
            <select id="filterProject" class="form-select">
                <option value="">All Projects</option>
                <option>Project A</option>
                <option>Project B</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filterTechnician" class="form-label">Filter by Technician</label>
            <select id="filterTechnician" class="form-select">
                <option value="">All Technicians</option>
                <option>John Doe</option>
                <option>Jane Smith</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filterStatus" class="form-label">Filter by Status</label>
            <select id="filterStatus" class="form-select">
                <option value="">All Status</option>
                <option>Allocated</option>
                <option>In Use</option>
                <option>Returned</option>
                <option>Damaged</option>
            </select>
        </div>
    </div>

    <!-- Resource Allocation Table -->
    <h4 class="mt-4 text-primary fw-normal">Allocated Resources</h4>
    <button class="btn btn-outline-secondary mb-2 float-end" id="exportPDF">
        <i class="fas fa-file-pdf"></i> Export PDF
    </button>

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Project</th>
                <th>Equipment</th>
                <th>Technician</th>
                <th>Quantity</th>
                <th>Allocation Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="allocationTableBody">
            <tr>
                <td>1</td>
                <td>Project A</td>
                <td>Laptop</td>
                <td>John Doe</td>
                <td>2</td>
                <td>2025-03-15</td>
                <td>2025-03-30</td>
                <td>
                    <select class="form-select status-dropdown">
                        <option selected>Allocated</option>
                        <option>In Use</option>
                        <option>Returned</option>
                        <option>Damaged</option>
                    </select>
                </td>
                <td>
                <button class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></button>
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Project B</td>
                <td>Drill Machine</td>
                <td>Jane Smith</td>
                <td>1</td>
                <td>2025-03-10</td>
                <td>2025-03-25</td>
                <td>
                    <select class="form-select status-dropdown">
                        <option selected>In Use</option>
                        <option>Allocated</option>
                        <option>Returned</option>
                        <option>Damaged</option>
                    </select>
                </td>
                <td>
                <button class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></button>
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Resource Allocation Modal -->
<div class="modal fade" id="allocateResourceModal" tabindex="-1" aria-labelledby="allocateResourceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-normal" id="allocateResourceLabel">Allocate Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="allocateResourceForm">
                    <div class="mb-3">
                        <label for="project" class="form-label">Project</label>
                        <select class="form-select" id="project" required>
                            <option selected disabled>Select a project</option>
                            <option>Project A</option>
                            <option>Project B</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="equipment" class="form-label">Equipment</label>
                        <select class="form-select" id="equipment" required>
                            <option selected disabled>Select equipment</option>
                            <option>Laptop</option>
                            <option>Drill Machine</option>
                            <option>Welding Set</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="technician" class="form-label">Technician</label>
                        <select class="form-select" id="technician" required>
                            <option selected disabled>Select a technician</option>
                            <option>John Doe</option>
                            <option>Jane Smith</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="allocationDate" class="form-label">Allocation Date</label>
                        <input type="date" class="form-control" id="allocationDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="returnDate" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="returnDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status">
                            <option>Allocated</option>
                            <option>In Use</option>
                            <option>Returned</option>
                            <option>Damaged</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">Allocate</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Filter Functionality
    const filterProject = document.getElementById("filterProject");
    const filterTechnician = document.getElementById("filterTechnician");
    const filterStatus = document.getElementById("filterStatus");
    const tableRows = document.querySelectorAll("#allocationTableBody tr");

    function applyFilters() {
        const projectFilter = filterProject.value.toLowerCase();
        const technicianFilter = filterTechnician.value.toLowerCase();
        const statusFilter = filterStatus.value.toLowerCase();

        tableRows.forEach(row => {
            const project = row.cells[1].textContent.toLowerCase();
            const technician = row.cells[3].textContent.toLowerCase();
            const status = row.cells[7].querySelector("select").value.toLowerCase();

            if (
                (projectFilter === "" || project.includes(projectFilter)) &&
                (technicianFilter === "" || technician.includes(technicianFilter)) &&
                (statusFilter === "" || status.includes(statusFilter))
            ) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    filterProject.addEventListener("change", applyFilters);
    filterTechnician.addEventListener("change", applyFilters);
    filterStatus.addEventListener("change", applyFilters);

    // Dynamic Status Update
    document.querySelectorAll(".status-dropdown").forEach(select => {
        select.addEventListener("change", function () {
            alert(`Status updated to: ${this.value}`);
        });
    });

    // PDF Export Placeholder
    document.getElementById("exportPDF").addEventListener("click", function() {
        alert("PDF export will be implemented later.");
    });
});
</script>
