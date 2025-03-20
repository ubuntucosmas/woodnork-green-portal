<div class="container mt-3">
  <!-- Add Project Officer Button -->
  <div class="d-flex justify-content-center align-items-center mb-3">
    <h3 class="mb-0 text-center text-primary fw-normal">Project Officers</h3>
  </div>
  <div class="d-flex justify-content align-items-center mb-3">
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPOModal">
      <i class="bi bi-plus-circle"></i> Add Project Officer
    </button>
  </div>

  <!-- Project Officers Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th scope="col">Full Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Department</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody id="poTableBody">
        <tr>
          <td>John Doe</td>
          <td>johndoe@example.com</td>
          <td>+123 456 7890</td>
          <td>Events Management</td>
          <td>Active</td>
        </tr>
        <tr>
          <td>Jane Smith</td>
          <td>janesmith@example.com</td>
          <td>+987 654 3210</td>
          <td>Logistics</td>
          <td>Inactive</td>
        </tr>
        <tr>
          <td>Mark Johnson</td>
          <td>markjohnson@example.com</td>
          <td>+111 222 3333</td>
          <td>Operations</td>
          <td>Active</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal for Adding Project Officer -->
<div class="modal fade" id="addPOModal" tabindex="-1" aria-labelledby="addPOModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-normal text-primary" id="addPOModalLabel">Add Project Officer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addPOForm">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="poName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="poName" required>
              </div>
              <div class="mb-3">
                <label for="poEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="poEmail" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="poPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="poPhone" required>
              </div>
              <div class="mb-3">
                <label for="poDepartment" class="form-label">Department</label>
                <input type="text" class="form-control" id="poDepartment" required>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="poStatus" class="form-label">Status</label>
            <select class="form-select" id="poStatus" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

          <div class="modal-footer">
           
            <button type="submit" class="btn btn-outline-primary w-100">Save Project Officer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
