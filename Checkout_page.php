<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="main.css"> <!-- Main CSS for logo, navigation, and footer -->
    <link rel="stylesheet" href="Checkout_Page.css"> <!-- Checkout-specific CSS -->
</head>
<body>
    <!-- Navigation -->
    <?php include 'Navbar.php';?>

    <!-- Main Content Start -->
    <div class="checkout-container">
        <!-- Left Side: Customer Details -->
        <div class="customer-details">
            <p>
                Returning customer? 
                <a href="Login_Page.html" class="login-link">Click here to login</a>
            </p>

            <!-- Customer Input text boxes for input -->
            <form action="submit_checkout.php" method="post" class="customer-form">
                <div class="form-group">
                    <input type="text" id="first-name" name="first_name" placeholder="First Name" required>
                    <input type="text" id="last-name" name="last_name" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <input type="text" id="country" name="country" placeholder="Country/Region" required>
                </div>
                <div class="form-group">
                    <input type="text" id="street-name" name="street_name" placeholder="Street Name" required>
                </div>
                <div class="form-group">
                    <input type="text" id="house-number" name="house_number" placeholder="House Number" required>
                </div>
                <div class="form-group">
                    <input type="text" id="postcode" name="postcode" placeholder="Postcode" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
            </form>
        </div>

        <!-- Right Side: Payment and Summary -->
        <div class="payment-summary">
            <form action="process_order.php" method="post" class="payment-form">
                <div class="form-group">
                    <input type="text" id="address" name="address" placeholder="Additional Address" required>
                </div>
                <div class="form-group">
                    <p class="subtotal-box">Subtotal: $<span id="subtotal-value">0.00</span></p>
                </div>
                <div class="form-group">
                    <input type="text" id="card-number" name="card_number" placeholder="Card Number" required>
                </div>
                <div class="form-group">
                    <input type="text" id="expiry-date" name="expiry_date" placeholder="Expiry Date (MM/YY)" required>
                </div>
                <div class="form-group">
                    <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                </div>
                <button type="submit" class="place-order-btn">Place Order</button>
            </form>
        </div>
    </div>
    <!-- Ending For Main Content -->

</body>
</html>
