<?php
session_start(); // Start the session to check login status
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db
    //$user_email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Products</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="phone.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <div class="product-grid">
    <?php
        $stmt = $db->prepare("SELECT * FROM Products WHERE category = 'phone'");
        $stmt->execute();
        $products = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        if (!$products) {
            echo "No results found.";
        }
        foreach ($products as $row) {
    ?>
        
            <div class="product-card">
                <a href="productdetail.php?product_id=<?= urlencode($row["product_id"]) ?>">
                <img src="<?= htmlspecialchars($row["picture"]) ?>" alt="<?= htmlspecialchars($row["name"]) ?>">
                <h2><?= htmlspecialchars($row["name"]) ?></h2>
                <p><?= htmlspecialchars($row["description"]) ?></p>
                </a>
            </div>
        
        
    
    <?php }
    ?>
    </div>
</div>
<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
