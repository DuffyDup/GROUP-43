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
                <a href="productdetail.html">
                    <img src="16blackback.png" alt="Product 1" style="width:100%">
                </a>
                <div class="text">Apple IPhone 16 Black</div>
            </div>
        
            <div class="mySlides fade">
                <a href="productdetail.html">
                    <img src="s24ultraback.png" alt="Product 2" style="width:100%">
                </a>
                <div class="text">Samsung S24 Ultra Titanium Black </div>
            </div>
        
            <div class="mySlides fade">
                <a href="productdetail.html">
                    <img src="ipadpro11inch.png" alt="Product 3" style="width:100%">
                </a>
                <div class="text">Apple IPad Pro 11-Inch Space Grey</div>
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

        <!-- Box Section -->

        <section class="boxes">
            <div class="box">
                <a href="productdetail.html">
                    <img src="Tech_Nova.png" alt="Product 1">
                </a>
                <div class="box-text">Product 1 Description</div>
            </div>
            <div class="box">
                <a href="product2.html">
                    <img src="Tech_Nova.png" alt="Product 2">
                </a>
                <div class="box-text">Product 2 Description</div>
            </div>
            <div class="box">
                <a href="product3.html">
                    <img src="Tech_Nova.png" alt="Product 3">
                </a>
                <div class="box-text">Product 3 Description</div>
            </div>
            <div class="box">
                <a href="product4.html">
                    <img src="Tech_Nova.png" alt="Product 4">
                </a>
                <div class="box-text">Product 4 Description</div>
            </div>
        </section>
    </section>

    <!-- Footer -->

    <footer>
        <div class="footer-links">
            <a href="terms.html">Terms</a>
            <a href="privacy.html">Privacy</a>
            <a href="help.html">Help</a>
            <a href="Admin_Signup_page.html">Admin Signup</a>
            <a href="Customer_SignUp.html">Signup</a>
        </div>
        <div class="contact-info">
            <p>Email: sales@example.com</p>
            <p>Phone: 123-456-7890</p>
        </div>
    </footer>

    <!-- javascript link -->

    <script src="testpage.js"></script>

</body>