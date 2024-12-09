<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Signup Page</title>
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="homepage.css">
</head>
<body>
     <!-- Include the Navigation -->

  <?php include 'Navbar.php'; ?>

    <!-- Main Content -->

    <section class="main-content">

        <!-- Image Slideshow -->

        <div class="slideshow-container">
            <div class="mySlides fade">
                <a href="Phone.php">
                    <img src="Phones/16blackback.png" alt="Product 1" style="width:70%">
                </a>
            </div>
        
            <div class="mySlides fade">
                <a href="smartwatches.php">
                    <img src="Smart_watches_images/Apple watch 10 black.png" alt="Product 2" style="width:70%">
                </a>
            </div>
        
            <div class="mySlides fade">
                <a href="tablets.php">
                    <img src="Tablet_images/ipadpro11inch.png" alt="Product 3" style="width:70%">
                </a>
            </div>
        
            <!-- Navigation buttons -->

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

        </div>
        
        <!-- Dots for navigation -->

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <!-- Product Card Section --> 
        
        <section class="product-cards">
            <div class="card">        
                <a href="smartwatches.php">    
                <img src="Smart_watches_images/Applewatch9.png" alt="Product 1" class="product-image">
                <h1>Apple Watch</h1>
                <p>Series 9</p>
                <p class="price">£299.99</p>
            </div>
            
            <div class="card">
                <a href="audiodevices.php">
                <img src="Audio_Devices_images/Alexa1.png" alt="Product 2" class="product-image">
                <h1>Amazon Echo Dot</h1>
                <p>5th Generation</p>
                <p class="price">£24.99</p>
        
            </div>

            <div class="card">
                <a href="laptops.php">
                <img src="Laptops/samsung galaxybook4.png" alt="Product 3" class="product-image">
                <h1>Samsung Galaxy Book </h1>
                <p>4th Generation</p>
                <p class="price">£699.99</p>
    
            </div>
            
            <div class="card">
                <a href="Phone.php">
                <img src="Phones/s23black.png" alt="Product 4" class="product-image">
                <h1>Samsung Galaxy</h1>
                <p>S23</p>
                <p class="price">£749.00</p>
            </div>
        </section>



    <!-- Footer -->

    <?php include 'footer.php'; ?>

    <!-- javascript link (homepage.js) -->

    <script src="homepage.js"></script>

</body>
</html>