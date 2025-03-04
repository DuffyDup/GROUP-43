<?php
session_start();
require 'connectdb.php'; 

$user_email = $_SESSION['email'] ?? null;
$product = null;

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle adding to basket
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!$user_email) {
        echo "<script>alert('Please log in to continue.'); window.location.href='Login_Page.php';</script>";
        exit;
    }

    $product_id = $_POST['product_id'];

    // Check if the product already exists in the basket
    $stmt = $db->prepare("SELECT * FROM basket WHERE email = :email AND product_id = :product_id");
    $stmt->execute([
        ':email' => $user_email,
        ':product_id' => $product_id,
    ]);
    $existing_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_item) {
        // If the product already exists, update the quantity
        $stmt = $db->prepare("UPDATE basket SET quantity = quantity + 1 WHERE email = :email AND product_id = :product_id");
        $stmt->execute([
            ':email' => $user_email,
            ':product_id' => $product_id,
        ]);
    } else {
        // If the product doesn't exist, add a new item to the basket
        $insertStmt = $db->prepare("INSERT INTO basket (email, product_id, quantity) VALUES (:email, :product_id, 1)");
        $insertStmt->execute([
            ':email' => $user_email,
            ':product_id' => $product_id,
        ]);
    }

    echo "<script>
        alert('Successfully added to basket');
        window.location.href = 'productdetail.php?product_id=" . htmlspecialchars($product_id) . "';
    </script>";
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
</head>
<body>
    <!-- Include Navigation -->
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

            <!-- Single form for adding to basket -->
            <form action="productdetail.php" method="post" class="add-to-basket">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                
                <?php if ($product['stock'] > 0): ?>
                    <button type="submit" class="add-to-basket-btn">Add To Basket</button>
                <?php else: ?>
                    <button class="out-of-stock" disabled>Out of Stock</button>
                <?php endif; ?>
            </form>

        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
