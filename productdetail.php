<?php
session_start();
require 'connectdb.php';

$user_email = $_SESSION['email'] ?? null;
$product = null;
$reviews = [];

if (isset($_GET['product_id'])) {
    $product_id = filter_var($_GET['product_id'], FILTER_VALIDATE_INT);
    if (!$product_id) {
        die("Invalid product ID.");
    }

    // Fetch product details
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch product reviews
    $stmt = $db->prepare("SELECT r.rating, r.review, u.full_name, r.email, r.product_id
                          FROM Reviews r
                          JOIN Users u ON r.email = u.email
                          WHERE r.product_id = :product_id
                          ORDER BY r.product_id DESC");
    $stmt->execute([':product_id' => $product_id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <section class="product">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['picture']) ?>" alt="Product Image">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p>Price: £<?= htmlspecialchars($product['price']) ?></p>
            <p><?= htmlspecialchars($product['description']) ?></p>

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

        <?php if (count($reviews) > 0): ?>
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
