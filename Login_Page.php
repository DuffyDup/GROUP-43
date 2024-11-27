<?php
require_once 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and trim inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Query to fetch password and user type
        $stmt = $db->prepare('SELECT password, type FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password matches
        if ($user && $password === $user['password']) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['type'] = $user['type'];

            // Redirect based on user type
            if ($user['type'] === 'admin') {
                header('Location: Admin_Signup_page.html');
                exit();
            } elseif ($user['type'] === 'customer') {
                header('Location: Customer_SignUp.html');
                exit();
            }
        } else {
            // Display a single error message
            echo "<p style='color:red; text-align:center; margin-top:20px;'>An error occurred. Please try again later.</p>";
        }

    } catch (PDOException $e) {
        // Generic error message for any DB-related issue
        echo "<p style='color:red; text-align:center; margin-top:20px;'>An error occurred. Please try again later.</p>";
        error_log("Database error: " . $e->getMessage());
    }
}
?>




<!--Manahil Firdous-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="website icon" type="jpeg" href="Tech_Nova.png"> <!--Set up the company logo as the website icon-->
    <link rel="stylesheet" href="Login_Page.css">
    <link rel="stylesheet" href="main.css"> <!--The main css for the navigation on each page.-->
</head>
<body>
  <!--The Navigation (Start)-->
    <div class="top-navigation">
        <a href="Home_Page.html">Home</a>
        <a href="#">About US</a>
        <a href="#">Contact Us</a>
        <a href="Login_Page.html">Login</a>
    
        <!-- Dropdown for Products -->
        <div class="menu-dropdown">
          <button class="menu-button">Products
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="menu-options">
            <a href="#">Phone</a>
            <a href="#">Tablets</a>
            <a href="#">Laptops</a>
            <a href="#">Audio Devices</a>
            <a href="#">Smart Watches</a>
          </div>
        </div>
    
        <!-- Dropdown for Basket -->
        <div class="cart-dropdown">
          <button class="cart-button">Basket
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="cart-options">
            <a href="#">Basket</a>
            <a href="#">Previous Order</a>
          </div>
        </div>
      </div>
    <!--The Navigation (End)-->

    <div class="loginuser">
      <form id="loginforuser" method="POST" action="Login_page.php">
        <input type="email" name="email" placeholder="Email" class="entrybox" required><br><br>
        <input type="password" name="password" placeholder="Password" class="entrybox" required><br><br>
        <label for="forgetpasswordlabel"><a href="Forgot_Password_Page.html">Forgot password?</a></label><br>
        <label for="keeplogedinlabel">Keep me Logged in</label>
        <input type="checkbox" id="keeplogedin"><br><br>
        <button type="submit" class="loged">Login</button>
        
    </form>
    
    </div>
    <div class="signupbutton">
        <button type="submit" class="signup"><a href="Customer_SignUp.php">Create new account</a></button>
    </div>
</body>
</html>

