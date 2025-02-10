<?php
session_start();
$department = $_SESSION['department'] ?? 'General';
$role = $_SESSION['role'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/stores.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
      $moduleFile = 'modules/' . strtolower($department) . '_module.php';
      if (file_exists($moduleFile)) {
          include($moduleFile);
      } else {
          echo '<p>These features are not available at the moment please contact the I.T. Department for further information.</p>';
      }
      ?>
    </div>
  </div>
</div>

<script src="assets/js/script.js"></script>
<script src="assets/js/store.js"></script>
</body>
</html>
