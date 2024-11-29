<?php
require_once 'connectdb.php';
session_start(); // Start the session to manage login state

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and trim inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        // Query to fetch password and user type
        $stmt = $db->prepare('SELECT password, type FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for logged-in user
            $_SESSION['email'] = $email;
            $_SESSION['type'] = $user['type'];

            // Redirect based on user type
            if ($user['type'] === 'admin') {
                header('Location: Admin_Dashboard.php');
                exit();
            } elseif ($user['type'] === 'customer') {
                header('Location: Customer_SignUp.php');
                exit();
            }
        } else {
            // Display error message if login fails
            echo "<p style='color:red; text-align:center; margin-top:20px;'>Invalid email or password. Please try again.</p>";
        }
    } catch (PDOException $e) {
        // Display generic error message for database issues
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
    <link rel="website icon" type="jpeg" href="Tech_Nova.png"> <!--Set up the company logo as the website icon-->
    <link rel="stylesheet" href="Login_Page.css">
    <link rel="stylesheet" href="main.css"> <!--The main css for the navigation on each page.-->
</head>
<body>
  
<!-- Include the Navigation -->
<?php include 'Navbar.php'; ?>

  <!-- Login Form -->
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

  <!-- Signup Button -->
  <div class="signupbutton">
      <button type="submit" class="signup"><a href="Customer_SignUp.php">Create new account</a></button>
  </div>
</body>
</html>
