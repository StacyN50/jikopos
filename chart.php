<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS - Sales Charts</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>📊 JikoPOS Sales Analytics</header>

<div class="container mt-4">

  <nav class="nav nav-pills nav-justified mb-4">
    <a class="nav-link" href="index.php">🏠 Dashboard</a>
    <a class="nav-link" href="entry.php">➕ New Order</a>
    <a class="nav-link" href="report.php">📑 Reports</a>
    <a class="nav-link active" href="charts.php">📊 Charts</a>
  </nav>

  <div class="row g-4">
    <!-- Daily Sales Chart -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="card-title text-center">Daily Sales</h5>
        <canvas id="dailyChart"></canvas>
      </div>
    </div>

    <!-- Top Categories Chart -->
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="card-title text-center">Top Categories</h5>
        <canvas id="categoryChart"></canvas>
      </div>
    </div>

    <!-- Revenue Trend -->
    <div class="col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-center">Revenue Trend</h5>
        <canvas id="trendChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
<?php
// ---- DAILY SALES (last 7 days) ----
$daily = $pdo->query("
    SELECT DATE(order_date) as day, SUM(total_amount) as total 
    FROM orders 
    GROUP BY DATE(order_date) 
    ORDER BY day DESC 
    LIMIT 7
")->fetchAll(PDO::FETCH_ASSOC);

$days = array_column($daily, 'day');
$totals = array_column($daily, 'total');

// ---- TOP CATEGORIES ----
$categories = $pdo->query("
    SELECT category, SUM(total_amount) as total 
    FROM orders 
    JOIN menu_items ON orders.item_id = menu_items.id
    GROUP BY category 
    ORDER BY total DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$catLabels = array_column($categories, 'category');
$catTotals = array_column($categories, 'total');

// ---- REVENUE TREND (last 12 months) ----
$trend = $pdo->query("
    SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_amount) as total 
    FROM orders 
    GROUP BY month 
    ORDER BY month ASC
")->fetchAll(PDO::FETCH_ASSOC);

$months = array_column($trend, 'month');
$revTotals = array_column($trend, 'total');
?>

// DAILY SALES CHART
new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($days); ?>,
        datasets: [{
            label: 'Sales (KSH)',
            data: <?php echo json_encode($totals); ?>,
            backgroundColor: '#e63946'
        }]
    }
});

// TOP CATEGORIES CHART
new Chart(document.getElementById('categoryChart'), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($catLabels); ?>,
        datasets: [{
            label: 'Revenue Share',
            data: <?php echo json_encode($catTotals); ?>,
            backgroundColor: ['#e63946','#f77f00','#2a9d8f','#264653','#a8dadc']
        }]
    }
});

// REVENUE TREND LINE
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Revenue (KSH)',
            data: <?php echo json_encode($revTotals); ?>,
            fill: true,
            borderColor: '#e63946',
            backgroundColor: 'rgba(230,57,70,0.2)',
            tension: 0.3
        }]
    }
});
</script>

<footer>
  <p>© <?php echo date("Y"); ?> JikoPOS | Smart Restaurant POS</p>
</footer>

</body>
</html>
