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
    $stmt = $db->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'], $_POST['rating'], $_POST['product_id'])) {
    if (!$user_email) {
        echo "<script>alert('Please log in to leave a review.'); window.location.href='Login_Page.php';</script>";
        exit;
    }

    $comment = trim($_POST['review']);
    $rating = filter_var($_POST['rating'], FILTER_VALIDATE_INT);
    $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);

    if (!$comment || !$rating || $rating < 1 || $rating > 5) {
        echo "<script>alert('Invalid comment or rating.'); window.location.href='Reviews_Page.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
        exit;
    }

    // Insert review into database (removed `created_at`)
    $stmt = $db->prepare("INSERT INTO reviews (product_id, email, rating, review) VALUES (:product_id, :email, :rating, :review)");
    $stmt->execute([
        ':product_id' => $product_id,
        ':email' => $user_email,
        ':rating' => $rating,
        ':review' => $comment
    ]);

    echo "<script>alert('Review submitted successfully.'); window.location.href='Reviews_Page.php?product_id=" . htmlspecialchars($product_id) . "';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="Reviews_Page.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <?php if ($product): ?>
            <div class="product-image">
                <img src="<?= htmlspecialchars($product['picture']) ?>" alt="Product Image" id="productImage">
            </div>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p>Price: £<?php echo htmlspecialchars($product['price']); ?></p>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>

        <h3>Leave a Review</h3>
        <?php if ($user_email): ?>
            <form method="post">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required>
                <br>
                <label for="review">Comment:</label>
                <textarea name="review" id="review" required></textarea>
                <br>
                <button type="submit">Submit Review</button>
            </form>
        <?php else: ?>
            <p>Please <a href="Login_Page.php">log in</a> to leave a review.</p>
        <?php endif; ?>

        <h3>Reviews</h3>
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-box">
                    <p><strong><?php echo htmlspecialchars($review['email']); ?></strong> (<?php echo htmlspecialchars($review['rating']); ?>/5)</p>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
