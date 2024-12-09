<?php
session_start();
require 'connectdb.php';

// Handle search form submission
if (isset($_GET['query'])) {
    $search = $_GET['query'];
    // Construct the SQL query
    $query = "SELECT * FROM products WHERE name LIKE :search";
    // Prepare and execute the SQL query
    $statement = $db->prepare($query);
    $statement->execute(array(
        ':search' => '%' . $search . '%'
    ));
    // Fetch results - the matching products
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
} else{
    // No results since query is empty
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="phone.css">
</head>
<body>
    <!-- include navigation bar -->
    <?php include 'Navbar.php'; ?>

    <div class="product-container">
        <h1>Search Results</h1>
        <div class="product-grid">
            <?php if (!empty($products)): // display if there are products found ?> 
                <?php foreach ($products as $row): ?>
                    <div class="product-card">
                        <a href="productdetail.php?product_id=<?= htmlspecialchars($row['product_id']) ?>">
                            <img src="<?= htmlspecialchars($row['picture']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" >
                            <h2><?= htmlspecialchars($row['name']) ?></h2>
                            <p><?= htmlspecialchars($row['description']) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: // display message for no products found ?>
                <p>Sorry, no products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- include footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
