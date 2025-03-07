<?php
session_start();
require_once 'connectdb.php';

if (!isset($_SESSION['email'])) {
    echo "Please log in to view your order details.";
    exit;
}

if (!isset($_GET['order_id'])) {
    echo "Invalid order request.";
    exit;
}

$order_id = $_GET['order_id'];
$email = $_SESSION['email'];

$query = "
    SELECT 
        p.product_id, 
        p.quantity, 
        pr.name AS product_name, 
        pr.price AS product_price, 
        (p.quantity * pr.price) AS total_price
    FROM Purchased p
    JOIN Products pr ON p.product_id = pr.product_id
    WHERE p.order_id = :order_id AND p.email = :email
";

try {
    $stmt = $db->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching order details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - <?php echo htmlspecialchars($order_id); ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="order-details">
        <h2>Order Details (Order ID: <?php echo htmlspecialchars($order_id); ?>)</h2>

        <?php if (empty($order_details)): ?>
            <p>No details found for this order.</p>
        <?php else: ?>
            <table border="1">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php foreach ($order_details as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                        <td>£<?php echo number_format($detail['product_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                        <td>£<?php echo number_format($detail['total_price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <br>
        <a href="Previous_Order.php">Back to Orders</a>
    </div>

<?php include 'footer.php'; ?>
</body>
</html>
