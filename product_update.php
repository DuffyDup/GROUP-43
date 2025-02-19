<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Update</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'Navbar.php'; ?>
    
    <!-- Body -->
    <div class="dashboard-container">
        <!-- Products Table -->
        <h2>Manage Products</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Stock</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <form method="POST">
                            <td></td>
                            <td><input type="text" name="product_name" required></td>
                            <td><input type="text" name="product_description" required></td>
                            <td><input type="number" name="stock" required></td>
                            <td>
                                <button type="submit" name="update_product" class="btn update-btn">Update</button>
                                <button type="submit" name="delete_product" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                <!--<input type="" name="" value="">-->
                            </td>
                        </form>
                    </tr>
            </tbody>
        </table>

        <!-- Add Product Table -->
        <h2>Add Product</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <form method="POST">
                            <td></td>
                            <td><input type="text" name="product_name" required></td>
                            <td><input type="text" name="product_description" required></td>
                            <td><input type="number" name="stock" required></td>
                            <td>
                                <button type="submit" name="add_product" class="btn update-btn">Add</button>
                                <button type="submit" name="cancel_product" class="btn delete-btn" onclick="return confirm('Are you sure you want to cancel this update?');">Cancel</button>
                                <!--<input type="hidden" name="email" value="">-->
                            </td>
                        </form>
                    </tr>
            </tbody>
        </table>
    </div>
    <br><br>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>