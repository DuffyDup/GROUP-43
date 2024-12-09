<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Watches</title>
    <link rel="stylesheet" href="smartwatches.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="product-container">
    <div class="product-grid">
    <?php
        $stmt = $db->prepare("SELECT * FROM Products WHERE category = 'headphones'");
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


</body>
</html>
