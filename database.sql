CREATE DATABASE IF NOT EXISTS cozy_cafe CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cozy_cafe;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    image_path VARCHAR(255),
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    customer_note TEXT,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO products (name, description, price, category, is_active) VALUES
('Classic Cappuccino', 'Espresso with steamed milk and a velvety foam.', 150.00, 'Coffee', 1),
('Vanilla Latte', 'Smooth espresso with steamed milk and vanilla.', 170.00, 'Coffee', 1),
('Cold Brew', 'Slow-brewed coffee served over ice.', 160.00, 'Coffee', 1),
('Masala Chai', 'Spiced Indian tea brewed with milk.', 120.00, 'Tea', 1),
('Green Tea', 'Lightly brewed green tea.', 100.00, 'Tea', 1),
('Hot Chocolate', 'Rich chocolate drink topped with cream.', 140.00, 'Specials', 1),
('Butter Croissant', 'Flaky, buttery croissant baked fresh daily.', 80.00, 'Pastries', 1),
('Chocolate Brownie', 'Gooey chocolate brownie with walnuts.', 90.00, 'Pastries', 1),
('Cheese Sandwich', 'Grilled cheese sandwich on artisan bread.', 130.00, 'Snacks', 1);
