-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Site Settings Table (Key-Value pair for flexibility)
-- Keys: site_title, site_description, favicon, banner_image, wa_number, pakasir_apikey, pakasir_slug
CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(255) -- Path to icon image
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(15, 2) NOT NULL,
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Product Licenses / Digital Assets (Stock)
CREATE TABLE IF NOT EXISTS product_licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    license_data TEXT NOT NULL, -- The actual digital content (e.g., user|pass)
    status ENUM('available', 'sold') DEFAULT 'available',
    order_id INT DEFAULT NULL, -- Linked when sold
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL, -- Added for simple single-product order
    total_amount DECIMAL(15, 2) NOT NULL,
    status ENUM('pending', 'paid', 'failed', 'expired') DEFAULT 'pending',
    pakasir_inv_id VARCHAR(100), -- ID from Pakasir
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert Default Admin (username: admin, password: password)
-- Hash for 'password' is usually $2y$10$... but for simplicity in setup I'll use a placeholder or plain PHP generated hash later.
-- I will insert a raw SQL with a known hash.
-- Hash for 'password' using PASSWORD_DEFAULT
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert Default Settings
INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_title', 'Digital Premium Shop'),
('site_description', 'Best place for digital goods'),
('favicon', 'assets/images/default_favicon.png'),
('banner_image', 'assets/images/default_banner.jpg'),
('wa_number', '628123456789'),
('pakasir_apikey', ''),
('pakasir_slug', '');
