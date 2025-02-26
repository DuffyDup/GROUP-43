<?php
require_once 'connectdb.php';
session_start(); 



$user_email = $_SESSION['email'];

if (isset($_GET['remove']) ) {
    $product_id = $_GET['remove'];

    $stmt = $db->prepare("DELETE FROM basket WHERE email = :email AND product_id = :product_id");
    $stmt->execute([':email' => $user_email, ':product_id' => $product_id]);

    header('Location: basket.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $stmt = $db->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > $product['stock']) {
                        echo 
       "<script>
        alert('Max quantity is {$product['stock']}. Please adjust quantity.');
        window.location.href = 'basket.php'; 
    </script>";
                         exit();
    } else {
    if ($quantity > 0) {
        $stmt = $db->prepare("UPDATE basket SET quantity = :quantity WHERE email = :email AND product_id = :product_id");
        $stmt->execute([':quantity' => $quantity, ':email' => $user_email, ':product_id' => $product_id]);
    } else {
        
        $stmt = $db->prepare("DELETE FROM basket WHERE email = :email AND product_id = :product_id");
        $stmt->execute([':email' => $user_email, ':product_id' => $product_id]);
    }

    header('Location: basket.php');
    exit();
}
}

$stmt = $db->prepare("
    SELECT 
        b.quantity, p.product_id, p.name, p.description, p.price, 
         p.picture,p.stock FROM basket b JOIN products p ON b.product_id = p.product_id WHERE b.email = :email
");
$stmt->execute([':email' => $user_email]);
$basket_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;
foreach ($basket_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket</title>
    <link rel="stylesheet" href="basket.css">
    <link rel="stylesheet" href="main.css">
    
</head>
<body>
    <!-- Include the Navigation -->
  <?php include 'Navbar.php'; ?>

    <div class="container">
        <h1>Your Basket</h1>

        <?php if ($basket_items): ?>
            <?php foreach ($basket_items as $item): ?>
                <div class="cart-item">
                    <div class="item-image">
                        <img src="<?php echo ($item['picture']); ?>" alt="<?php echo ($item['name']); ?>">
                    </div>
                    <div class="item-details">
                        <h3><?php echo ($item['name']); ?></h3>
                        <p><?php echo ($item['description']); ?></p>
                        <p>Price: £<?php echo number_format($item['price'], 2); ?></p>
                        <form method="POST" action="basket.php">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <label for="quantity-<?php echo $item['product_id']; ?>">Quantity:</label>
                            <input id="quantity-<?php echo $item['product_id']; ?>" type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0">
                            <button type="submit">Update</button>
                        </form>
                        <a href="basket.php?remove=<?php echo $item['product_id']; ?>">
                            <button>Remove</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="total-price">
                <p>Total Price: £<?php echo number_format($total_price, 2); ?></p>
            </div>

            <button class="checkout">
    <a href="Checkout_page.php">Proceed to Checkout</a>
</button>
        <?php else: ?>
            <p>Your basket is empty.</p>
        <?php endif; ?>
    </div>

 
    <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
        