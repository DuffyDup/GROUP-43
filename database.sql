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


CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,-- Primary Key with auto-increment
    name VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL,-- Path to product image
    description VARCHAR(255) NOT NULL,
    stock INT NOT NULL,-- Number of items available
    category ENUM('phone', 'watch', 'ipad', 'laptop', 'headphone') NOT NULL, -- Product category
    price DECIMAL(10, 2) NOT NULL,
    product_condition ENUM('Poor', 'Fair', 'Good', 'Excellent') NOT NULL-- condition o the product
);


CREATE TABLE Purchased (
  order_id VARCHAR(36),
  product_id INT,
  quantity INT NOT NULL,
  address VARCHAR(255) NOT NULL,
  postcode VARCHAR(20) NOT NULL,
  time_of_order DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_price DECIMAL(10,2) NOT NULL,
  order_status ENUM('Pending', 'Shipped', 'Delivered') DEFAULT 'Pending',
  PRIMARY KEY (order_id, product_id),  -- Allows multiple products per order
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE Basket (
    email VARCHAR(255), -- Foreign Key to Users
    product_id INT, -- Foreign Key to Products
    quantity INT NOT NULL, -- Quantity of the item in the basket
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE, 
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);

 CREATE TABLE `orders` (
  `order_id` varchar(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `time_of_order` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE Reviews (
    email VARCHAR(255), -- Foreign Key to Users
    product_id INT, -- Foreign Key to Products
    rating ENUM('1','2','3','4','5') NOT NULL, -- The rating given to the product
    review VARCHAR(255) NOT NULL, -- Text of the review
    FOREIGN KEY (email) REFERENCES Users(email) ON DELETE CASCADE, 
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);

-- Insert sample data into Users table
INSERT INTO Users (email, full_name, password, phone_number, type) VALUES
('admin1@ad.com', 'cole palmer', '$2y$10$B2p8HrvTA5uqYYVcSO5mfusVRtGfvUU0a/EqR/r/VuCDPB4j7Mbia', '071243214078', 'admin'),
('bob@gmail.com', 'bill bob', '$2y$10$geYdMT8WPy4aDxr1Ok8tveTwdQeELtzIKTE6fQzsmr3/g9K1Rhk5G', '12321312', 'customer'),
('noah@gmail.com', 'noah oliver smith', '$2y$10$pars6sq.xnjwZQOUKFs9b.Dxpw8ZWrIbVWKVCeMorDYvU3eJd3lj2', '076451251267', 'customer');

-- Insert sample data into Products table
INSERT INTO `products` (`product_id`, `name`, `picture`, `description`, `stock`, `category`, `price`, `product_condition`) VALUES
(1, 'Black Macbook Pro M4 - Excellent', './Laptops/macbookproblack.png', 'A powerhouse laptop built for professionals and creatives. The MacBook Pro M4 features the next-gen Apple M4 chip for lightning-fast speeds, enhanced AI processing, and exceptional battery life. The Retina display delivers ultra-vivid colors and extreme clarity, providing a superior viewing experience for both work and entertainment. Its advanced cooling system ensures optimal performance during intensive tasks.', 5, 'laptop', 1099.99, 'excellent'),
(2, 'Silver Macbook Air (2022) - Good', './Laptops/macbookair2022silver.png', 'The ultra-light MacBook Air (2022) is designed for students and professionals who need performance on the go. Powered by the Apple M2 chip, it offers seamless multitasking, brilliant Retina visuals, and an all-day battery. Its silent fanless design keeps operation quiet while efficiently managing heat, making it ideal for libraries, offices, or cafes.', 2, 'laptop', 539.99, 'excellent'),
(3, 'Samsung Galaxy Book 3 - Fair', './Laptops/galaxybook3.png', 'Experience power and portability with the Samsung Galaxy Book 3. Featuring a stunning AMOLED display, a high-speed Intel processor, and Samsung’s seamless ecosystem integration, this laptop is ideal for work and play. With its ultra-thin design and long-lasting battery, you can stay productive or entertained from anywhere throughout the day.', 1, 'laptop', 649.99, 'excellent'),
(4, 'Macbook Air (2024) - Excellent', './Laptops/macbookair2024.png', 'The 2024 MacBook Air redefines portability with the ultra-powerful Apple M3 chip. The Liquid Retina display brings stunning visuals, while the ultra-slim fanless design makes it the ultimate travel laptop. It’s incredibly lightweight yet durable, ensuring superior performance and reliability wherever you go, perfect for remote work and creative tasks.', 2, 'laptop', 900.99, 'excellent'),
(5, 'Gold Macbook Air (2022) - Good', './Laptops/macbookair2022gold.png', 'The Gold MacBook Air (2022) is a perfect blend of elegance and performance. Equipped with the M2 chip, it handles daily computing tasks effortlessly. The gold finish adds a touch of sophistication, while the Retina display offers stunning clarity and colors for a premium visual experience. Its lightweight design makes it easy to carry everywhere.', 2, 'laptop', 900.99, 'excellent'),
(6, 'Samsung Galaxy Book 2 - Poor', './Laptops/samsunggalaxybook2.png', 'A compact yet capable laptop, the Samsung Galaxy Book 2 features a vibrant AMOLED display, a responsive keyboard, and a lightweight chassis. Perfect for students and professionals looking for an affordable laptop with reliable performance and excellent portability, suitable for daily tasks and web browsing.', 3, 'laptop', 349.99, 'excellent'),
(7, 'Black iPhone 16 - Excellent', './Phones/16black.png', 'The iPhone 16 is built for speed and efficiency, featuring the A17 Bionic chip and an advanced OLED display. With a stunning black finish, ultra-fast 5G connectivity, and improved battery life, this phone is perfect for multitasking, gaming, and capturing brilliant photos and videos with its advanced camera system.', 50, 'phone', 699.99, 'excellent'),
(8, 'Gold iPhone 16 Pro Max - Good', './Phones/16promaxgold.png', 'A luxury smartphone that combines cutting-edge technology with a sleek gold design. The iPhone 16 Pro Max features an A17 Pro chip for next-level performance, a ProMotion OLED display with incredible brightness, and a triple-lens camera system that captures professional-quality photos and videos in any lighting condition.', 30, 'phone', 1099.99, 'excellent'),
(11, 'Black Samsung Galaxy S23 - Fair', './Phones/s23black.png', 'A balanced smartphone featuring an immersive AMOLED display, a powerful Snapdragon processor, and a multi-lens camera system. The Galaxy S23 is designed for those who want reliable performance, great photography, and long-lasting battery life in a sleek and durable design, perfect for everyday use.', 100, 'phone', 699.99, 'excellent'),
(12, 'Samsung Galaxy S24 Ultra - Excellent', './Phones/s24ultra.png', 'The ultimate flagship smartphone with a massive 6.8-inch Dynamic AMOLED display, 200MP ultra-clear camera, and S Pen support. Built for power users, the S24 Ultra delivers unmatched performance with its Snapdragon 8 Gen 3 processor and all-day battery life, ideal for productivity, gaming, and professional-grade photography.', 40, 'phone', 799.99, 'excellent'),
(13, 'White Samsung Galaxy S23 - Poor', './Phones/s23white.png', 'A stylish and budget-friendly smartphone with a smooth AMOLED display, a powerful yet efficient processor, and a capable camera system. The Galaxy S23 is a solid choice for users looking for an affordable yet feature-packed device with reliable performance and sleek aesthetics.', 20, 'phone', 599.99, 'excellent'),
(14, 'iPhone 16 Pro Max - Excellent', './Phones/iphone16promax.png', 'A premium smartphone designed for those who demand the best. Featuring an advanced ProMotion XDR display, a lightning-fast A17 Pro chip, and a professional-grade triple-lens camera system, the iPhone 16 Pro Max is the ultimate flagship device for professionals, creatives, and tech enthusiasts.', 10, 'phone', 1099.99, 'excellent'),
(15, 'Blue iPad Air 2024 - Good', './Tablet_images/ipadair2024blue.png', 'A stunning tablet with a Liquid Retina display, the iPad Air 2024 is perfect for gaming, drawing, and productivity. With Apple’s M2 chip, powerful stereo speakers, and long battery life, this tablet is designed for those who want power, portability, and premium visuals for all activities.', 20, 'ipad', 699.99, 'excellent'),
(16, 'Samsung Galaxy Tab S9 Ultra - Excellent', './Tablet_images/samsungs9ultra.png', 'A powerhouse tablet featuring an expansive 14.6-inch Dynamic AMOLED display, S Pen support, and an ultra-slim design. The Samsung Galaxy Tab S9 Ultra is perfect for creators, students, and professionals alike, offering unbeatable multitasking, superior visuals, and seamless productivity integration.', 15, 'ipad', 339.99, 'excellent'),
(17, 'Amazon Alexa - Excellent', './Audio_Devices_images/alexa1.png', 'A smart home assistant with premium sound, voice-controlled automation, and seamless integration with smart devices. Alexa can play music, control your home, set reminders, and answer questions with ease, making everyday life simpler and more enjoyable.', 7, 'headphone', 39.99, 'excellent'),
(18, 'JBL Charge 5 - Good', './Audio_Devices_images/jblcharge.png', 'A portable Bluetooth speaker with powerful bass, waterproof design, and up to 20 hours of battery life. The JBL Charge 5 is perfect for outdoor adventures, pool parties, and music lovers who demand exceptional audio quality anywhere they go.', 2, 'headphone', 89.99, 'excellent'),
(19, 'Sony SRS-XB100 Wireless Speaker - Fair', './Audio_Devices_images/sonyspeaker.png', 'A compact yet powerful wireless speaker with EXTRA BASS technology for deep, punchy sound. Portable and durable, this speaker features a long-lasting battery, making it an ideal choice for travel, outdoor gatherings, and everyday enjoyment.', 5, 'headphone', 29.99, 'excellent'),
(20, 'Apple Watch Series 9 - Excellent', './Smart_watches_images/applewatch9.png', 'A next-gen smartwatch with advanced fitness tracking, heart rate monitoring, and seamless integration with Apple devices. Its always-on Retina display, premium build, and innovative health features make it essential for fitness enthusiasts and busy professionals.', 10, 'watch', 249.99, 'excellent'),
(21, 'Apple Watch Series 10 - Good', './Smart_watches_images/applewatch10.png', 'A stylish and powerful smartwatch featuring a brighter display, improved health tracking, and enhanced battery life. Series 10 balances fashion and functionality, perfect for health-conscious individuals who need reliable performance and elegance.', 10, 'watch', 299.99, 'excellent'),
(22, 'Black Apple Watch Series 10 - Excellent', './Smart_watches_images/Applewatch10jetblack.png', 'The latest Apple Watch featuring a sleek jet-black finish, advanced fitness tracking, a new-generation health sensor, and an always-on Retina display. It provides robust health insights, exceptional durability, and an unmatched wearable experience.', 10, 'watch', 299.99, 'excellent'),
(23, '11 Inch iPad Pro - Excellent', './Tablet_images/ipadpro11inch.png', 'The 11-inch iPad Pro delivers pro-level performance in a compact form factor. Powered by the M2 chip, it offers a stunning Liquid Retina display with ProMotion technology and Apple Pencil 2 support, making it ideal for creative professionals, students, and productivity-focused users.', 20, 'ipad', 899.99, 'excellent'),
(24, 'iPad Air 2024 - Good', './Tablet_images/ipadair2024.png', 'A sleek and lightweight tablet powered by Apple’s M2 chip, designed for smooth multitasking, vibrant visuals, and immersive gaming experiences. Its Liquid Retina display ensures true-to-life colors, while the ultra-thin design provides easy portability for everyday tasks.', 30, 'ipad', 699.99, 'excellent'),
(25, 'iPad Air 2024 Starlight - Good', './Tablet_images/ipadair2024starlight.png', 'A versatile tablet combining elegant aesthetics with powerful performance. Its gold-tinted aluminum body houses the M2 chip, delivering stunning visuals and efficient multitasking capabilities ideal for creative work, entertainment, and everyday productivity.', 2, 'ipad', 499.99, 'excellent'),
(26, 'Samsung Galaxy Tab S10 Ultra - Excellent', './Tablet_images/samsungs10ultra.png', 'Featuring a breathtaking 14.6-inch AMOLED display, upgraded S Pen precision, and advanced AI-powered features, this next-generation tablet is perfect for creators, professionals, and entertainment lovers who demand the ultimate multimedia and productivity experience.', 15, 'ipad', 579.99, 'excellent'),
(27, 'Fitbit Versa 4 - Excellent', './Smart_watches_images/fitbit.png', 'A lightweight fitness smartwatch designed to enhance your active lifestyle. Equipped with built-in GPS, heart rate monitoring, sleep tracking, and over 40 exercise modes, it offers customizable watch faces and long battery life for continuous health tracking and wellness support.', 15, 'watch', 199.99, 'excellent'),
(28, 'Samsung Galaxy Watch 7 - Excellent', './Smart_watches_images/samsungwatch.png', 'A premium smartwatch with a vibrant AMOLED display, advanced health monitoring, and seamless Galaxy device integration. It provides AI-powered insights, extended battery life, and sophisticated styling suitable for fitness tracking, daily productivity, and fashion-forward users.', 12, 'watch', 349.99, 'excellent'),
(29, 'AirPods Pro 2 - Excellent', './Audio_Devices_images/airpods.png', 'Next-generation earbuds delivering immersive sound with Active Noise Cancellation and Adaptive Transparency. Enhanced spatial audio, customizable fit, and a MagSafe charging case make these earbuds ideal for audiophiles and professionals seeking top-tier audio performance and comfort.', 30, 'headphone', 249.99, 'excellent'),
(30, 'AirPods Max - Excellent', './Audio_Devices_images/airpodspro.png', 'Premium over-ear headphones offering high-fidelity audio, industry-leading Active Noise Cancellation, spatial audio, and luxurious memory foam ear cushions. Designed for superior comfort and immersive sound, AirPods Max redefine audio luxury and cater to discerning music enthusiasts and professionals.', 10, 'headphone', 549.99, 'excellent');





ALTER TABLE Purchased
ADD COLUMN purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;