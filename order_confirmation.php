<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['order_id']) || !isset($_SESSION['email'])) {
    echo "<script>alert('No order found.'); window.location.href='index.php';</script>";
    exit();
}

$order_id = $_SESSION['order_id'];
$user_email = $_SESSION['email'];

// Fetch order details (Corrected Query)
$order_query = "
    SELECT 
        p.name AS product_name,
        p.price AS product_price,
        pr.quantity AS product_quantity,
        o.address,
        o.postcode
    FROM Purchased pr
    JOIN Products p ON pr.product_id = p.product_id
    JOIN Orders o ON pr.order_id = o.order_id
    WHERE pr.order_id = :order_id AND o.email = :email
";
$order_stmt = $db->prepare($order_query);
$order_stmt->bindValue(':order_id', $order_id, PDO::PARAM_STR);
$order_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
$order_stmt->execute();
$order_details = $order_stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if order exists
if (!$order_details) {
    echo "<script>alert('Order not found.'); window.location.href='index.php';</script>";
    exit();
}

// Fetch shipping address
$shipping_address = htmlspecialchars($order_details[0]['address']) . ', ' . htmlspecialchars($order_details[0]['postcode']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="confirmation-container">
        <h1>Order Confirmation</h1>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
        <p><strong>Shipping Address:</strong> <?php echo $shipping_address; ?></p>

        <h2>Order Summary</h2>
        <table border="1">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <?php 
            $total_price = 0;
            foreach ($order_details as $item): 
                $item_total = $item['product_price'] * $item['product_quantity'];
                $total_price += $item_total;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>£<?php echo number_format($item['product_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($item['product_quantity']); ?></td>
                    <td>£<?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>£<?php echo number_format($total_price, 2); ?></strong></td>
            </tr>
        </table>

        <p>Thank you for your purchase!</p>
      
    </div>
    <script src="theme.js" defer></script>

</body>
</html>
