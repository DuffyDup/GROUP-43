<?php

require_once 'connectdb.php';




if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $product_id = $_GET['remove'];

 
    $stmt = $db->prepare("DELETE FROM basket WHERE email = :email AND product_id = :product_id");
    $stmt->execute([':email' => $user_email, ':product_id' => $product_id]);

  
    header('Location: basket.php');
    exit();
}


$stmt = $db->prepare("
    SELECT 
      b.quantity, p.product_id,p.name,p.description,p.price,p.picture FROM basket b JOIN products p ON b.product_id = p.product_id WHERE b.email = :email
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart Layout</title>
    <link rel="stylesheet" href="basket.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Tech_Nova.png" alt="Logo">
        </div>
        <nav class="navigation">
            <a href="">Home</a>
            <a href="">About Us</a>
            <a href="">Contact Us</a>
            <a href="">Login</a>
            <a href="">Products</a>
            <a href="">Basket</a>
            

        </nav>
    </header>

    <div class="container">
        <div class="cart-item">
            <div class="item-image">
                <img src="" alt="Item 1">
            </div>
            <div class="item-details">
                <h3>Item Name</h3>
                <p>Item Description</p>
                <p>Price: </p>
                <label>Quantity:</label>
                <input type="number" value="1">
                <button>Remove</button>
            </div>
        </div>

        <div class="cart-item">
            <div class="item-image">
                <img src="" alt="Item 2">
            </div>
            <div class="item-details">
                <h3>Item Name</h3>
                <p>Item Description</p>
                <p>Price:</p>
                <label>Quantity:</label>
                <input type="number" value="1">
                <button>Remove</button>
            </div>
        </div>

        <div class="total-price">
            <p>Total Price: </p>
        </div>

        <button class="checkout">Checkout</button>
    </div>

    <footer>
        <div class="footer-links">
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
        </div>
        <div class="contact-info">
            <p></p>
            <p></p>
        </div>
    </footer>
</body>
</html>
