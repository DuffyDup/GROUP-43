<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Signup Page</title>
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="Admin_signup_page.css">
</head>
<body>
  
  <!-- Include the Navigation -->
  <?php include 'Navbar.php'; ?>

  <!-- Signup Form -->
  <div class="signup-container">
    <h1>Admin Signup</h1>
    <form action="submit_admin_signup.php" method="post">
      <div class="form-group">
        <input type="text" id="username" name="username" placeholder=" " required>
        <label for="username">Name</label>
      </div>
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder=" " required>
        <label for="email">Email</label>
      </div>
      <div class="form-group">
        <input type="text" id="phone-number" name="phone_number" placeholder=" " required>
        <label for="phone-number">Phone Number</label>
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
        <input type="password" id="admin-code" name="admin_code" placeholder=" " required>
        <label for="admin-code">Admin Access Code</label>
      </div>
      <button type="submit" class="signup-btn">Sign Up</button>
    </form>
  </div>

</body>
</html>
