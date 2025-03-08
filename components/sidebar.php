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

<style>
  body {
    font-family: 'Poppins', sans-serif;
  }
  .sidebar {
    width: 250px;
    height: 100vh;
    background: linear-gradient(to bottom, #2e3b4e, #145da0);
    box-shadow: 3px 0 10px rgba(0, 0, 0, 0.3);
    padding: 20px;
    color: white;
    position: fixed;
    transition: 0.3s ease-in-out;
  }
  .logo-container {
    text-align: center;
    margin-bottom: 20px;
  }
  .company-logo {
    width: 100px;
    border-radius: 50%;
  }
  .nav-menu ul {
    list-style: none;
    padding: 0;
  }
  .nav-menu li {
    margin: 10px 0;
  }
  .nav-menu a {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 10px;
    transition: background 0.3s, transform 0.2s;
  }
  .nav-menu a i {
    font-size: 18px;
    margin-right: 10px;
    transition: color 0.3s;
  }
  .nav-menu a:hover {
    background: rgba(0, 255, 255, 0.2);
    transform: scale(1.05);
  }
  .nav-menu a:hover i {
    color: cyan;
  }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
