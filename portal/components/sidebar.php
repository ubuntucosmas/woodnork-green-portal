<aside class="sidebar" id="sidebar">
  
  <div class="logo-container">
    <img src="assets/images/logo.png" alt="Company Logo" class="company-logo">
  </div>
  <nav class="nav-menu">
    <ul>
      
      <?php if ($_SESSION['role'] === 'store_manager'): ?>
      <li><a href="#" data-page="pages/store_dashboard.php">Dashboard</a></>
      <li><a href="#" data-page="pages/store_category.php">Categories</a></>
      <li><a href="#" data-page="pages/inventory.php">Manage Inventory</a></li>
      <li><a href="#" data-page="pages/stock_management.php">Manage Stock</a></>
      <li><a href="#" data-page="pages/allocate.php">Allocation</a></>
      <li><a href="#" data-page="pages/recieve_stock.php">Receve Stock</a></>
      <li><a href="#" data-page="pages/store_report.php">Report</a></>


      <?php elseif ($_SESSION['role'] === 'procurement_officer'): ?>
        <li><a href="#" data-page="pages/procurement_dash.php">Dashboard</a></>
        <li><a href="#" data-page="pages/store_dash.php">Manage Inventory</a></>
        <li><a href="#" data-page="pages/order.php">Purchase Orders</a></>
        <li><a href="#" data-page="pages/supplier.php">Suppliers</a></>
        <li><a href="#" data-page="pages/quote.php">Quotes</a></>
        <li><a href="#" data-page="pages/procurement_reports.php">Reports</a></>

        
      <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <li><a href="#" data-page="pages/admin_dash.php">Dashboard</a></li>
        <li><a href="#" data-page="pages/add_user.php">Create User</a></li>  
        <li><a href="#" data-page="pages/update_user.php">Update User</a></li>
        <li><a href="#" data-page="pages/user_list.php">User List</a></li>
            
      <?php endif; ?>

      <!-- Add more department-specific links -->
    </ul>
  </nav>
</aside>
