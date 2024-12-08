<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Products</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="phone.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    
    <div class="product-grid">
        <div class="product-card">
            <img src="product1.jpg" alt="Product 1">
            <h2>Product Name 1</h2>
            <p>Description for product 1.</p>
        </div>
        <div class="product-card">
            <img src="product2.jpg" alt="Product 2">
            <h2>Product Name 2</h2>
            <p>Description for product 2.</p>
        </div>
        <div class="product-card">
            <img src="product3.jpg" alt="Product 3">
            <h2>Product Name 3</h2>
            <p>Description for product 3.</p>
        </div>
        <div class="product-card">
            <img src="product4.jpg" alt="Product 4">
            <h2>Product Name 4</h2>
            <p>Description for product 4.</p>
        </div>
        <div class="product-card">
            <img src="product5.jpg" alt="Product 5">
            <h2>Product Name 5</h2>
            <p>Description for product 5.</p>
        </div>
        <div class="product-card">
            <img src="product6.jpg" alt="Product 6">
            <h2>Product Name 6</h2>
            <p>Description for product 6.</p>
        </div>
    </div>
</div>

</body>
</html>
