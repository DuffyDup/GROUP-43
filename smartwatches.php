<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Watches</title>
    <link rel="stylesheet" href="smartwatches.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <h1>Our Smart Watches</h1>
    <div class="product-grid">
        <div class="product-card">
            <img src="watch1.jpg" alt="Smart Watch 1">
            <h2>Smart Watch 1</h2>
            <p>Description for smart watch 1.</p>
        </div>
        <div class="product-card">
            <img src="watch2.jpg" alt="Smart Watch 2">
            <h2>Smart Watch 2</h2>
            <p>Description for smart watch 2.</p>
        </div>
        <div class="product-card">
            <img src="watch3.jpg" alt="Smart Watch 3">
            <h2>Smart Watch 3</h2>
            <p>Description for smart watch 3.</p>
        </div>
        <div class="product-card">
            <img src="watch4.jpg" alt="Smart Watch 4">
            <h2>Smart Watch 4</h2>
            <p>Description for smart watch 4.</p>
        </div>
        <div class="product-card">
            <img src="watch5.jpg" alt="Smart Watch 5">
            <h2>Smart Watch 5</h2>
            <p>Description for smart watch 5.</p>
        </div>
        <div class="product-card">
            <img src="watch6.jpg" alt="Smart Watch 6">
            <h2>Smart Watch 6</h2>
            <p>Description for smart watch 6.</p>
        </div>
    </div>
</div>

</body>
</html>
