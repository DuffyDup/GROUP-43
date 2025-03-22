<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <script src="theme.js" defer></script>
    <style>
        body {
            background-color: #748b91;
            color: black;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        footer {
            background-color: #c1d1cf;
            padding: 20px 0;
            text-align: center;
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .footer-column {
            width: 30%;
            margin-bottom: 20px;
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

        /* Dark mode styles for footer */
        body.dark-mode footer {
            background-color: #333333;
        }

        body.dark-mode .footer-column h3 {
            color: #e0e0e0;
        }

        body.dark-mode .footer-column p {
            color: #e0e0e0;
        }

        body.dark-mode .footer-column a {
            color: #007bff;
        }

        body.dark-mode .footer-column a:hover {
            color: #0056b3;
        }

        /* Default light mode styles */
        .loginuser, .sendtheOTP, .entertheOTP, .choosenewpassword {
            background-color: #c1d1cf;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
            margin-top: 20px;
        }

        .entrybox {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #848484;
            border-radius: 5px;
            outline: none;
            background: transparent;
            box-sizing: border-box;
        }

        .entrybox input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(116, 139, 145, 0.5);
        }

        .signupbutton {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .loginuser button, .signupbutton button, .loged, .signup {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .loginuser button:hover, .signupbutton button:hover, .loged:hover, .signup:hover {
            background-color: #0056b3;
        }

        #forgetlink {
            color: #000;
        }

        a {
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <footer>
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
    </footer>
</body>
</html>
