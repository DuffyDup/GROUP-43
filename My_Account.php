<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: Login_Page.php");
    exit();
}

require 'connectdb.php'; 

$email = $_SESSION['email'];
$user = [];

try {
    // Fetch user details from the database
    $stmt = $db->prepare("SELECT full_name, email, password, phone_number FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Failed to fetch user details. Please try again later.');</script>";
    exit();
}

// Handle form submission for updating account details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-changes'])) {
    $full_name = $_POST['full_name'];
    $new_email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = $_POST['phone_number'];

    // Validate form input
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        try {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update user details in the database
            $stmt = $db->prepare("UPDATE users SET full_name = :full_name, email = :new_email, password = :password, phone_number = :phone_number WHERE email = :current_email");
            $stmt->execute([
                'full_name' => $full_name,
                'new_email' => $new_email,
                'password' => $hashed_password,
                'phone_number' => $phone_number,
                'current_email' => $email,
            ]);

            // Update session email if the email was changed
            if ($new_email !== $email) {
                $_SESSION['email'] = $new_email;
            }

            echo "<script>alert('Account details updated successfully.');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error updating user details: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="Customer_SignUp.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="signup-container">
    <h1>My Account</h1>
    <form action="My_Account.php" method="post">
        <div class="form-group">
            <input type="text" id="full-name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" placeholder=" " required>
            <label for="full-name">Full Name</label>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder=" " required>
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
            <input type="text" id="phone-number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" placeholder=" " required>
            <label for="phone-number">Phone Number</label>
        </div>
        <button type="submit" name="submit-changes" class="signup-btn">Confirm Changes</button>
    </form>
</div>

</body>
</html>
