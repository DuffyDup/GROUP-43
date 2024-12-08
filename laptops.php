<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptops</title>
    <link rel="stylesheet" href="laptops.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <h1>Our Laptops</h1>
    <div class="product-grid">
        <div class="product-card">
            <img src="laptop1.jpg" alt="Laptop 1">
            <h2>Laptop 1</h2>
            <p>Description for laptop 1.</p>
        </div>
        <div class="product-card">
            <img src="laptop2.jpg" alt="Laptop 2">
            <h2>Laptop 2</h2>
            <p>Description for laptop 2.</p>
        </div>
        <div class="product-card">
            <img src="laptop3.jpg" alt="Laptop 3">
            <h2>Laptop 3</h2>
            <p>Description for laptop 3.</p>
        </div>
        <div class="product-card">
            <img src="laptop4.jpg" alt="Laptop 4">
            <h2>Laptop 4</h2>
            <p>Description for laptop 4.</p>
        </div>
        <div class="product-card">
            <img src="laptop5.jpg" alt="Laptop 5">
            <h2>Laptop 5</h2>
            <p>Description for laptop 5.</p>
        </div>
        <div class="product-card">
            <img src="laptop6.jpg" alt="Laptop 6">
            <h2>Laptop 6</h2>
            <p>Description for laptop 6.</p>
        </div>
    </div>
</div>

</body>
</html>
