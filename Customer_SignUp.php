<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Signup</title>
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="Customer_SignUp.css">
</head>
<body>

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
   <a href="Login_Page.html">Login</a>

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

  <!-- Signup Form -->
  <div class="signup-container">
    <h1>Customer Signup</h1>
    <form action="Customer_SignUp.php" method="post">
      <div class="form-group">
    <form method="post" action="Customer_SignUp.php">      
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
      <button type="submit"  class="signup-btn">Sign Up</button>
      <input type="hidden" name="signup" value="True">
    </form>
  </div>

</body>
<?php
  if (isset($_POST['signup'])){

    //connect to database
    require_once("connectdb.php");

    //save input fields to variable 
    $name = isset($_POST['full_name'])?$_POST['full_name']:false;
    $password = isset($_POST['password'])?$_POST['password']:false;
    $c_password = isset($_POST['confirm_password'])?$_POST['confirm_password']:false;
    $email = isset($_POST['email'])?$_POST['email']:false;
    $number = isset($_POST['phone_number'])?$_POST['phone_number']:false;

    //check if all fields are filled
    if(!($name && $password && $c_password && $email && $number)){
        echo "<p style='color:red'>please fill in all registary input fields before trying to create an account";
    }

    //check if password is same as confirm password
    elseif ($password!=$c_password){
        echo "<p style='color:red'>passwords dont match";
    }

    
    else{
      //hash pasword for data security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      try {
        //search database for account maching email
        $stat = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stat->execute(array($_POST['email']));
            
        // check if a row with email is returned
        if ($stat->rowCount() > 0) {  
            // display message if there is
            echo "<p style='color:red'>This email is already in use. Please select another or login to your account";
        } else {
            try {
                // Register user by inserting user info
                $stat = $db->prepare("INSERT INTO users VALUES (?,?,?,?,?)");
                $stat->execute(array($email,$name, $hashed_password, $number,"customer"));
                
                $id = $db->lastInsertId();
                echo "<p style='color:green'>Account created please log in.<br>";

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

</html>
