<?php
session_start();
require_once 'connectdb.php';

if (!isset($_SESSION['email'])) {
    die("Please log in to view your order details.");
}

if (!isset($_GET['order_id'])) {
    die("Invalid order request.");
}

$order_id = $_GET['order_id'];
$email = $_SESSION['email'];

try {
    $stmt = $db->prepare("
        SELECT p.product_id, p.quantity, 
               pr.name AS product_name, pr.price AS product_price, 
               (p.quantity * pr.price) AS total_price,
               o.address, o.postcode
        FROM Purchased p
        JOIN Products pr ON p.product_id = pr.product_id
        JOIN Orders o ON p.order_id = o.order_id
        WHERE p.order_id = :order_id AND o.email = :email
    ");
    $stmt->execute(['order_id' => $order_id, 'email' => $email]);
    $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($order_details) {
        $address = $order_details[0]['address'];
        $postcode = $order_details[0]['postcode'];
    } else {
        $address = $postcode = "Unknown";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
        $delete_stmt = $db->prepare("DELETE FROM Purchased WHERE order_id = :order_id");
        $delete_stmt->execute(['order_id' => $order_id]);

        echo "<script>alert('Order cancelled successfully.'); window.location.href='Previous_Order.php';</script>";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_address'])) {
        $new_address = htmlspecialchars($_POST['new_address']);
        $new_postcode = htmlspecialchars($_POST['new_postcode']);

        $update_stmt = $db->prepare("UPDATE Orders SET address = :new_address, postcode = :new_postcode WHERE order_id = :order_id AND email = :email");
        $update_stmt->execute(['new_address' => $new_address, 'new_postcode' => $new_postcode, 'order_id' => $order_id, 'email' => $email]);

        echo "<script>alert('Address updated successfully.'); window.location.href='order_details.php?order_id=$order_id';</script>";
        exit;
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="order_details.css">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="order-details">
        <h2>Order Details (Order ID: <?= htmlspecialchars($order_id); ?>)</h2>

        <?php if (!$order_details): ?>
            <p>No details found for this order.</p>
        <?php else: ?>
            <p><strong>Delivery Address:</strong> <?= htmlspecialchars($address) ?></p>
            <p><strong>Post Code:</strong> <?= htmlspecialchars($postcode); ?></p>
            
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Review Product</th>
                </tr>
                <?php foreach ($order_details as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['product_id']); ?></td>
                        <td><?= htmlspecialchars($detail['product_name']); ?></td>
                        <td>£<?= number_format($detail['product_price'], 2); ?></td>
                        <td><?= htmlspecialchars($detail['quantity']); ?></td>
                        <td>£<?= number_format($detail['total_price'], 2); ?></td>
                        <td><a href="Reviews_Page.php?product_id=<?= htmlspecialchars($detail['product_id']); ?>">Review Product</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <br>
        <a href="Previous_Order.php" class="back-link">Back to Orders</a>

        <?php if ($order_details): ?>
            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                <button type="submit" name="cancel_order" class="cancel-order-btn">Cancel Order</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="update-address-container">
        <h2>Change Delivery Address</h2>
        <form method="POST">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id); ?>">
            
            <label for="new_address">New Address:</label>
            <input type="text" id="new_address" name="new_address" required>
            
            <label for="new_postcode">New Postcode:</label>
            <input type="text" id="new_postcode" name="new_postcode" required>
            
            <button type="submit" name="update_address">Update Address</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

