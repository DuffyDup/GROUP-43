<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablets</title>
    <link rel="stylesheet" href="tablets.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <h1>Our Tablets</h1>
    <div class="product-grid">
        <div class="product-card">
            <img src="tablet1.jpg" alt="Tablet 1">
            <h2>Tablet Name 1</h2>
            <p>Description for tablet 1.</p>
        </div>
        <div class="product-card">
            <img src="tablet2.jpg" alt="Tablet 2">
            <h2>Tablet Name 2</h2>
            <p>Description for tablet 2.</p>
        </div>
        <div class="product-card">
            <img src="tablet3.jpg" alt="Tablet 3">
            <h2>Tablet Name 3</h2>
            <p>Description for tablet 3.</p>
        </div>
        <div class="product-card">
            <img src="tablet4.jpg" alt="Tablet 4">
            <h2>Tablet Name 4</h2>
            <p>Description for tablet 4.</p>
        </div>
        <div class="product-card">
            <img src="tablet5.jpg" alt="Tablet 5">
            <h2>Tablet Name 5</h2>
            <p>Description for tablet 5.</p>
        </div>
        <div class="product-card">
            <img src="tablet6.jpg" alt="Tablet 6">
            <h2>Tablet Name 6</h2>
            <p>Description for tablet 6.</p>
        </div>
    </div>
</div>

</body>
</html>
