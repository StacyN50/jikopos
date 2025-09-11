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

// --- Overall Revenue ---
$sqlTotal = "SELECT SUM(m.price) AS revenue
             FROM orders o
             JOIN menu m ON o.menu_id = m.id
             WHERE o.created_at BETWEEN :start AND :end";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute([':start' => $start, ':end' => $end]);
$totalRevenue = $stmtTotal->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS | Reports</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">📊 JikoPOS Reports</h1>

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

    <!-- Total Revenue -->
    <div class="alert alert-success text-center fw-bold">
      Total Revenue (<?= htmlspecialchars($start) ?> → <?= htmlspecialchars($end) ?>):
      Ksh <?= number_format($totalRevenue, 2) ?>
    </div>

    <!-- Sales by Category -->
    <h2 class="mt-4 mb-3">Sales by Category</h2>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Category</th>
          <th>Total Sales (Ksh)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($byCategory as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td><?= number_format($row['total'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Sales by Item -->
    <h2 class="mt-4 mb-3">Sales by Item</h2>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Item</th>
          <th>Quantity Sold</th>
          <th>Total Sales (Ksh)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($byItem as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= $row['qty'] ?></td>
          <td><?= number_format($row['total'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
