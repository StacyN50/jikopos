<?php
require_once __DIR__ . '/db.php';

// Fetch menu items from DB
$stmt = $pdo->query("SELECT id, name, description, price, category, image FROM menu ORDER BY category, name");
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS | Menu</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">🍴 JikoPOS Restaurant Menu</h1>

    <?php
    $currentCat = null;
    foreach ($menuItems as $item):
      if ($currentCat !== $item['category']):
        if ($currentCat !== null) echo "</div>"; // Close previous category row
        $currentCat = $item['category'];
        echo "<h2 class='mt-4 mb-3'>" . htmlspecialchars($currentCat) . "</h2>";
        echo "<div class='row'>";
      endif;
    ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <?php if (!empty($item['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>">
          <?php endif; ?>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
            <p class="card-text text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
            <div class="mt-auto">
              <p class="fw-bold">Ksh <?php echo number_format($item['price'], 2); ?></p>
              <form method="post" action="order.php" class="d-inline">
                <input type="hidden" name="menu_id" value="<?php echo $item['id']; ?>">
                <button type="submit" class="btn btn-success btn-sm">Add to Order</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
