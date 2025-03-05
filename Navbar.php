<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="top-navigation">
    <!-- Left Section -->
    <div class="nav-left">
        <!-- Logo -->
        <div class="logo">
            <a href="Home_page.php">
                <img src="Tech_Nova_logo/Tech_Nova.png" alt="Tech Nova Logo">
            </a>
        </div>

        <!-- Navigation Links -->
        <a href="Home_page.php">Home</a>
        <a href="About_us_page.php">About Us</a>
        <a href="Contact_Us.php">Contact Us</a>

        <!-- Dropdown for Products -->
        <div class="menu-dropdown">
            <button class="menu-button">Products</button>
            <div class="menu-options">
                <a href="Phone.php">Phone</a>
                <a href="tablets.php">Tablets</a>
                <a href="laptops.php">Laptops</a>
                <a href="audiodevices.php">Audio Devices</a>
                <a href="smartwatches.php">Smart Watches</a>
            </div>
        </div>

        <!-- Conditional Dropdown for Basket (Visible for customers only) -->
        <?php if (isset($_SESSION['email']) && $_SESSION['type'] === 'customer'): ?>
            <div class="cart-dropdown">
                <button class="cart-button">Basket</button>
                <div class="cart-options">
                    <a href="basket.php">Basket</a>
                    <a href="Previous_Order.php">Previous Order</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Admin Options Dropdown (Visible for admins only) -->
        <?php if (isset($_SESSION['email']) && $_SESSION['type'] === 'admin'): ?>
            <div class="menu-dropdown">
                <button class="menu-button">Admin Options</button>
                <div class="menu-options">
                    <a href="admin_dashboard_Customer_Management.php">User Management</a>
                    <a href="product_update.php">Product Update</a>
                    <a href="reports.php">Product Update</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Section -->
    <div class="nav-right">
        <!-- Search Bar -->
        <div class="search-container">
            <form action="search_results.php" method="GET">
                <input type="text" class="search-input" placeholder="Search..." name="query">
                <button type="submit" class="search-button">
                    <img src="search_bar_logo/loupe.png" alt="Search Icon" style="width: 20px; height: 20px;">
                </button>
            </form>
        </div>

        <!-- Conditional Dropdown for Logged-in User -->
        <?php if (isset($_SESSION['email'])): ?>
            <div class="menu-dropdown">
                <button class="menu-button">
                    <img src="account_logo/computer-icons-google-account-icon-design-login-png-favpng-jFjxPac6saRuDE3LiyqsYTEZM.jpg" 
                         alt="Account Logo" 
                         style="width: 20px; height: 20px; vertical-align: middle; border-radius: 50%;">
                </button>
                <div class="menu-options menu-options-account">
                    <a href="My_Account.php">My Account</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="Login_Page.php" class="login-link">Login</a>
        <?php endif; ?>
    </div>
</div>
