<?php
session_start();

require_once 'connectdb.php';


if (!isset($_SESSION['email'])) {
    echo "Please log in to view your previous orders.";
    exit;
}

$email = $_SESSION['email']; 


$query = "
    SELECT 
        p.email, 
        p.order_id,
        p.product_id, 
        p.quantity, 
        pr.name AS product_name, 
        pr.price AS product_price, 
        (p.quantity * pr.price) AS total_price
    FROM Purchased p
    JOIN Products pr ON p.product_id = pr.product_id
    WHERE p.email = :email
    ORDER BY p.product_id DESC
";

try {
  
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();


    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching orders: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Previous Orders</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="previous-orders">
        <h2>Your Previous Orders</h2>

        <?php if (empty($orders)): ?>
            <p>You have no previous orders.</p>
        <?php else: ?>
            <table border="1">
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>   
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td>£<?php echo number_format($order['product_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td>£<?php echo number_format($order['total_price'], 2); ?></td>

                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
