<?php
require_once __DIR__ . '/db.php';

// Default date range (this month)
$start = $_GET['start'] ?? date('Y-m-01');
$end   = $_GET['end']   ?? date('Y-m-t');

// --- Sales by Category ---
$sqlCat = "SELECT m.category, SUM(m.price) AS total
           FROM orders o
           JOIN menu m ON o.menu_id = m.id
           WHERE o.created_at BETWEEN :start AND :end
           GROUP BY m.category
           ORDER BY total DESC";
$stmtCat = $pdo->prepare($sqlCat);
$stmtCat->execute([':start' => $start, ':end' => $end]);
$byCategory = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// --- Sales by Item ---
$sqlItem = "SELECT m.name, COUNT(*) AS qty, SUM(m.price) AS total
            FROM orders o
            JOIN menu m ON o.menu_id = m.id
            WHERE o.created_at BETWEEN :start AND :end
            GROUP BY m.id, m.name
            ORDER BY total DESC";
$stmtItem = $pdo->prepare($sqlItem);
$stmtItem->execute([':start' => $start, ':end' => $end]);
$byItem = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

// --- Revenue by Day ---
$sqlTrend = "SELECT DATE(o.created_at) AS day, SUM(m.price) AS revenue
             FROM orders o
             JOIN menu m ON o.menu_id = m.id
             WHERE o.created_at BETWEEN :start AND :end
             GROUP BY DATE(o.created_at)
             ORDER BY day ASC";
$stmtTrend = $pdo->prepare($sqlTrend);
$stmtTrend->execute([':start' => $start, ':end' => $end]);
$trend = $stmtTrend->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS | Charts</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">📈 JikoPOS Charts</h1>

    <!-- Date Filter -->
    <form method="get" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Start Date</label>
        <input type="date" name="start" value="<?= htmlspecialchars($start) ?>" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">End Date</label>
        <input type="date" name="end" value="<?= htmlspecialchars($end) ?>" class="form-control">
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
      </div>
    </form>

    <!-- Sales by Category -->
    <h2 class="mt-4 mb-3">Sales by Category</h2>
    <canvas id="catChart" height="120"></canvas>

    <!-- Sales by Item -->
    <h2 class="mt-4 mb-3">Top Selling Items</h2>
    <canvas id="itemChart" height="120"></canvas>

    <!-- Revenue Trend -->
    <h2 class="mt-4 mb-3">Revenue Trend</h2>
    <canvas id="trendChart" height="120"></canvas>
  </div>

  <script>
    // Sales by Category
    new Chart(document.getElementById('catChart'), {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_column($byCategory, 'category')) ?>,
        datasets: [{
          data: <?= json_encode(array_column($byCategory, 'total')) ?>,
          backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545','#17a2b8','#6f42c1']
        }]
      }
    });

    // Sales by Item
    new Chart(document.getElementById('itemChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($byItem, 'name')) ?>,
        datasets: [{
          label: 'Total Sales (Ksh)',
          data: <?= json_encode(array_column($byItem, 'total')) ?>,
          backgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Revenue Trend
    new Chart(document.getElementById('trendChart'), {
      type: 'line',
      data: {
        labels: <?= json_encode(array_column($trend, 'day')) ?>,
        datasets: [{
          label: 'Revenue (Ksh)',
          data: <?= json_encode(array_column($trend, 'revenue')) ?>,
          borderColor: '#28a745',
          backgroundColor: 'rgba(40,167,69,0.2)',
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
