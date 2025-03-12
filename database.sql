CREATE DATABASE TechNova;
USE TechNova;

-- Create the Users table
CREATE TABLE Users (
    email VARCHAR(255) PRIMARY KEY, -- Primary Key
    full_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    type ENUM('customer', 'admin') NOT NULL -- User type: either customer or admin to figure out what home page to take them to
);

-- Create the Products table
CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,-- Primary Key with auto-increment
    name VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL,-- Path to product image
    description VARCHAR(255) NOT NULL,
    stock INT NOT NULL,-- Number of items available
    category ENUM('phone','watch','ipad','laptop','headphone') NOT NULL,-- Product category (e.g., electronics)
    price DECIMAL(10, 2) NOT NULL-- Product price with 2 decimal places
);

-- Create the Purchased table with order_id as the primary key
CREATE TABLE Purchased (
    order_id INT AUTO_INCREMENT PRIMARY KEY, -- Unique ID for each purchase
    email VARCHAR(255), -- Foreign Key to Users
    product_id INT,  -- Foreign Key to Products
    quantity INT NOT NULL, -- Quantity the user purchased
    address VARCHAR(255) NOT NULL, -- Address where the order will be sent 
    postcode VARCHAR(20) NOT NULL, -- Postal code for delivery
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE, -- Ensure consistency between tables
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
      `time_of_order` datetime NOT NULL DEFAULT current_timestamp() -- Ensure consistency between tables
);

-- Create the Basket table
CREATE TABLE Basket (
    email VARCHAR(255),-- Foreign Key to Users
    product_id INT, -- Foreign Key to Products
    quantity INT NOT NULL, -- Quantity of the item in the basket
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE, -- Make the values in both tables the same
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE -- Make the values in both tables the same
);

-- Create the Reviews table
CREATE TABLE Reviews (
    email VARCHAR(255),-- Foreign Key to Users
    product_id INT,-- Foreign Key to Products
    rating ENUM('1','2','3','4','5') NOT NULL,-- the rating given to the product
    review VARCHAR(255) NOT NULL, -- Text of the review
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE, -- Make the values in both tables the same
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE -- , ,Make the values in both tables the same
);

INSERT INTO `users` (`email`, `full_name`, `password`, `phone_number`, `type`) VALUES
('admin1@ad.com', 'cole palmer', '$2y$10$B2p8HrvTA5uqYYVcSO5mfusVRtGfvUU0a/EqR/r/VuCDPB4j7Mbia', '071243214078', 'admin'),
('bob@gmail.com', 'bill bob', '$2y$10$geYdMT8WPy4aDxr1Ok8tveTwdQeELtzIKTE6fQzsmr3/g9K1Rhk5G', '12321312', 'customer'),
('noah@gmail.com', 'noah oliver smith', '$2y$10$pars6sq.xnjwZQOUKFs9b.Dxpw8ZWrIbVWKVCeMorDYvU3eJd3lj2', '076451251267', 'customer');

INSERT INTO `Products` (`product_id`, `name`, `picture`, `description`, `stock`, `category`, `price`) VALUES
(1, 'Black Macbook Pro M4', './Laptops/macbookproblack.png', 'Sleek and powerful with the Apple M4 chip and a vibrant Retina display. Lightly used, excellent condition, no scratches or dents. Includes original charger and packaging. Battery health: 92%. Perfect for work or entertainment!', 5, 'laptop', 1099.99),
(2, 'Silver Macbook Air (2022)', './Laptops/macbookair2022silver.png', 'Lightweight and powerful with the Apple M2 chip and a stunning Retina display. In excellent condition, lightly used with no scratches. Includes original charger and packaging. Battery health: 95%. Perfect for work, school, or travel!', 2, 'laptop', 539.99),
(3, 'Samsung Galaxy Book 3', './Laptops/galaxybook3.png', 'Sleek and versatile laptop with a stunning AMOLED display and powerful Intel processor. Lightly used, in excellent condition with no scratches or dents. Includes original charger and packaging. Ideal for work, entertainment, and multitasking!', 1, 'laptop', 649.99),
(4, 'Macbook Air (2024)', './Laptops/macbookair2024.png', 'Ultra-slim design with the powerful Apple M3 chip and stunning Liquid Retina display. Excellent condition, barely used, no scratches or dents. Includes original charger and packaging. Perfect for work, creativity, or on-the-go productivity!', 2, 'laptop', 900.99),
(5, 'Gold Macbook Air (2022)', './Laptops/macbookair2022gold.png', 'Stylish and lightweight with the powerful Apple M2 chip and a brilliant Retina display. Excellent condition, no scratches or dents, lightly used. Includes original charger and packaging. Perfect for work, study, or travel!', 2, 'laptop', 900.99),
(6, 'Samsung Galaxy Book 2', './Laptops/samsunggalaxybook2.png', 'Sleek and lightweight laptop with a vibrant AMOLED display and powerful Intel processor. In excellent condition, lightly used with no scratches. Includes original charger and packaging. Ideal for work, entertainment, or multitasking!', 3, 'laptop', 349.99),
(7, 'Black iPhone 16', './Phones/16black.png', 'Affordable smartphone with great features.', 50, 'phone', 699.99),
(8, 'Gold iPhone 16 Pro Max', './Phones/16promaxgold.png', 'High-end smartphone with excellent camera.', 30, 'phone', 1099.99),
(9, 'Black Samsung Galaxy S23', './Phones/s23black.png', 'Budget-friendly phone with essential features.', 100, 'phone', 699.99),
(10, 'Samsung Galaxy S24 Ultra', './Phones/s24ultra.png', 'Mid-range smartphone with large display.', 40, 'phone', 799.99),
(11, 'White Samsung Galaxy S23', './Phones/s23white.png', 'Durable smartphone with long battery life.', 20, 'phone', 599.99),
(12, 'iPhone 16 Pro Max', './Phones/iphone16promax.png', 'High-end smartphone with excellent camera', 10, 'phone', 1099.99),
(13, 'Blue iPad Air 2024', './Tablet_images/ipadair2024blue.png', 'Lightweight tablet with powerful features', 20, 'ipad', 699.99),
(14, '11 Inch iPad Pro', './Tablet_images/ipadpro11inch.png', 'Lightweight tablet with powerful features', 20, 'ipad', 899.99),
(15, 'iPad Air 2024', './Tablet_images/ipadair2024.png', 'Lightweight tablet with powerful features', 30, 'ipad', 699.99),
(16, 'Samsung Galaxy Tab S9 Ultra', './Tablet_images/samsungs9ultra.png', 'Lightweight tablet with powerful features', 15, 'ipad', 339.99),
(17, 'Samsung Galaxy Tab S10 Ultra', './Tablet_images/samsungs10ultra.png', 'Lightweight tablet with powerful features', 15, 'ipad', 579.99),
(18, 'iPad Air 2024 Starlight', './Tablet_images/ipadair2024starlight.png', 'Lightweight tablet with powerful features', 2, 'ipad', 499.99),
(19, 'Amazon Alexa', './Audio_Devices_images/alexa1.png', 'Smart Speaker', 7, 'headphone', 39.99),
(20, 'JBL Charge 5', './Audio_Devices_images/jblcharge.png', 'High Quality Portable Speaker', 2, 'headphone', 89.99),
(21, 'Sony SRS-XB100 Wireless Speaker', './Audio_Devices_images/sonyspeaker.png', 'High Quality Wireless Speaker', 5, 'headphone', 29.99),
(22, 'Apple Watch Series 9', './Smart_watches_images/applewatch9.png', 'Sleek and powerful smartwatch with advanced health tracking, always-on Retina display, and seamless iPhone integration. Excellent condition, lightly used, no scratches. Includes original band, charger, and packaging. Perfect for fitness and productivity!', 10, 'watch', 249.99),
(23, 'Apple Watch Series 10', './Smart_watches_images/applewatch10.png', 'Sleek and powerful smartwatch with advanced health tracking, always-on Retina display, and seamless iPhone integration. Excellent condition, lightly used, no scratches. Includes original band, charger, and packaging. Perfect for fitness and productivity!', 10, 'watch', 299.99),
(24, 'Black Apple Watch Series 10', './Smart_watches_images/Applewatch10 black.png', 'Sleek and powerful smartwatch with advanced health tracking, always-on Retina display, and seamless iPhone integration. Excellent condition, lightly used, no scratches. Includes original band, charger, and packaging. Perfect for fitness and productivity!', 10, 'watch', 299.99);

