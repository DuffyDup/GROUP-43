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
  <!-- Navigation -->
  <div class="top-navigation">
    
    <!-- Logo -->
    <a href="Home_Page.html" class="logo">
     <img src="Tech_Nova.png" alt="Tech Nova Logo">
    </a>

     <!-- Navigation Links -->
   <a href="Home_Page.html">Home</a>
   <a href="#">About Us</a>
   <a href="#">Contact Us</a>
   <a href="Login_Page.php">Login</a>

   <!-- Dropdown for Products -->
   <div class="menu-dropdown">
     <button class="menu-button">Products</button>
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
     <button class="cart-button">Basket</button>
     <div class="cart-options">
       <a href="#">Basket</a>
       <a href="#">Previous Order</a>
     </div>
   </div>
 </div>
    <!--The Navigation (End)-->

    <div class="loginuser">
        <form id="loginforuser" method="POST">
            <input type="email" placeholder="Email" class="entrybox" required> <br> <br>
            <input type="password" placeholder="Password" class="entrybox" required> <br> <br>
            <label for="forgetpasswordlabel"><a href="Forgot_Password_Page.html">Forgot password?</a></label> <br>
            <label for="keeplogedinlabel">Keep me Logged in </label>
            <input type="checkbox" id="keeplogedin"> 
            <br> <br> <br>
            <button type="submit" class="loged">Login</button>
        </form>
    </div>
    <div class="signupbutton">
        <button type="submit" class="signup"><a href="Customer_SignUp.php">Create new account</a></button>
    </div>
</body>
</html>

<script>
    /**
     * Function to check for login details
     * Admin login
     * Customer login
     */
</script>
