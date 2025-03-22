<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            color: #ffffff;
        }
        .footer {
            background-color: #171f22;
            padding: 20px 0;
            text-align: center;
            display: flex;
            justify-content: space-around;
            margin-top: auto; 
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

        .footer-column a {
            text-decoration: none; 
            color: inherit; 
        }

        .footer-column a:hover {
            text-decoration: underline; 
            color: inherit; 
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
            <p><a href="Contact_Us.php">Contact Us</a></p>
            <p><a href="About_us_page.php">About Us</a></p>
            <p><a href="Admin_Signup_page.php">Admin Sign Up</a></p>
        </div>
        <div class="footer-column">
            <h3>COMMITTED TO DELIVERING...</h3>
            <p>Sustainability with technology</p>
            <p>Safeguarding the environment</p>
            <p>Outstanding customer Support</p>
        </div>
    </div>
</body>
</html>
