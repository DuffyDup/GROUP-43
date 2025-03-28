<?php
session_start();
require 'connectdb.php';


if (!isset($_SESSION['email'])) {
    die("User not logged in. Please log in first.");
}

$user_email = $_SESSION['email'];

$user_query = "SELECT full_name, email FROM Users WHERE email = :email";
$user_stmt = $db->prepare($user_query);
$user_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
$user_stmt->execute();
$user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    die("User not found. Please log in again.");
}


$basket_query = "
    SELECT 
        p.product_id AS product_id,
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


$total_basket_price = $basket_result ? array_sum(array_column($basket_result, 'total_price')) : 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country = $_POST['country'] ?? '';
    $street_name = $_POST['street_name'] ?? '';
    $house_number = $_POST['house_number'] ?? '';
    $postcode = $_POST['postcode'] ?? '';

    if (empty($country) || empty($street_name) || empty($house_number) || empty($postcode)) {
        die("All address fields are required.");
    }

    $address = $house_number . ' ' . $street_name . ', ' . $country;

    try {
        $db->beginTransaction();

        
        $order_id = mt_rand(1000000000, 9999999999);

        
        $order_stmt = $db->prepare("
            INSERT INTO Orders (order_id, email, address, postcode, total_price, time_of_order)
            VALUES (:order_id, :email, :address, :postcode, :total_price, NOW())
        ");
        $order_stmt->execute([
            ':order_id' => $order_id,
            ':email' => $user_email,
            ':address' => $address,
            ':postcode' => $postcode,
            ':total_price' => $total_basket_price
        ]);

  
        $insert_stmt = $db->prepare("
            INSERT INTO Purchased (order_id, product_id, quantity)
            VALUES (:order_id, :product_id, :quantity)
        ");

        foreach ($basket_result as $row) {
            $insert_stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $row['product_id'],
                ':quantity' => $row['product_quantity']
            ]);
        }


        $clear_basket_stmt = $db->prepare("DELETE FROM Basket WHERE email = :email");
        $clear_basket_stmt->execute([':email' => $user_email]);

        $db->commit();

        $_SESSION['order_id'] = $order_id;
        echo "<script>alert('Order placed successfully! Order ID: $order_id'); window.location.href='order_confirmation.php';</script>";
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Order failed: " . $e->getMessage());
        echo "<script>alert('Failed to place order. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="stylesheet" href="Checkout_Page.css">
</head>
<body>
    <?php include 'Navbar.php';?>

    <div class="checkout-container">
        <div class="customer-details">
            <h2>Your Details</h2>
            <form action="Checkout_page.php" method="post" class="customer-form">
                <div class="form-group">
                    <input type="text" id="full-name" name="full_name" 
                           value="<?php echo htmlspecialchars($user_data['full_name'] ?? ''); ?>" 
                           placeholder="Full Name" required disabled>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" 
                           placeholder="Email" required disabled>
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

                <h2>Basket Summary</h2>
                <table border="1">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php if ($basket_result): ?>
                        <?php foreach ($basket_result as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td>£<?php echo number_format($row['product_price'], 2); ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
                                <td>£<?php echo number_format($row['total_price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>£<?php echo number_format($total_basket_price, 2); ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Your basket is empty.</td>
                        </tr>
                    <?php endif; ?>
                </table>

                <h2>Payment Details</h2>
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
</body>
</html>
