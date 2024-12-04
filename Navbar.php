<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="top-navigation">
    <!-- Logo -->
    <a href="Home_Page.php" class="logo">
        <img src="Tech_Nova.png" alt="Tech Nova Logo">
    </a>

    <!-- Navigation Links -->
    <a href="Home_Page.php">Home</a>
    <a href="About_us_page.html">About Us</a>
    <a href="Contact_Us.php">Contact Us</a>

    <!-- Dropdown for Products -->
    <div class="menu-dropdown">
        <button class="menu-button">Products</button>
        <div class="menu-options">
            <a href="#">Phone</a>
            <a href="#">Tablets</a>
            <a href="#">Laptops</a>
            <a href="#">Audio Devices</a>
            <a href="#">Smart Watches</a>
        </div>
    </div>

    <!-- Conditional Dropdown for Basket -->
    <?php if (isset($_SESSION['email'])): ?>
        <div class="cart-dropdown">
            <button class="cart-button">Basket</button>
            <div class="cart-options">
                <a href="basket.php">Basket</a>
                <a href="Previous_Order.php">Previous Order</a>
            </div>
        </div>
    <?php endif; ?>

     <!-- Conditional Dropdown for Logged-in User -->
     <?php if (isset($_SESSION['email'])): ?>
        <div class="menu-dropdown">
            <button class="menu-button">
                <img src="account_logo/computer-icons-google-account-icon-design-login-png-favpng-jFjxPac6saRuDE3LiyqsYTEZM.jpg" 
                     alt="Account Logo" 
                     style="width: 20px; height: 20px; vertical-align: middle; border-radius: 50%;">
            </button>
            <div class="menu-options">
                <a href="My_Account.php">My Account</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <?php else: ?>
        <a href="Login_Page.php">Login</a>
    <?php endif; ?>
</div>
