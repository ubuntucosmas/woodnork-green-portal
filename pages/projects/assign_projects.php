<div class="container-fluid p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-center fw-normal text-primary">Project Assignment</h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assignProjectModal">Assign Project</button>
    </div>
    
    <div class="mb-3">
        <input type="text" id="searchProject" class="form-control" placeholder="Search by Project or Officer">
    </div>

    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Project Name</th>
                <th>Project Officer</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="assignmentTable">
            <tr>
                <td>Website Redesign</td>
                <td>John Doe</td>
                <td>2025-03-01</td>
                <td>2025-06-01</td>
                <td><span class="badge bg-warning">Ongoing</span></td>
                <td>
                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Mobile App Development</td>
                <td>Jane Smith</td>
                <td>2025-02-15</td>
                <td>2025-07-15</td>
                <td><span class="badge bg-success">Completed</span></td>
                <td>
                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Cloud Migration</td>
                <td>Michael Brown</td>
                <td>2025-03-10</td>
                <td>2025-09-10</td>
                <td><span class="badge bg-warning">Ongoing</span></td>
                <td>
                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Security Audit</td>
                <td>Emily White</td>
                <td>2025-01-20</td>
                <td>2025-04-20</td>
                <td><span class="badge bg-danger">Pending</span></td>
                <td>
                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Data Analysis Project</td>
                <td>Chris Green</td>
                <td>2025-02-01</td>
                <td>2025-05-01</td>
                <td><span class="badge bg-warning">Ongoing</span></td>
                <td>
                    <button class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Assign Project Modal -->
<div class="modal fade" id="assignProjectModal" tabindex="-1" aria-labelledby="assignProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="assignProjectModalLabel" class="mb-0 text-center fw-normal text-primary">Assign Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignProjectForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <select id="projectName" class="form-select" required>
                            <option value="">Select Project</option>
                            <!-- Dynamically populated -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="projectOfficer" class="form-label">Assign to</label>
                        <select id="projectOfficer" class="form-select" required>
                            <option value="">Select Officer</option>
                            <!-- Dynamically populated -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" id="startDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date</label>
                        <input type="date" id="dueDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>