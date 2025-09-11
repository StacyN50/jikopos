<?php
require_once __DIR__ . '/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== false) {
        $header = fgetcsv($handle); // skip header row

        $pdo->beginTransaction();
        while (($row = fgetcsv($handle)) !== false) {
            [$id, $name, $category, $price] = $row;

            // Insert or update if exists
            $stmt = $pdo->prepare("INSERT INTO menu (id, name, category, price)
                                   VALUES (:id, :name, :category, :price)
                                   ON DUPLICATE KEY UPDATE 
                                   name=VALUES(name), category=VALUES(category), price=VALUES(price)");
            $stmt->execute([
                ':id' => $id ?: null,
                ':name' => $name,
                ':category' => $category,
                ':price' => $price
            ]);
        }
        $pdo->commit();
        fclose($handle);
        $message = "✅ Menu imported successfully!";
    } else {
        $message = "❌ Failed to read CSV file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JikoPOS | Import Menu</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container py-4">
    <h1 class="text-center mb-4">📥 Import Menu</h1>

    <?php if ($message): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <p>Upload a CSV file with columns: <b>ID, Name, Category, Price</b></p>
        <form method="post" enctype="multipart/form-data">
          <input type="file" name="csv_file" accept=".csv" class="form-control mb-3" required>
          <button type="submit" class="btn btn-warning w-100">Upload & Import</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
