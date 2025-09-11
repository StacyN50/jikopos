<?php
require_once __DIR__ . '/db.php';

// Handle adding from menu.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {
    $menu_id = intval($_POST['menu_id']);
    $qty = isset($_POST['qty']) ? max(1, intval($_POST['qty'])) : 1;

    // Check if item exists in menu
    $stmt = $pdo->prepare("SELECT id, name, price FROM menu WHERE id = ?");
    $stmt->execute([$menu_id]);
    $menuItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($menuItem) {
        // Check if already ordered
        $check = $pdo->prepare("SELECT id, qty FROM orders WHERE menu_id = ?");
        $check->execute([$menu_id]);
        $existing = $check->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update quantity
            $newQty = $existing['qty'] + $qty;
            $update = $pdo->prepare("UPDATE orders SET qty = ? WHERE id = ?");
            $update->execute([$newQty, $existing['id']]);
        } else {
            // Insert new order item
            $insert = $pdo->prepare("INSERT INTO orders (menu_id, item_name, price, qty) VALUES (?,?,?,?)");
            $insert->execute([$menuItem['id'], $menuItem['name'], $menuItem['price'], $qty]);
        }
    }
    header("Location: orders.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$del_id]);
    header("Location: orders.php");
    exit;
}

// Fetch current orders
$stmt = $pdo->query("SELECT id, item_name, price, qty, (price*qty) AS total FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compute grand total
$grandTotal = 0;
foreach ($orders as $o) {
    $grandTotal += $o['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS | Orders</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">🛒 Current Orders</h1>

    <?php if ($orders): ?>
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price (Ksh)</th>
            <th>Total (Ksh)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
            <tr>
              <td><?php echo htmlspecialchars($o['item_name']); ?></td>
              <td><?php echo $o['qty']; ?></td>
              <td><?php echo number_format($o['price'], 2); ?></td>
              <td><?php echo number_format($o['total'], 2); ?></td>
              <td>
                <a href="?delete=<?php echo $o['id']; ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Remove this item?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="fw-bold">
            <td colspan="3" class="text-end">Grand Total:</td>
            <td colspan="2">Ksh <?php echo number_format($grandTotal, 2); ?></td>
          </tr>
        </tfoot>
      </table>
    <?php else: ?>
      <p class="text-center text-muted">No orders yet. Go back to <a href="menu.php">Menu</a>.</p>
    <?php endif; ?>
  </div>
</body>
</html>
