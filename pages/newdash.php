<?php
session_start();

// Dummy role for testing (Replace this with your session logic)
$role = $_SESSION['role'] ?? 'admin'; 

// Define menu items based on roles
$menu_items = [
    'admin' => [
        ['title' => 'Dashboard', 'url' => 'pages/newdash.php', 'icon' => 'home-outline'],
        ['title' => 'User List', 'url' => 'pages/user_list.php', 'icon' => 'people-outline'],
        ['title' => 'Add User', 'url' => 'pages/add_user.php', 'icon' => 'person-add-outline'],
        ['title' => 'Update Users', 'url' => 'pages/update_user.php', 'icon' => 'create-outline'],
        ['title' => 'Settings', 'url' => 'pages/settings.php', 'icon' => 'settings-outline']
    ],
    'store_manager' => [
        ['title' => 'Dashboard', 'url' => 'pages/newdash.php', 'icon' => 'home-outline'],
        ['title' => 'Manage Inventory', 'url' => 'pages/manage_inventory.php', 'icon' => 'cart-outline'],
        ['title' => 'Reports', 'url' => 'pages/reports.php', 'icon' => 'document-text-outline']
    ],
    'procurement_officer' => [
        ['title' => 'Dashboard', 'url' => 'pages/newdash.php', 'icon' => 'home-outline'],
        ['title' => 'Manage Procurement', 'url' => 'pages/manage_procurement.php', 'icon' => 'briefcase-outline'],
        ['title' => 'Manage Inventory', 'url' => 'pages/manage_inventory.php', 'icon' => 'cart-outline']
    ]
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WNG Dashboard</title>
    <link rel="stylesheet" href="assets/css/newdash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="assets/images/logo3.png" class="company-logo">
                        </span>
                        <span class="title">Woodnork Green</span>
                    </a>
                </li>

                <!-- Dynamically Populate Sidebar Menu -->
                <?php
                if (array_key_exists($role, $menu_items)) {
                    foreach ($menu_items[$role] as $item) {
                        echo "
                        <li>
                            <a href='#' class='menu-link' data-page='{$item['url']}'>
                                <span class='icon'><ion-icon name='{$item['icon']}'></ion-icon></span>
                                <span class='title'>{$item['title']}</span>
                            </a>
                        </li>";

                    }
                }
                ?>

                <!-- Sign Out -->
                <li>
                    <a href="logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Header ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="assets/images/logo3.png">
                </div>
            </div>

            <!-- ======================= Main ================== -->
             <div class="main-content">load pages here</div>
        </div>

    <!-- =========== Scripts =========  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>


    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>
