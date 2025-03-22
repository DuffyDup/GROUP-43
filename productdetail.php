<?php
session_start();
require 'connectdb.php';

$user_email = $_SESSION['email'] ?? null;
$product = null;
$reviews = []; // Ensure reviews is always an array

if (isset($_GET['product_id'])) {
    $product_id = filter_var($_GET['product_id'], FILTER_VALIDATE_INT);
    if (!$product_id) {
        die("Invalid product ID.");
    }

    // Fetch product details
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

  
    $stmt = $db->prepare("SELECT users.full_name, reviews.rating, reviews.review 
                          FROM reviews 
                          JOIN users ON reviews.email = users.email 
                          WHERE reviews.product_id = :product_id 
                   ");
    $stmt->execute([':product_id' => $product_id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    if (!$user_email) {
        echo "<script>alert('Please log in to shop with us.'); window.location.href='Login_Page.php';</script>";
        exit;
    }

    $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
    $quantity = max(1, intval($_POST['quantity']));

    if ($quantity > 2) {
        echo "<script>alert('You can only purchase a maximum of 2 of each product.'); window.location.href='productdetail.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
        exit;
    }

    $stmt = $db->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product_stock = $stmt->fetchColumn();

    if ($product_stock === false) {
        echo "<script>alert('Product not found.'); window.location.href='shop.php';</script>";
        exit;
    }

    if ($quantity > $product_stock) {
        echo "<script>alert('Max quantity available is $product_stock. Please adjust your quantity.'); window.location.href='productdetail.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
        exit;
    }

    // Check if product is already in basket
    $stmt = $db->prepare("SELECT quantity FROM basket WHERE email = :email AND product_id = :product_id");
    $stmt->execute([
        ':email' => $user_email,
        ':product_id' => $product_id
    ]);
    $existing_quantity = $stmt->fetchColumn();

    if ($existing_quantity !== false) {
        if ($existing_quantity + $quantity > 2) {
            echo "<script>alert('Max product limit is 2.'); window.location.href='productdetail.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
            exit;
        }

        // Update quantity in basket
        $stmt = $db->prepare("UPDATE basket SET quantity = quantity + :quantity WHERE email = :email AND product_id = :product_id");
        $stmt->execute([
            ':quantity' => $quantity,
            ':email' => $user_email,
            ':product_id' => $product_id
        ]);
    } else {
        // Insert new entry in basket
        $stmt = $db->prepare("INSERT INTO basket (email, product_id, quantity) VALUES (:email, :product_id, :quantity)");
        $stmt->execute([
            ':email' => $user_email,
            ':product_id' => $product_id,
            ':quantity' => $quantity
        ]);
    }

    echo "<script>alert('Successfully added to basket'); window.location.href='productdetail.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="productdetail.css">
    <link rel="stylesheet" href="main.css">

    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <section class="product">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['picture']) ?>" alt="Product Image" id="productImage">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p>Price: £<?= htmlspecialchars($product['price']) ?></p>

            <div class="product-info">
                <p><?= htmlspecialchars($product['description']) ?></p>
            </div>

            <form action="productdetail.php" method="post" class="add-to-basket">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                
                <?php if ($product['stock'] > 0): ?>
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" max="<?= $product['stock'] ?>" value="1">
                    <button type="submit" class="add-to-basket-btn">Add To Basket</button>
                <?php else: ?>
                    <button class="out-of-stock" disabled>Out of Stock</button>
                <?php endif; ?>
            </form>
        </div>
    </section>

    <section class="reviews">
        <h2>Customer Reviews</h2>

        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong><?= htmlspecialchars($review['full_name']) ?></strong></p>
                    <p>⭐ <?= htmlspecialchars($review['rating']) ?>/5</p>
                    <p><?= htmlspecialchars($review['review']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
