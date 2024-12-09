<?php
    session_start(); // Start the session to check login status
    require 'connectdb.php'; 
    $user_email = $_SESSION['email'];
 
    if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
   
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
            
    <input type="hidden" name="product_id" value="<?= ($product_id) ?>">
    <button type="submit" class="add-to-basket-btn">Add To Basket</button>
</form>

            </div>
            </form>

  
    </section>

    
    <footer>
        <div class="footer-links">
            <a href="terms.php">Terms</a>
            <a href="privacy.php">Privacy</a>
            <a href="help.php">Help</a>
        </div>
        <div class="contact-info">
            <p>Email: group43@gmail.com  </p>
            <p>Phone: 12345678 </p>
        </div>
    </footer>
</body>
</html>
