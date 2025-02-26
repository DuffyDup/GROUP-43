<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Inventory</title>
    <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="product_update.css">
</head>
<body>
    <?php include 'Navbar.php'; ?>
    <div class="dashboard-container">
        <h2>Manage Products</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>

        <h2>Add Product</h2>
<form method="POST" enctype="multipart/form-data" class="inventory-form">
    <input type="text" name="product_name" placeholder="Product Name" required>
    <input type="text" name="product_description" placeholder="Description" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <input type="file" name="product_image">
    <button type="submit" name="add_product">Add Product</button>
</form>

    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
