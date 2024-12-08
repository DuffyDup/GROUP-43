<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Devices</title>
    <link rel="stylesheet" href="audiodevices.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <h1>Our Audio Devices</h1>
    <div class="product-grid">
        <div class="product-card">
            <img src="audio1.jpg" alt="Audio Device 1">
            <h2>Audio Device 1</h2>
            <p>Description for audio device 1.</p>
        </div>
        <div class="product-card">
            <img src="audio2.jpg" alt="Audio Device 2">
            <h2>Audio Device 2</h2>
            <p>Description for audio device 2.</p>
        </div>
        <div class="product-card">
            <img src="audio3.jpg" alt="Audio Device 3">
            <h2>Audio Device 3</h2>
            <p>Description for audio device 3.</p>
        </div>
        <div class="product-card">
            <img src="audio4.jpg" alt="Audio Device 4">
            <h2>Audio Device 4</h2>
            <p>Description for audio device 4.</p>
        </div>
        <div class="product-card">
            <img src="audio5.jpg" alt="Audio Device 5">
            <h2>Audio Device 5</h2>
            <p>Description for audio device 5.</p>
        </div>
        <div class="product-card">
            <img src="audio6.jpg" alt="Audio Device 6">
            <h2>Audio Device 6</h2>
            <p>Description for audio device 6.</p>
        </div>
    </div>
</div>

</body>
</html>
