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

-- Create the Purchased table
CREATE TABLE Purchased (
    email VARCHAR(255), -- Foreign Key to Users
    product_id INT,  -- Foreign Key to Products
    quantity INT NOT NULL,-- Quantity the user purchased
    address VARCHAR(255) NOT NULL, -- address of where the order will be sent 
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE,-- Make the values in both tables the same
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE -- Make the values in both tables the same
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

