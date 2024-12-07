<?php
session_start();
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db



$user_email = $_SESSION['email'];

// Fetch user details
$user_query = "SELECT full_name, email FROM Users WHERE email = :email";
$user_stmt = $db->prepare($user_query);
$user_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
$user_stmt->execute();
$user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch basket summary
$basket_query = "
    SELECT 
        p.name AS product_name,
        p.price AS product_price,
        b.quantity AS product_quantity,
        (p.price * b.quantity) AS total_price
    FROM 
        Basket b
    JOIN 
        Products p 
    ON 
        b.product_id = p.product_id
    WHERE 
        b.email = :email
";
$basket_stmt = $db->prepare($basket_query);
$basket_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
$basket_stmt->execute();
$basket_result = $basket_stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize total basket price
$total_basket_price = 0;

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
            <h2>Your Details</h2>
            <form action="submit_checkout.php" method="post" class="customer-form">
                <div class="form-group">
                    <input type="text" id="full-name" name="full_name" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" placeholder="Full Name" required    >
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" placeholder="Email" required >
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
            </form>
        </div>


        <div class="payment-summary">
            <h2>Basket Summary</h2>
            <table border="1">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php foreach ($basket_result as $row): 
                    $product_name = ($row['product_name']);
                    $product_price = number_format($row['product_price'], 2);
                    $product_quantity = ($row['product_quantity']);
                    $total_price = number_format($row['total_price'], 2);

                    $total_basket_price += $row['total_price'];
                ?>
                    <tr>
                        <td><?php echo $product_name; ?></td>
                        <td>£<?php echo $product_price; ?></td>
                        <td><?php echo $product_quantity; ?></td>
                        <td>£<?php echo $total_price; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>£<?php echo number_format($total_basket_price, 2); ?></strong></td>
                </tr>
            </table>

            <h2>Payment Details</h2>
          <form id="confirmPayment" method="POST" action="Checkout_page.php">
            
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
