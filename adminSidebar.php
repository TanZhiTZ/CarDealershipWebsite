<?php
include('config/constants.php');

// Check if user is an admin or superadmin
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'super_admin') {
    // Allow access to the page
} else {
    // Redirect to the admin login page if not an admin or superadmin
    header('location: adminLogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Honda Car Dealership &bull; Admin</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/honda-icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel ="stylesheet" href="css/adminPrebookTestdrive.css">
        <script src="js/main.js"></script>
    </head>
    <body>
        <div id="sideHeight" class="flex-shrink-0 p-4 bg-white" style="width: 200px; min-height:100%; float:left;">
        <span class="fs-5 fw-semibold">Admin</span>
        <hr style="border-bottom: 2px solid; border-top: none; margin: 10px 0 10px 0;"/>
        <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
            Home
            </button>
            <div class="collapse show" id="home-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="adminIndex.php" class="link-dark rounded">Prebook</a></li>
                <li><a href="manageUsers.php" class="link-dark rounded">All Users</a></li>
                <li><a href="stockList.php" class="link-dark rounded">Stock List</a></li>
                <li><a href="promotion.php" class="link-dark rounded">Promotion Code</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
            Analytics
            </button>
            <div class="collapse show" id="dashboard-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="soldOverview.php" class="link-dark rounded">Overview</a></li>
                <li><a href="monthlySold.php" class="link-dark rounded">Monthly</a></li>
                <li><a href="allMonthlySold.php" class="link-dark rounded">All Month</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="true">
            Orders
            </button>
            <div class="collapse show" id="orders-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="testdrivelist.php" class="link-dark rounded">Test Drive Bookings</a></li>
                <li><a href="soldHistory.php" class="link-dark rounded">History</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#manage-collapse" aria-expanded="true">
            Manage Cars
            </button>
            <div class="collapse show" id="manage-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="addcar.php" class="link-dark rounded">Add Car</a></li>
                <li><a href="addSpec.php" class="link-dark rounded">Add Spec</a></li>
                <li><a href="editCarPrice.php" class="link-dark rounded">Edit Price</a></li>
                <li><a href="stock.php" class="link-dark rounded">Edit Stock</a></li>
            </ul>
            </div>
        </li>
        <li class="border-top my-3"></li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
            Account
            </button>
            <div class="collapse show" id="account-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="config/adminLogout.php" class="link-dark rounded">Sign out</a></li>
            </ul>
            </div>
        </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>