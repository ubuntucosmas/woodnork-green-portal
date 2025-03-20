<!-- Incident Tracking Module -->
<div class="container py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 text-primary fw-normal">Incident Tracking</h3>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addIncidentModal">
            <i class="fas fa-plus-circle"></i> Add Incident
        </button>
    </div>
    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Search by project...">
        </div>
        <div class="col-md-3">
            <select class="form-control">
                <option value="">Filter by Reporter</option>
                <option value="John Doe">John Doe</option>
                <option value="Jane Smith">Jane Smith</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control">
                <option value="">Filter by Status</option>
                <option value="Open">Open</option>
                <option value="Resolved">Resolved</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-secondary w-100"><i class="fas fa-filter"></i> Apply Filters</button>
        </div>
    </div>

    <!-- Incident Table -->
    
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Project</th>
                    <th>Reported By</th>
                    <th>Incident Details</th>
                    <th>Date Reported</th>
                    <th>Severity</th>
                    <th>Actions Taken</th>
                    <th>Status</th>
                    <th>Resolution Date</th>
                    <th>Attachments</th>
                    <th>Export</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Project X</td>
                    <td>John Doe</td>
                    <td>Power failure at the site</td>
                    <td>2025-03-18</td>
                    <td><span class="badge bg-danger">High</span></td>
                    <td>Replaced faulty breaker</td>
                    <td>
                        <select class="form-select form-select-sm">
                            <option value="Open">Open</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </td>
                    <td>2025-03-19</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-info"><i class="fas fa-image"></i></a>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary export-single" data-id="1">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="btn btn-outline-secondary mt-2" id="exportPDF">
        <i class="fas fa-file-pdf"></i> Export All
    </button>
</div>

<!-- Add Incident Modal -->
<div class="modal fade" id="addIncidentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-normal">Add New Incident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reported By</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incident Details</label>
                        <textarea class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Severity</label>
                        <select class="form-select">
                            <option>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Reported</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Actions Taken</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Resolved</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachments</label>
                        <input type="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">Save Incident</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Export -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".export-single").forEach(button => {
        button.addEventListener("click", function () {
            const incidentId = this.getAttribute("data-id");
            window.open(`export_incident.php?id=${incidentId}`, "_blank");
        });
    });

    document.getElementById("exportPDF").addEventListener("click", function () {
        window.open("export_all_incidents.php", "_blank");
    });
});
</script>
