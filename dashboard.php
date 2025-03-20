<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get role and department from session
$department = $_SESSION['department'] ?? 'General';
$role = $_SESSION['role'] ?? 'User';

// Define default landing pages for roles
$roleDefaultPages = [
    'admin' => 'admin_dash.php',
    'procurement' => 'procurement_dash.php',
    'store' => 'stores/stock_dash.php' // Store department default
];

// Set the default page based on the role
$defaultPage = $roleDefaultPages[$role] ?? 'pages/stores/store_dashboard.php';

// Sanitize and validate requested page
$page = $_GET['page'] ?? $defaultPage;

// Prevent directory traversal attacks
$page = str_replace(array("../", "..\\"), "", $page);

// Allow only valid department pages
$allowedDepartments = ['stores', 'procurement', 'finance', 'admin'];
$pathParts = explode("/", $page);
$folder = $pathParts[0] ?? ''; // Department
$file = $pathParts[1] ?? ''; // Requested file

if (in_array($folder, $allowedDepartments) && file_exists("pages/$folder/$file.php")) {
    $_SESSION['last_page'] = "$folder/$file.php"; // Store last visited page
} else {
    $_SESSION['last_page'] = $defaultPage; // Reset to default if invalid
}

$pageToLoad = $_SESSION['last_page'];

// Ensure the requested page exists before including it
$moduleFile = "modules/" . strtolower($department) . "_module.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Full jQuery version (supports AJAX) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/dispatch.css">
  <link rel="stylesheet" href="assets/css/stores.css">
  <link rel="stylesheet" href="assets/css/report.css">
  <link rel="stylesheet" href="assets/css/inventory.css">
  <link rel="stylesheet" href="assets/css/stock-allocation.css">
  <link rel="stylesheet" href="assets/css/stock-management.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  


  
<!-- style for store dash preview -->
  <style>
        .store-stats {
            display: flex;
            gap: 20px;
        }
        .stat-box {
            flex: 1;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            transition: 0.3s;
        }
        .stat-box:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<div class="dashboard">
  <!-- Sidebar -->
  <?php include('components/sidebar.php'); ?>

  <!-- Main Content -->
  <div class="content">
    <?php include('components/header.php'); ?>

    <div class="dashboard-main">
      <?php
      if (file_exists("pages/$pageToLoad")) {
          include "pages/$pageToLoad";
      } elseif (file_exists($moduleFile)) {
          include $moduleFile;
      } else {
          echo "<h3>Page not found!</h3>";
          include "pages/$defaultPage";
      }
      ?>
    </div>
  </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



<script src="assets/js/stock-allocation.js" ></script>
<script src="assets/js/dispatches.js" defer></script>
<script src="assets/js/script.js" defer></script>
<script src="assets/js/store.js" defer></script>
<script src="assets/js/inventory.js" defer></script>
<script src="assets/js/stock-management.js" defer></script>

</body>
</html>
