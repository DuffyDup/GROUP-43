<?php
    session_start(); // Start the session to check login status
    require 'connectdb.php'; 
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
 
    if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $stock = $stmt->fetch(PDO::FETCH_ASSOC);
   
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $product_id = $_POST['product_id'] ;
    
        if ($product_id) {
            $insertStmt = $db->prepare("INSERT INTO basket (email, product_id, quantity) VALUES (:email, :product_id, 1)");
            $insertStmt->execute([
                ':email' => $user_email,
                ':product_id' => $product_id,
            ]);
            if (!isset($_SESSION['email'])) {
                echo "<script>alert('Please log in to continue.'); window.location.href='Login_Page.php';</script>";
                exit;
            }
            echo "<script>alert('Successfully added to basket'); window.location.href='basket.php';</script>";
            }
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


        
            <form action="productdetail.php" method="post" class="add-to-basket">
            
            <?php if ($product['stock'] > 0): ?>
                <form action="productdetail.php" method="post">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                    <button type="submit" class="add-to-basket-btn">Add To Basket</button>
                </form>
            <?php else: ?>
                <button class="out-of-stock" disabled>Out of Stock</button>
            <?php endif; ?>
</form>

            </div>
            </form>

  
    </section>

    <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
