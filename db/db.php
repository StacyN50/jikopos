<?php
// =============================
// JikoPOS Database Connection
// =============================
$host = 'localhost';
$db = 'jikopos';
$user = 'root';
$pass = '';

// Database file location
$db_file = __DIR__ . '/jikoPOS.db';

try {
    // Connect to SQLite database
    $pdo = new PDO("sqlite:" . $db_file);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS menu (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            category VARCHAR(50),
            image VARCHAR(255)
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_type TEXT NOT NULL,       -- 'Dine-in', 'Takeaway'
            table_no TEXT,                  -- optional for dine-in
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            total_amount REAL NOT NULL
        );

        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            menu_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL,
            price REAL NOT NULL,            -- price at order time
            FOREIGN KEY(order_id) REFERENCES orders(id),
            FOREIGN KEY(menu_id) REFERENCES menu(id)
        );

        CREATE TABLE IF NOT EXISTS sales (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            sale_date DATE DEFAULT CURRENT_DATE,
            total REAL NOT NULL,
            FOREIGN KEY(order_id) REFERENCES orders(id)
        );
    ");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
