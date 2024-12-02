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
                header('Location: Admin_Signup_page.php');
                exit();
            } elseif ($user['type'] === 'customer') {
                header('Location: Customer_SignUp.php');
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
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="loginuser">
    <form id="loginforuser" method="POST" action="Login_Page.php">
        <input type="email" name="email" placeholder="Email" class="entrybox" required><br><br>
        <input type="password" name="password" placeholder="Password" class="entrybox" required><br><br>
        <label for="forgetpasswordlabel"><a href="Forgot_Password_Page.html">Forgot password?</a></label><br>
        <label for="keeplogedinlabel">Keep me Logged in</label>
        <input type="checkbox" id="keeplogedin"><br><br>
        <button type="submit" class="loged">Login</button>
    </form>
</div>

<div class="signupbutton">
    <button class="signup"><a href="Customer_SignUp.php">Create new account</a></button>
</div>

</body>
</html>
