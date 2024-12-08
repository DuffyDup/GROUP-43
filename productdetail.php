<?php
    session_start(); // Start the session to check login status
    require 'connectdb.php'; // Ensure this initializes a PDO connection in $db
    $user_email = $_SESSION['email'];
    // Check if 'product_id' is set in the URL
    if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details from the database using product_id
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
   
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="productdetail.css">
</head>
<body>
    
    <header>
        <div class="logo">
            <img src="Tech_Nova.png" alt="Product Logo">
        </div>
        <nav>
            <ul>
               <li><a href="">Home</a></li> 
               <li> <a href="">About Us</a></li>
               <li> <a href="">Contact Us</a></li>
               <li> <a href="Login_Page.php">Login</a></li>
               <li> <a href="products.php">Products</a> </li>
              <li> <a href="basket.php">Basket</a></li> 
            </ul>
        </nav>
    </header>

    
    <section class="product">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['picture']) ?>" alt="Product Image" id="productImage">
           
        </div>
        <div class="product-details">
            <h1>Name: <?= htmlspecialchars($product['name']) ?></h1>
            <p>Price: £<?= htmlspecialchars($product['price']) ?></p>

            
            <div class="product-info">
                <p><?= htmlspecialchars($product['description']) ?></p>
            </div>

          
            <div class="color-options">
                <span>Color: </span>
                <div class="color-circle" style="background-color: red;"></div>
                <div class="color-circle" style="background-color: blue;"></div>
                <div class="color-circle" style="background-color: black;"></div>
            </div>

          
            <div class="add-to-basket">
                <button>Add to Basket</button>
            </div>
        </div>
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
