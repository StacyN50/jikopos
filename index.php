<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JikoPOS - Restaurant Management</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center mb-4">🍽️ JikoPOS - Restaurant POS</h1>
    <nav class="nav nav-pills nav-justified mb-4">
        <a class="nav-link" href="menu.php">📋 Menu</a>
        <a class="nav-link" href="orders.php">🛒 Orders</a>
        <a class="nav-link" href="report.php">📊 Reports</a>
        <a class="nav-link" href="charts.php">📈 Charts</a>
        <a class="nav-link" href="import.php">⬆️ Import</a>
        <a class="nav-link" href="export.php">⬇️ Export</a>
    </nav>
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Menu</h4>
                    <p class="card-text">Manage food & drinks offered.</p>
                    <a href="menu.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Orders</h4>
                    <p class="card-text">Take new orders & manage bills.</p>
                    <a href="orders.php" class="btn btn-success">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Reports</h4>
                    <p class="card-text">View sales & performance.</p>
                    <a href="report.php" class="btn btn-warning">Go</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Charts</h4>
                    <p class="card-text">Visualize sales trends & categories.</p>
                    <a href="charts.php" class="btn btn-info">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Import / Export</h4>
                    <p class="card-text">Backup or restore menu & sales.</p>
                    <a href="import.php" class="btn btn-dark me-2">Import</a>
                    <a href="export.php" class="btn btn-dark">Export</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
