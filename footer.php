<?php
// footer.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        
        .custom-footer {
            background-color: #f9f9f9;
            padding: 20px;
            border-top: 1px solid #ccc;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: space-evenly; 
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-item a {
            text-decoration: none;
            color: black;
            font-size: 16px; 
            padding: 5px 10px; 
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .footer-item a:hover {
            background-color: grey; /* Grey hover effect */
            color: white;
        }
    </style>
</head>
<body>
    <footer class="custom-footer">
        <div class="footer-container">
            <div class="footer-item">
                <a href="Contact_Us.php">Contact Us</a>
            </div>
            <div class="footer-item">
                <a href="About_us_page.php">About Us</a>
            </div>
            <div class="footer-item">
                <a href="Admin-Signup_page.php">Admin Sign Up</a>
            </div>
        </div>
    </footer>
</body>
</html>
