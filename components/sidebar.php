<aside class="sidebar" id="sidebar">
  <div class="logo-container">
    <img src="assets/images/logo3.png" alt="Company Logo" class="company-logo">
  </div>
  <nav class="nav-menu">
    <ul id="sidebar-menu">
      <?php 
      $role = $_SESSION['role'] ?? ''; 
      ?>

      <?php if ($role === 'store_manager'): ?>
        <li><a href="#" class="nav-link" data-page="pages/stores/store_dashboard.php">
          <i class="bi bi-grid"></i> Dashboard</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/inventory.php">
          <i class="bi bi-box"></i> Manage Inventory</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/stock_management.php">
          <i class="bi bi-clipboard-data"></i> Manage Stock</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/stock_allocation.php">
          <i class="bi bi-box-seam"></i> Stock Allocation</a></li>

        <li><a href="#" class="nav-link" data-page="pages/stores/store_report.php">
          <i class="bi bi-bar-chart-line"></i> Reports</a></li>

      <?php elseif ($role === 'procurement_officer'): ?>
        <li><a href="#" class="nav-link" data-page="pages/procurement_dash.php"><i class="bi bi-grid"></i> Dashboard</a></li>
        <li><a href="#" class="nav-link" data-page="pages/store_dash.php"><i class="bi bi-box"></i> Manage Inventory</a></li>
        <li><a href="#" class="nav-link" data-page="pages/order.php"><i class="bi bi-cart"></i> Purchase Orders</a></li>
        <li><a href="#" class="nav-link" data-page="pages/supplier.php"><i class="bi bi-people"></i> Suppliers</a></li>
        <li><a href="#" class="nav-link" data-page="pages/quote.php"><i class="bi bi-file-earmark-text"></i> Quotes</a></li>
        <li><a href="#" class="nav-link" data-page="pages/procurement_reports.php"><i class="bi bi-bar-chart"></i> Reports</a></li>

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
