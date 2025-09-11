-- Create JikoPOS database
CREATE DATABASE IF NOT EXISTS jikopos;
USE jikopos;

-- Menu table
CREATE TABLE IF NOT EXISTS menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(50),
  image VARCHAR(255)
);

-- Insert sample menu items
INSERT INTO menu (name, description, price, category, image) VALUES
('Beef Stew', 'Tender beef slow cooked with spices', 450.00, 'Main Course', 'beef_stew.jpg'),
('Ugali', 'Traditional Kenyan maize meal', 80.00, 'Main Course', 'ugali.jpg'),
('Chapati', 'Soft flatbread', 40.00, 'Sides', 'chapati.jpg'),
('Soda', 'Assorted soft drinks', 60.00, 'Drinks', 'soda.jpg');

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_id INT NOT NULL,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE
);

-- Insert a sample order
INSERT INTO orders (menu_id, item_name, price, qty) VALUES
(1, 'Beef Stew', 450.00, 2),
(3, 'Chapati', 40.00, 3);
