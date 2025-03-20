<div class="container py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary fw-normal">Technician Management</h3>
        <div>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTechnicianModal">
                <i class="fas fa-user-plus"></i> Add Technician
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-4">
            <select class="form-control" id="filterProject">
                <option value="">Filter by Project</option>
                <option value="Project A">Project A</option>
                <option value="Project B">Project B</option>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" id="filterStatus">
                <option value="">Filter by Status</option>
                <option value="available">Available</option>
                <option value="assigned">Assigned</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchTechnician" placeholder="Search Technician...">
        </div>
    </div>

    <!-- Technician Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="technicianTableBody">
                <tr data-id="1">
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Electrical</td>
                    <td>Project A</td>
                    <td><span class="badge bg-success">Available</span></td>
                    <td>
                        <button class="btn btn-outline-info btn-sm edit-btn"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr data-id="2">
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>Mechanical</td>
                    <td>Project B</td>
                    <td><span class="badge bg-danger">Assigned</span></td>
                    <td>
                        <button class="btn btn-outline-info btn-sm edit-btn"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


<!-- Add Technician Modal -->
<div class="modal fade" id="addTechnicianModal" tabindex="-1" aria-labelledby="addTechnicianLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary fw-normal" id="addTechnicianLabel">Add Technician</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="technicianForm">
                    <div class="mb-3">
                        <label for="technicianName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="technicianName" required>
                    </div>
                    <div class="mb-3">
                        <label for="technicianSpecialization" class="form-label">Specialization</label>
                        <select class="form-select" id="technicianSpecialization" required>
                            <option value="">Select Specialization</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="IT">IT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="technicianProject" class="form-label">Project</label>
                        <select class="form-select" id="technicianProject" required>
                            <option value="">Select Project</option>
                            <option value="Project A">Project A</option>
                            <option value="Project B">Project B</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="technicianToDelete"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
</div>
 <!-- Assignments Table -->
 <div class="container py-3">
 <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
        <h4 class="text-primary fw-normal">Technician Assignments</h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assignTechnicianModal">
            <i class="fas fa-tasks"></i> Assign Technician
        </button>
    </div>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Assignment ID</th>
                    <th>Technician Name</th>
                    <th>Project</th>
                    <th>Assignment Date</th>
                    <th>Duration (Days)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Project A</td>
                    <td>2025-03-15</td>
                    <td>10</td>
                    <td>
                        <button class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-outline-secondary mt-2" id="exportPDF">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    


<!-- Assign Technician Modal -->
<div class="modal fade" id="assignTechnicianModal" tabindex="-1" aria-labelledby="assignTechnicianLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary fw-normal" id="assignTechnicianLabel">Assign Technician</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="assignmentForm">
          <div class="mb-3">
            <label for="assignmentProject" class="form-label">Project</label>
            <select class="form-select" id="assignmentProject" required>
              <option value="">Select Project</option>
              <option value="Project A">Project A</option>
              <option value="Project B">Project B</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="assignmentTechnician" class="form-label">Technician</label>
            <select class="form-select" id="assignmentTechnician" required>
              <option value="">Select Technician</option>
              <option value="John Doe">John Doe</option>
              <option value="Jane Smith">Jane Smith</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="assignmentDate" class="form-label">Assignment Date</label>
            <input type="date" class="form-control" id="assignmentDate" required>
          </div>
          <div class="mb-3">
            <label for="assignmentDays" class="form-label">Number of Days</label>
            <input type="number" class="form-control" id="assignmentDays" min="1" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-primary">Assign</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<script>
document.getElementById('technicianForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Technician added successfully!');
    this.reset();
    var modal = bootstrap.Modal.getInstance(document.getElementById('addTechnicianModal'));
    modal.hide();
});

// Handle Delete Action
let deleteId = null;

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const row = this.closest('tr');
        deleteId = row.getAttribute('data-id');
        const name = row.children[1].textContent;
        document.getElementById('technicianToDelete').textContent = name;
    });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        const rowToDelete = document.querySelector(`tr[data-id="${deleteId}"]`);
        rowToDelete.remove();
        deleteId = null;
        bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
    }
});

// Handle Edit Action
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        alert('Edit functionality will be implemented.');
    });
});
</script>
