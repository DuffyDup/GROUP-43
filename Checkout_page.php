<?php
session_start();
require 'connectdb.php';

$user_email = $_SESSION['email'];

$user_query = "SELECT full_name, email FROM Users WHERE email = :email";
$user_stmt = $db->prepare($user_query);
$user_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
$user_stmt->execute();
$user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);

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

$total_basket_price = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $country = $_POST['country'];
    $street_name = $_POST['street_name'];
    $house_number = $_POST['house_number'];
    $postcode = $_POST['postcode'];
    $address = $street_name . ' ' . $house_number . ', ' . $postcode . ', ' . $country;

    try {
        $db->beginTransaction();


        foreach ($basket_result as $row) {
            $insert_query = "
                INSERT INTO Purchased (email, product_id, quantity)
                VALUES (:email, :product_id, :quantity)
            ";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
            $insert_stmt->bindValue(':product_id', $row['product_id'], PDO::PARAM_INT);
            $insert_stmt->bindValue(':quantity', $row['product_quantity'], PDO::PARAM_INT);
       
            $insert_stmt->execute();
        }

     
        $clear_basket_query = "DELETE FROM Basket WHERE email = :email";
        $clear_basket_stmt = $db->prepare($clear_basket_query);
        $clear_basket_stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
        $clear_basket_stmt->execute();

        $db->commit();

        echo "<script>alert('Order placed successfully!'); window.location.href='Home_page.php';</script>";
    } catch (Exception $e) {
        $db->rollBack();
        echo "<script>alert('Failed to place order: " . htmlspecialchars($e->getMessage()) . "');</script>";
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
    <link rel="stylesheet" href="Checkout_Page.css">
</head>
<body>
    <?php include 'Navbar.php';?>

    <div class="checkout-container">
        <div class="customer-details">
            <h2>Your Details</h2>
            <form action="Checkout_page.php" method="post" class="customer-form">
                <div class="form-group">
                    <input type="text" id="full-name" name="full_name" value="<?php echo ($user_data['full_name']); ?>" placeholder="Full Name" required disabled>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" value="<?php echo ($user_data['email']); ?>" placeholder="Email" required disabled>
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
                    <?php foreach ($basket_result as $row): 
                        $total_basket_price += $row['total_price'];
                    ?>
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
    <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
