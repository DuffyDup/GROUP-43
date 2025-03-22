<?php
session_start(); // Start the session to check login status
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db

// Import PHPMailer - for email notification feature
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require "vendor/autoload.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'admin') {
    header('Location: Login_Page.php');
    exit();
}

try {
    $stmt = $db->query("SELECT * FROM Products ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage();
    exit();
}


if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    try {
        $updateQuery = "UPDATE Products SET  price = ?, stock = ? WHERE product_id = ?";
        $statement=$db->prepare($updateQuery);
        $result=$statement->execute([$price,$stock,$product_id ]);

        echo "<script>alert('Details updated successfully.');</script>";
        header("Refresh:0");
    } catch (PDOException $e) {
        echo "Error updating details: " . $e->getMessage();
    }
}

if (isset($_POST['delete_product']) ) {
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];

    try {
        $deleteStmt = $db->prepare("DELETE FROM products WHERE product_id = :product_id");
        $deleteStmt->execute(['product_id' => $product_id]);
        unlink($product_image);

        echo "<script>alert('Product deleted successfully.');</script>";
        header("Refresh:0");
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
}

if (isset($_POST['add_product'])) {
    $product_name2 = $_POST['product_name2'];
    $product_description2 = $_POST['product_description2'];
    $price2 = $_POST['price2'];
    $stock2 = $_POST['stock2'];
    $category2 = $_POST['category2']; 

    // Define category-to-folder mapping
    $category_folders = [
        "laptop" => "Laptops/",
        "phone" => "Phones/",
        "watch" => "Smart_watch_images/",
        "ipad" => "Tablet_images/",
        "headphone" => "Audio_Devices_images/"
    ];

    $upload_directory = $category_folders[$category2]; // Get correct folder

    // Check if a file was uploaded
    if (isset($_FILES['product_image2']) && $_FILES['product_image2']['error'] == 0) {
        $file_tmp = $_FILES['product_image2']['tmp_name'];
        $file_name = $_FILES['product_image2']['name'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validate file type (only allow PNG)
        if ($file_extension !== 'png') {
            echo "<p style='color:red'>Please upload a PNG file.</p>";
            exit();
        }

        // Define the destination path
        $destination = $upload_directory . basename($file_name);

        // Move file to correct category folder
        if (move_uploaded_file($file_tmp, $destination)) {
            try {
                // Check if product already exists
                $stmt = $db->prepare('SELECT * FROM products WHERE name = ?');
                $stmt->execute([$product_name2]);

                if ($stmt->rowCount() > 0) {
                    echo "<p style='color:red'>This product already exists. Use the table above to update stock.</p>";
                } else {
                    // Insert into database with correct image path
                    $addstmt = $db->prepare("INSERT INTO Products (name, picture, description, stock, category, price) VALUES (?, ?, ?, ?, ?, ?)");
                    $addstmt->execute([$product_name2, $destination, $product_description2, $stock2, $category2, $price2]);

                    echo "<script>alert('Product added successfully.');</script>";
                    
                    // Notifying users by email that a new product is added
                    if ($addstmt->rowCount() > 0) { // If a product is added
                        try {
                            // Fetch all user emails from the database
                            $stmt = $db->query("SELECT email FROM users");
                            $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Configure PHPMailer
                            $mail = new PHPMailer(true);
                            $mail->isSMTP();
                            $mail->SMTPAuth = true;
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;
                            
                            // Set up technova email
                            $mail->Username = "TechNova638@gmail.com";
                            $mail->Password = "lvzniwmsqkhqalxe";

                            // Email content
                            $mail->Subject = "NEW STOCK ALERT: $product_name2";
                            $mail->Body = "$product_name2 is now in stock! \n\nDescription: $product_description2\nCheck it out on the TechNova website!";

                            foreach ($users as $user_email) {
                                $mail->addAddress($user_email); 
                                $mail->send(); // Send to users
                                $mail->clearAddresses(); // Reset for next email
                            }

                        } catch (Exception $e) {
                            echo "<p style='color:red'>Mailer Error: " . $mail->ErrorInfo . "</p>"; // mail error for debugging info
                        }
                    }
                    
                    header("Refresh:0");
                }
            } catch (PDOException $e) {
                echo "Error adding product: " . $e->getMessage();
            }
        } else {
            echo "<p style='color:red'>Error moving the uploaded file.</p>";
        }
    } else {
        echo "<p style='color:red'>Error uploading image.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="product_update.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="dashboard-container">
        <h2>Manage Products</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $products): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($products['product_id']) ?></td>
                            <td><p><img class=product-image src="<?= htmlspecialchars($products["picture"]) ?>" alt="<?= htmlspecialchars($products["name"]) ?>"style="width: 150px; height: 150px;"></p>
                            <p><?= htmlspecialchars($products['name']) ?></p></td>
                            
                            <td><input type="number" step="0.01" name="price" value="<?= htmlspecialchars($products['price']) ?>" min="0" required></td>
                            <td><input type="number" name="stock" value="<?= htmlspecialchars($products['stock']) ?>" min="0" required></td>
                            <td><?= htmlspecialchars($products['category']) ?></td>

                            <td>
                                <button type="submit" name="update_product" class="btn update-btn">Update</button>
                                <button type="submit" name="delete_product" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($products['product_id']) ?>">
                                <input type="hidden" name="product_image" value="<?= htmlspecialchars($products['picture']) ?>">
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Add Product</h2>
        <form method="POST" enctype="multipart/form-data" class="inventory-form">
            <input type="text" name="product_name2" placeholder="Product Name" required>
            <input type="text" name="product_description2" placeholder="Description" required>
            <input type="number" step="0.01" name="price2" placeholder="Price" required>
            <input type="number" name="stock2" placeholder="Stock" required>

            <select name="category2" required>
                <option value="">Select Category</option>
                <option value="phone">Phone</option>
                <option value="watch">Watch</option>
                <option value="ipad">iPad</option>
                <option value="laptop">Laptop</option>
                <option value="headphone">Headphone</option>
            </select>

            <input type="file" name="product_image2" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>

<!-- Footer -->
<?php include 'footer.php'; ?>
<script src="theme.js" defer></script>

</body>
</html>