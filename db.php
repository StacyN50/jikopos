<?php 
// =============================
// JikoPOS Database Connection
// =============================
$host = 'localhost';   // or 127.0.0.1
$db   = 'jikopos';     // database name (make sure you created it in phpMyAdmin)
$user = 'root';        // your MySQL username
$pass = '';            // your MySQL password (default is '' on XAMPP)

// Try connecting with PDO
try {  
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don’t exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS menu (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            category VARCHAR(50),
            image VARCHAR(255)
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_type ENUM('Dine-in','Takeaway') NOT NULL,
            table_no VARCHAR(20),
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            total_amount DECIMAL(10,2) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            menu_id INT NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY(order_id) REFERENCES orders(id),
            FOREIGN KEY(menu_id) REFERENCES menu(id)
        );

        CREATE TABLE IF NOT EXISTS sales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            sale_date DATE DEFAULT CURRENT_DATE,
            total DECIMAL(10,2) NOT NULL,
            FOREIGN KEY(order_id) REFERENCES orders(id)
        );
    ");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
