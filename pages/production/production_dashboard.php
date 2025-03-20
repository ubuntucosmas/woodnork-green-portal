<div class="container">
    <h2 class="mb-4 text-primary fw-normal">Production Dashboard</h2>
    
    <!-- KPI Summary Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Incidents</h5>
                    <p class="card-text" id="total-incidents">Loading...</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Resolved Incidents</h5>
                    <p class="card-text" id="resolved-incidents">Loading...</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Incidents</h5>
                    <p class="card-text" id="pending-incidents">Loading...</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Critical Issues</h5>
                    <p class="card-text" id="critical-issues">Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Bar Chart -->
    <div class="col-md-6">
        <canvas id="incidentsChart"></canvas>
    </div>
    <!-- Pie Chart -->
    <div class="col-md-6">
        <canvas id="statusChart"></canvas>
    </div>
</div>

<script>
    // Bar Chart - Incidents per Month
    var ctx1 = document.getElementById('incidentsChart').getContext('2d');
    var incidentsChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Incidents Reported',
                data: [30, 25, 20, 35, 40, 30, 50, 60, 55, 45, 35, 25], // Replace with actual data
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pie Chart - Incident Status Distribution
    var ctx2 = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Resolved', 'Pending', 'Critical'],
            datasets: [{
                data: [90, 25, 5], // Replace with actual data
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<script>
    // Dummy data simulation (Replace with AJAX calls to fetch real data)
    document.getElementById("total-incidents").innerText = 120;
    document.getElementById("resolved-incidents").innerText = 85;
    document.getElementById("pending-incidents").innerText = 30;
    document.getElementById("critical-issues").innerText = 5;
    
</script>
