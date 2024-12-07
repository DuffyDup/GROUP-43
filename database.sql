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
