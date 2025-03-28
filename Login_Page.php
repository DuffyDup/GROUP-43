<?php
require_once 'connectdb.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $stmt = $db->prepare('SELECT password, type FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['type'] = $user['type'];

            if ($user['type'] === 'admin') {
                header('Location: Home_page.php');
                exit();
            } elseif ($user['type'] === 'customer') {
                header('Location: Home_page.php');
                exit();
            }
        } else {
            echo "<p style='color:red; text-align:center; margin-top:20px;'>Invalid email or password.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center; margin-top:20px;'>An error occurred. Please try again later.</p>";
        error_log("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login_Page.css">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="loginuser">
    <h1>Login</h1>
    <form id="loginforuser" method="POST" action="Login_Page.php">
        <input type="email" name="email" placeholder="Email" class="entrybox" required><br><br>
        <input type="password" name="password" placeholder="Password" class="entrybox" required><br><br>
        <label for="forgetpasswordlabel"><a href="Forgot_Password_Page.php">Forgot password?</a></label><br>
        <label for="keeplogedinlabel">Keep me Logged in</label>
        <input type="checkbox" id="keeplogedin"><br><br>
        
        <!-- Login Button -->
        <button type="submit" class="loged">Login</button><br><br>
        
        <!-- Create New Account Button -->
        <button type="button" class="signup"><a href="Customer_SignUp.php" style="color:white; text-decoration:none;">Create new account</a></button>
    </form>
</div>
<br>
<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>
