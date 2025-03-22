<?php
require 'connectdb.php'; // Include database connection

// Get the category dynamically based on the page
$category = "";
if (basename($_SERVER['PHP_SELF']) == "Phone.php") {
    $category = "phone";
} elseif (basename($_SERVER['PHP_SELF']) == "laptops.php") {
    $category = "laptop";
} elseif (basename($_SERVER['PHP_SELF']) == "smartwatches.php") {
    $category = "watch";
} elseif (basename($_SERVER['PHP_SELF']) == "audiodevices.php") {
    $category = "headphone";
} elseif (basename($_SERVER['PHP_SELF']) == "tablets.php") {
    $category = "ipad";
}

// Start building the query to filter only products in the detected category
$query = "SELECT * FROM products WHERE category = :category";

if (!empty($_GET['min_price'])) {
    $query .= " AND price >= :min_price";
}

if (!empty($_GET['max_price'])) {
    $query .= " AND price <= :max_price";
}

// Prepare and execute the SQL query
$statement = $db->prepare($query);
$statement->bindParam(':category', $category, PDO::PARAM_STR);

if (!empty($_GET['min_price'])) {
    $statement->bindParam(':min_price', $_GET['min_price'], PDO::PARAM_INT);
}
if (!empty($_GET['max_price'])) {
    $statement->bindParam(':max_price', $_GET['max_price'], PDO::PARAM_INT);
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="products.css">
</head>
<body>
   
    <div class="filter-container">
        <!-- Filter Bar -->
        <form method="GET" action="">
            <b><label for="min_price">Min Price:</label>
            <input type="number" name="min_price" min="0" step="0.01" value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '' ?>">
            <br> 
            <label for="max_price">Max Price:</label>
            <input type="number" name="max_price" min="0" step="0.01" value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '' ?>">
            <br></b>
            <button type="submit">Filter</button>
        </form>
    </div>


<!-- Product Grid -->
    <div class="product-container">
        <div class="product-grid">
            <?php if (!empty($products)): ?> 
                <?php foreach ($products as $row): ?>
                    <div class="product-card">
                        <a href="productdetail.php?product_id=<?= htmlspecialchars($row['product_id']) ?>">
                            <img src="<?= htmlspecialchars($row['picture']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                            <h2><?= htmlspecialchars($row['name']) ?></h2>
                            <p><?= htmlspecialchars($row['description']) ?></p>
                            <p>£<?= htmlspecialchars($row['price']) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Sorry, no products are in this price range.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
