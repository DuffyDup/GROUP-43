<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="main.css"> <!-- Main CSS for logo and navigation -->
    <link rel="stylesheet" href="About_us_page.css"> <!-- About Us-specific CSS -->
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>
    <!-- Top Navigation -->
    <?php include 'Navbar.php';?>

    <!-- About Us Content -->
    <div class="about-us-container">
        <!-- Big Text Section -->
        <div class="sub-text" >
            <p>
            At Tech Nova, we focus on delivering top-notch, pre-owned electronics, 
            such as smartphones, tablets, laptops, smartwatches, and iPads. 
            Our goal is to provide cost-effective and dependable products for students and 
            those mindful of their spending. Whether you're in school, at work, or 
            simply seeking a great bargain, we have everything you need.
            </p>
        </div><br>

        <!-- 4 Smaller Text Sections -->
        <div class="sub-text-sections">
            <div class="sub-text" >
                <h2>Our Products</h2>
                <p>We meticulously examine and restore each device to guarantee it adheres to the utmost standards of quality and dependability.</p>
            </div>
            <div class="sub-text">
                <h2>Why Choose Us?</h2>
                <p>We emphasize cost-effectiveness while maintaining high standards. Our offerings are ideal for students seeking reliable devices at unmatched prices.</p>
            </div>
            <div class="sub-text">
                <h2>Sustainability</h2>
                <p>Purchasing pre-owned electronics allows you to save money while also contributing to the reduction of electronic waste and safeguarding the environment.</p>
            </div>
            <div class="sub-text" >
                <h2>Customer Commitment</h2>
                <p>We are committed to delivering outstanding customer support and ensuring that your experience with us is seamless and trouble-free.</p>
            </div>
        </div>
    </div>
    <!-- End of About Us -->
    <!-- Footer --><br>
    <?php include 'footer.php'; ?>
</body>
</html>
