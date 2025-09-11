<?php
require_once __DIR__ . '/db.php';

if (!isset($_GET['type'])) {
    die("❌ Missing export type");
}

$type = $_GET['type'];

// --- Export Menu ---
if ($type === "menu") {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=menu_export.csv");

    $output = fopen("php://output", "w");
    fputcsv($output, ["ID", "Name", "Category", "Price"]);

    $stmt = $pdo->query("SELECT id, name, category, price FROM menu");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// --- Export Orders ---
if ($type === "orders") {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=orders_export.csv");

    $output = fopen("php://output", "w");
    fputcsv($output, ["Order ID", "Menu Item", "Category", "Price", "Created At"]);

    $sql = "SELECT o.id AS order_id, m.name AS item, m.category, m.price, o.created_at
            FROM orders o
            JOIN menu m ON o.menu_id = m.id
            ORDER BY o.created_at DESC";
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

die("❌ Invalid export type");
