<div class="container mt-4 m-0">
        <ul class="nav nav-tabs" id="reportTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#stockReport">Stock Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#allocationReport">Allocation Report</a>
            </li>
        </ul>
        
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="stockReport">
                <div class="reports-container">
                    <div class="charts-column">
                        <canvas id="stockChart"></canvas>
                    </div>
                    <div class="data-column">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Date Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laptop</td>
                                    <td>10</td>
                                    <td>2024-02-10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="allocationReport">
                <div class="reports-container">
                    <div class="charts-column">
                        <canvas id="allocationChart"></canvas>
                    </div>
                    <div class="data-column">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity Allocated</th>
                                    <th>Project</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Printer</td>
                                    <td>5</td>
                                    <td>Office Expansion</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
