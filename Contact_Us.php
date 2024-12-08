<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="contactus.css">
</head>
<body>

<!-- Include Navigation -->
<?php include 'Navbar.php'; ?>

<div class="contact-container">
    <h1>Contact Us</h1>
    <form action="contactus_submit.php" method="post">
        <div class="form-group">
            <input type="text" id="name" name="name" placeholder=" " required>
            <label for="name">Name</label>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
        </div>
        <div class="form-group">
            <input type="text" id="subject" name="subject" placeholder=" " required>
            <label for="subject">Subject</label>
        </div>
        <div class="form-group">
            <textarea id="message" name="message" placeholder=" " required></textarea>
            <label for="message">Message</label>
        </div>
        <button type="submit" class="contact-btn">Send Message</button>
    </form>
</div>

</body>
</html>
