<?php
session_start(); // Start the session to check login status
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablets</title>
    <link rel="stylesheet" href="tablets.css">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>

<!-- Include Navigation and Filter Bar -->
<?php include 'Navbar.php';?>
<?php include 'filterbar.php'; ?>

<br>
<!-- Footer -->
<?php include 'footer.php'; ?>
<script src="theme.js" defer></script>

</body>
</html>
