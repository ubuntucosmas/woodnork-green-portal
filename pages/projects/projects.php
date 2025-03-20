<div class="container-fluid mt-3">
  <!-- Add Project Button -->
  <div class="d-flex justify-content-center align-items-center mb-3">
    <h3 class="mb-0 text-center fw-normal text-primary">Projects (Matrix)</h3>
  </div>
  <div class="d-flex justify-content align-items-center mb-3">
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
      <i class="bi bi-plus-circle"></i> Add Project
    </button>
  </div>

  <!-- Projects Table -->
  <div class="table-responsive" style="max-width: 100%; overflow-x: auto; white-space: nowrap;">
    <table class="table table-bordered table-hover table-striped align-middle">
      <thead class="table-dark"> <!-- Slim Font -->
        <tr>
          <th scope="col">Event Name</th>
          <th scope="col">Client</th>
          <th scope="col">Project Deliverables</th>
          <th scope="col">Set-Up Date</th>
          <th scope="col">Venue</th>
          <th scope="col">Event Date</th>
          <th scope="col">Set-Down Date</th>
          <th scope="col">Project Officer</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody id="projectTableBody"> <!-- Slim Font -->
        <tr>
          <td>Annual Gala Night</td>
          <td>ABC Corp</td>
          <td>Stage Design, Lighting, Sound System</td>
          <td>2025-03-18</td>
          <td>Grand Ballroom, Hilton</td>
          <td>2025-03-20</td>
          <td>2025-03-21</td>
          <td>John Doe</td>
          <td>In Progress</td>
        </tr>
        <tr>
          <td>Charity Concert</td>
          <td>Hope Foundation</td>
          <td style="white-space: normal; word-break: break-word; max-width: 300px;"> 
            - Fabrication of a Lit 3D outdoor signage L 5.8m by H 1.2m built from coloured 
            perpsex materials and illuminated with LED modules
            - Non-lit 2D reception signage L 2m by H 0.89m built from a combination of 
            coloured perspex, celluca & alluco and illuminated with Warm white spotlights 
            with rail
            - Fabrication of parking lot signages 45cm by 15cm, non-lit, built from perspex 
            materials
            - County council 4 days work permit
          </td>
          <td>2025-04-05</td>
          <td>City Park</td>
          <td>2025-04-07</td>
          <td>2025-04-08</td>
          <td>Jane Smith</td>
          <td>Pending</td>
        </tr>
        <tr>
          <td>Product Launch</td>
          <td>Tech Solutions</td>
          <td>Custom Stage, Screens, Lighting</td>
          <td>2025-03-28</td>
          <td>Expo Hall, Convention Center</td>
          <td>2025-03-30</td>
          <td>2025-03-31</td>
          <td>Mary Johnson</td>
          <td>Completed</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal for Adding Project -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-normal text-primary" id="addProjectModalLabel">Add New Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addProjectForm">
          
          <!-- Top Section: Two Columns -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="eventName" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="eventName" required>
              </div>
              <div class="mb-3">
                <label for="clientName" class="form-label">Client</label>
                <input type="text" class="form-control" id="clientName" required>
              </div>
              <div class="mb-3">
                <label for="setupDate" class="form-label">Set-Up Date</label>
                <input type="date" class="form-control" id="setupDate" required>
              </div>
              <div class="mb-3">
                <label for="venue" class="form-label">Venue</label>
                <input type="text" class="form-control" id="venue" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="eventDate" class="form-label ">Event Date</label>
                <input type="date" class="form-control" id="eventDate" required>
              </div>
              <div class="mb-3">
                <label for="setdownDate" class="form-label ">Set-Down Date</label>
                <input type="date" class="form-control" id="setdownDate" required>
              </div>
              <div class="mb-3">
                <label for="projectOfficer" class="form-label ">Project Officer</label>
                <input type="text" class="form-control" id="projectOfficer" required>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label ">Status</label>
                <select class="form-select" id="status" required>
                  <option value="Pending">Pending</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Completed">Completed</option>
                  <option value="In-coming">In Coming</option>
                  <option value="Rejected">Rejected</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Middle Section: Full Width Project Deliverables -->
          <div class="mb-3">
            <label for="projectDeliverables" class="form-label">Project Deliverables</label>
            <textarea class="form-control" id="projectDeliverables" rows="4" required></textarea>
          </div>

          <!-- Bottom Section: Buttons -->
          <div class="modal-footer">
            
            <button type="submit" class="btn btn-outline-primary w-100">Save Project</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
