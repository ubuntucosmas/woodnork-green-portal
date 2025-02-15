<aside class="sidebar" id="sidebar">
  
  <div class="logo-container">
    <img src="assets/images/logo.png" alt="Company Logo" class="company-logo">
  </div>
  <nav class="nav-menu">
  <ul id="sidebar-menu">
        <?php 
        $role = $_SESSION['role'] ?? ''; 
        ?>

        <?php if ($role === 'store_manager'): ?>
          <li><a href="#" class="nav-link" data-page="pages/store_dashboard.php">
             <img src="assets/images/dashboard.png" > Dashboard
              </a></li>

          <li><a href="#" class="nav-link" data-page="pages/inventory.php">
              <img src= "assets/images/inventory.png"> Manage Inventory
              </a></li>

          <li><a href="#" class="nav-link" data-page="pages/stock_management.php">
            <img src="assets/images/stores.png"> Manage Stock
              </a></li>

          <li><a href="#" class="nav-link" data-page="pages/stock_allocation.php">
          <img src="assets/images/allocate.png"> Stock Allocation
          </a></li>

          <li><a href="#" class="nav-link" data-page="pages/store_report.php">
          <img src="assets/images/report.png"> Reports
          </a></li>


        <?php elseif ($role === 'procurement_officer'): ?>
            <li><a href="#" class="nav-link" data-page="pages/procurement_dash.php">Dashboard</a></li>
            <li><a href="#" class="nav-link" data-page="pages/store_dash.php">Manage Inventory</a></li>
            <li><a href="#" class="nav-link" data-page="pages/order.php">Purchase Orders</a></li>
            <li><a href="#" class="nav-link" data-page="pages/supplier.php">Suppliers</a></li>
            <li><a href="#" class="nav-link" data-page="pages/quote.php">Quotes</a></li>
            <li><a href="#" class="nav-link" data-page="pages/procurement_reports.php">Reports</a></li>

        <?php elseif ($role === 'admin'): ?>
            <li><a href="#" class="nav-link" data-page="pages/admin_dash.php">Dashboard</a></li>
            <li><a href="#" class="nav-link" data-page="pages/add_user.php">Create User</a></li>
            <li><a href="#" class="nav-link" data-page="pages/update_user.php">Update User</a></li>
            <li><a href="#" class="nav-link" data-page="pages/user_list.php">User List</a></li>
        <?php endif; ?>

      <!-- Add more department-specific links -->
    </ul>
  </nav>
</aside>
