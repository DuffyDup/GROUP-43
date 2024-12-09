<?php
// footer.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 20px 0;
            text-align: center;
            display: flex;
            justify-content: space-around;
        }

        .footer-column {
            width: 20%;
        }

        .footer-column h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }

        .footer-column p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }

        @media (max-width: 768px) {
            .footer {
                flex-direction: column;
                align-items: center;
            }

            .footer-column {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Footer Section -->
    <div class="footer">
        <div class="footer-column">
            <h3>CONTACT INFORMATION</h3>
            <p>Phone: 07893929457</p>
            <p>Email: technova638@gmail.com</p>
            <p>Address: Aston St, Birmingham B4 7ET</p>
        </div>
        <div class="footer-column">
            <h3>WHO ARE WE?</h3>
            <p><a href="contact.html">Contact Us</a></p>
            <p><a href="about.html">About Us</a></p>
            <p><a href="admin-signup.html">Admin Sign Up</a></p>

        </div>
        <div class="footer-column">
            <h3>COMMITTED TO DELIVERING...</h3>
            <p>Sustainablity with technology</p>
            <p>Safeguarding the enviroment</p>
            <p>Outstanding customer Support</p>
        </div>
        <div class="footer-column">
            <h3>SHOP WITH US</h3>
            <p>GIVE PRE-OWNED TECHNOLOGY A SECOND CHANCE</p>
            <p>EXPLORE THE PRODUCT RANGE</p>
        </div>
    </div>
</body>
</html>
