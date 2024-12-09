<?php
require_once 'connectdb.php';
session_start();

if (isset($_POST['signup'])) {
    $name = isset($_POST['full_name']) ? $_POST['full_name'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;
    $c_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $number = isset($_POST['phone_number']) ? $_POST['phone_number'] : false;

    if (!($name && $password && $c_password && $email && $number)) {
        echo "<p style='color:red'>Please fill in all fields.</p>";
    } elseif ($password !== $c_password) {
        echo "<p style='color:red'>Passwords do not match.</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                echo "<p style='color:red'>This email is already in use. Please try another.</p>";
            } else {
                try {
                    $stmt = $db->prepare("INSERT INTO users (email, full_name, password, phone_number, type) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$email, $name, $hashed_password, $number, "customer"]);

                    header("Location: Login_Page.php");
                    exit();
                } catch (PDOException $ex) {
                    echo "Failed to connect to the database.<br>";
                    echo $ex->getMessage();
                    exit;
                }
            }
        } catch (PDOException $ex) {
            echo "Failed to connect to the database.<br>";
            echo $ex->getMessage();
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Signup</title>
    <link rel="stylesheet" href="Customer_SignUp.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="signup-container">
    <h1>Customer Signup</h1>
    <form action="Customer_SignUp.php" method="post">
        <div class="form-group">
            <input type="text" id="full-name" name="full_name" placeholder=" " required>
            <label for="full-name">Full Name</label>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>
        <div class="form-group">
            <input type="password" id="confirm-password" name="confirm_password" placeholder=" " required>
            <label for="confirm-password">Confirm Password</label>
        </div>
        <div class="form-group">
            <input type="text" id="phone-number" name="phone_number" placeholder=" " required>
            <label for="phone-number">Phone Number</label>
        </div>
        <button type="submit" name="signup" class="signup-btn">Sign Up</button>
    </form>
</div>
<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
