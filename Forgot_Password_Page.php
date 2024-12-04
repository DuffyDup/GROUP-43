<!--Manahil Firdous-->
<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="website icon" type="jpeg" href="Tech_Nova.png"> <!--Set up the company logo as the website icon-->
    <link rel="stylesheet" href="Login_Page.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <!--The Navigation (Start)-->
    <?php include 'Navbar.php'; ?>
    <!--The Navigation (End)-->
    <div class="sendtheOTP">
        <input type="email" placeholder="Email" id="Enter Email" class="entrybox"> <br> <br>
        <button type="submit">Send OTP</button>
    </div>
    <br>
    <div class="entertheOTP">
        <input type="number" placeholder="Enter 6 Digit Number" id="OTPLogin" class="entrybox"> <br> <br>
        <button type="submit">Verify OTP</button> <br> <br>
        <button type="submit">Resend OTP</button>
    </div> 
    <br>
    <div class="choosenewpassword">
        <input type="password" placeholder="Enter new password" id="Newpassword" class="entrybox"> <br> <br>
        <input type="password" placeholder="Confirm password" id="Repeatepassword" class="entrybox"> <br> <br>
        <button type="submit">Reset Password</button>
    </div>
</body>
</html>


<script>
    /**
     * This will show the email entry, OTP entry and password entry individually.
     * 1. The user enters their email and clicks the send otp button.
     * 2. The OTP in the person's email needs to be entered into the entrybox. The person then clicks the Verify OTP button.
     * 3. If the OTP is correct, the person can now enter a new password.
     * 4. Either take user back to login or to home page.
    */
</script>