<aside class="sidebar" id="sidebar">
  <div class="logo-container">
    <img src="assets/images/logo3.png" alt="Company Logo" class="company-logo">
    <h5 style="margin-left: 15px;">Woodnork Green</h5>
 </div>

  <hr style="border: 1px solidrgb(215, 220, 224); margin-bottom: 30px;">

  <nav class="nav-menu:">
    <ul id="sidebar-menu">
      <?php 
      $role = $_SESSION['role'] ?? ''; 
      ?>

      <?php if ($role === 'store_manager'): ?>
        <li><a href="#" class="nav-link" data-page="pages/stores/store_dashboard.php">
          <i class="bi bi-grid" style="margin-right: 10px;"></i> Dashboard</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/inventory.php">
          <i class="bi bi-box" style="margin-right: 10px;"></i> Manage Inventory</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/stock_management.php">
          <i class="bi bi-clipboard-data" style="margin-right: 10px;"></i> Manage Stock</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/stock_allocation.php">
          <i class="bi bi-box-seam" style="margin-right: 10px;"></i> Stock Allocation</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/store_report.php">
          <i class="bi bi-bar-chart-line" style="margin-right: 10px;"></i> Reports</a></li>

      <?php elseif ($role === 'procurement_officer'): ?>
        <li><a href="#" class="nav-link" data-page="pages/procurement_dash.php"><i class="bi bi-grid"></i> Dashboard</a></li>
        <li><a href="#" class="nav-link" data-page="pages/store_dash.php"><i class="bi bi-box"></i> Manage Inventory</a></li>
        <li><a href="#" class="nav-link" data-page="pages/order.php"><i class="bi bi-cart"></i> Purchase Orders</a></li>
        <li><a href="#" class="nav-link" data-page="pages/supplier.php"><i class="bi bi-people"></i> Suppliers</a></li>
        <li><a href="#" class="nav-link" data-page="pages/quote.php"><i class="bi bi-file-earmark-text"></i> Quotes</a></li>
        <li><a href="#" class="nav-link" data-page="pages/procurement_reports.php"><i class="bi bi-bar-chart"></i> Reports</a></li>
      
        <?php elseif ($role === 'Production_officer'): ?>
    <li><a href="#" class="nav-link" data-page="pages/production/production_dashboard.php">
      <i class="bi bi-grid" style="margin-right: 10px;"></i> Dashboard</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/work_orders.php">
      <i class="bi bi-clipboard-check" style="margin-right: 10px;"></i> Work Orders</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/technician.php">
      <i class="bi bi-person-gear" style="margin-right: 10px;"></i> Technician Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/resource_allocation.php">
      <i class="bi bi-tools" style="margin-right: 10px;"></i> Resource Allocation</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/track_production.php">
      <i class="bi bi-arrow-repeat" style="margin-right: 10px;"></i> Production Tracking</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/quality.php">
      <i class="bi bi-check-circle" style="margin-right: 10px;"></i> Quality Control</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/incident.php">
      <i class="bi bi-exclamation-triangle" style="margin-right: 10px;"></i> Incident Tracking</a></li>

    <li><a href="#" class="nav-link" data-page="pages/production/prod_report.php">
      <i class="bi bi-graph-up" style="margin-right: 10px;"></i> Reporting & Analytics</a></li>

      <?php elseif ($role === 'logistics_officer'): ?>
    <li><a href="#" class="nav-link" data-page="pages/logistics/logistics_dashboard.php">
      <i class="bi bi-grid" style="margin-right: 10px;"></i> Dashboard</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/shipment_management.php">
      <i class="bi bi-box-seam" style="margin-right: 10px;"></i> Shipment Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/fleet_management.php">
      <i class="bi bi-truck" style="margin-right: 10px;"></i> Fleet Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/route_management.php">
      <i class="bi bi-map" style="margin-right: 10px;"></i> Route Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/staff_management.php">
      <i class="bi bi-people" style="margin-right: 10px;"></i> Staff Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/deliveries_dispatch.php">
      <i class="bi bi-send" style="margin-right: 10px;"></i> Deliveries & Dispatch</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/document_management.php">
      <i class="bi bi-folder2-open" style="margin-right: 10px;"></i> Document Management</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/incident_tracking.php">
      <i class="bi bi-exclamation-triangle" style="margin-right: 10px;"></i> Incident Tracking</a></li>

    <li><a href="#" class="nav-link" data-page="pages/logistics/logistics_reports.php">
      <i class="bi bi-graph-up" style="margin-right: 10px;"></i> Reports</a></li>

      <?php elseif ($role === 'project_manager'): ?>
    <li><a href="#" class="nav-link" data-page="pages/projects/project_dashboard.php">
      <i class="bi bi-grid" style="margin-right: 10px;"></i> Dashboard</a></li>

    <li><a href="#" class="nav-link" data-page="pages/projects/projects.php">
      <i class="bi bi-kanban" style="margin-right: 10px;"></i> Projects</a></li>

    <li><a href="#" class="nav-link" data-page="pages/projects/project_officers.php">
      <i class="bi bi-person-gear" style="margin-right: 10px;"></i> Project Officers</a></li>

    <li><a href="#" class="nav-link" data-page="pages/projects/assign_projects.php">
      <i class="bi bi-clipboard-check" style="margin-right: 10px;"></i> Assign Projects</a></li>
        

      <?php elseif ($role === 'admin'): ?>
        <li><a href="#" class="nav-link" data-page="pages/admin_dash.php"><i class="bi bi-grid"></i> Dashboard</a></li>
        <li><a href="#" class="nav-link" data-page="pages/add_user.php"><i class="bi bi-person-plus"></i> Create User</a></li>
        <li><a href="#" class="nav-link" data-page="pages/update_user.php"><i class="bi bi-pencil-square"></i> Update User</a></li>
        <li><a href="#" class="nav-link" data-page="pages/user_list.php"><i class="bi bi-people"></i> User List</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</aside>


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
