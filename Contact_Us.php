<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<script>alert('Enquiry submitted'); window.location.href='Home_page.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="Contact_Us.css">

</head>
<body>
    
    <!-- Include Navigation -->
     
    <?php include 'Navbar.php'; ?>

    <div class="main-container">

        <!-- Contact Us Section -->

        <div class="contact-container">
            <h1>Contact Us</h1>
            <form action="submit_form.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder=" " required>
                    <label>Your Name</label>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder=" " required>
                    <label>Your Email</label>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" placeholder=" " required>
                    <label>Subject</label>
                </div>
                <div class="form-group">
                    <textarea name="message" rows="5" placeholder=" " required></textarea>
                    <label>Your Message</label>
                </div>
                <button type="submit" class="contact-btn">Send Message</button>
            </form>
        </div>

        <!-- Our Details Section -->

        <div class="details-container">
            <h1>Our Details</h1>
            <p>Email: technova638@gmail.com</p>
            <p>Phone: 447893929457</p>
            <p>Address: Aston St, Birmingham B4 7ET</p>
        </div>
    </div>
    <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
