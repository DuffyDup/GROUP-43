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

    <form action="Forgot_Password_Page.php" method="post">
        <div id="sendTheOTP" class="sendtheOTP">
            <input type="email" placeholder="Email" id="emailInput" name="fpemail" class="entrybox" required> <br> <br>
            <button type="submit" name="submit_email">Send OTP</button>
        </div>
    </form>

    <form action="Forgot_Password_Page.php" method="post">
        <div id="enterTheOTP" class="entertheOTP" style="display: none;">
            <input type="number" placeholder="Enter 6 Digit Number" id="otpInput" class="entrybox" name="otpInput" maxlength="6" > <br> <br>
            <button type="submit" name="submitOTP">Verify OTP</button> <br> <br>
            <button type="submit" name ="resendOTP">Resend OTP</button>
        </div>
    </form>

    <form action="Forgot_Password_Page.php" method="post">
        <div id="choosenewpassword" class="choosenewpassword" style="display: none;">
            <input type="password" placeholder="Enter new password" id="Newpassword" class="entrybox" name='password' required> <br> <br>
            <input type="password" placeholder="Confirm password" id="Repeatepassword" class="entrybox" name='conPassword' required> <br> <br>
            <button type="submit" name="changePassword">Reset Password</button>
        </div>
    </form>

<!--php for checking if email is in database-->
    <?php
        // import phpmailer anddatabase connection
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        require "vendor/autoload.php";
        require_once 'connectdb.php';

        if (isset($_POST['submit_email'])){
            $email = isset($_POST['fpemail']) ? $_POST['fpemail'] : false;
            
            try {
                $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
                $stmt->execute([$email]);
    
                if ($stmt->rowCount() == 0) {
                    echo "<p style='color:red'>This email is not registered to an account.</p>";
                } else {
                    //save email to be used for later
                    $_SESSION['fpemail'] = $email;

                    // Generate OTP and store it securely in a session
                    $otp = rand(100000, 999999);
                    $_SESSION['otp'] = $otp;
                    

                    try {
                        // Configure PHPMailer
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->SMTPAuth = true;
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->Username = "TechNova638@gmail.com";
                        $mail->Password = "kboxrgaqzjjymzlq";
                
                        $mail->setFrom('TechNova@gmail.com', 'TechNova');
                        $mail->addAddress($email);
                
                        // Email content
                        $mail->Subject = "Your OTP Code";
                        $mail->Body = "Your OTP code is: " . $_SESSION['otp'];
                
                        $mail->send();
                        echo "<p style='color:green'>OTP has been sent to your email.</p>";
                    } catch (Exception $e) {
                        echo "<p style='color:red'>Failed to send OTP. Please try again later.</p>";
                        error_log($mail->ErrorInfo); // Log error for debugging
                    }
                

                    //display next screen and hide this one
                    echo "<script>
                        document.getElementById('sendTheOTP').style.display = 'none';
                        document.getElementById('enterTheOTP').style.display = 'block';
                    </script>";
                } 
            } catch (PDOException $ex) {
                echo "Failed to connect to the database.<br>";
                echo $ex->getMessage();
                exit;
            }
        }
        
    ?>
    
    <!--php for checking if OTP is correct-->
    <?php
    if (isset($_POST['submitOTP'])){
        $SubmittedOTP = isset($_POST['otpInput']) ? $_POST['otpInput'] : false;

        if ($SubmittedOTP==$_SESSION['otp']){
            echo "<script>
                        document.getElementById('enterTheOTP').style.display = 'none';
                        document.getElementById('sendTheOTP').style.display = 'none';
                        document.getElementById('choosenewpassword').style.display = 'block';
                    </script>";
        }
        else{
            echo "<p style='color:red'>Incorrect OTP, Please try again.</p>";
            echo "<script>
                        document.getElementById('sendTheOTP').style.display = 'none';
                        document.getElementById('enterTheOTP').style.display = 'block';
                    </script>";
        }
    }

    ?>

    <!--php for resending OTP-->
    <?php
    if (isset($_POST['resendOTP'])){
        $email = $_SESSION['fpemail'];

        try {
            // Configure PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->Username = "TechNova638@gmail.com";
            $mail->Password = "kboxrgaqzjjymzlq";
    
            $mail->setFrom('TechNova@gmail.com', 'TechNova');
            $mail->addAddress($email);
    
            // Email content
            $mail->Subject = "Your OTP Code";
            $mail->Body = "Your OTP code is: " . $_SESSION['otp'];
    
            $mail->send();
            echo "<p style='color:green'>OTP has been resent to your email.</p>";
            echo "<script>
                        document.getElementById('sendTheOTP').style.display = 'none';
                        document.getElementById('enterTheOTP').style.display = 'block';
                    </script>";

        } catch (Exception $e) {
            echo "<p style='color:red'>Failed to send OTP. Please try again later.</p>";
            error_log($mail->ErrorInfo); // Log error for debugging
        }

        //display next screen and hide this one
        echo "<script>
            document.getElementById('sendTheOTP').style.display = 'none';
            document.getElementById('enterTheOTP').style.display = 'block';
        </script>";
    } 

    ?>





    <!--checking passwords are the same and updating password in the database-->
    <?php
        if (isset($_POST['changePassword'])){
            $password=isset($_POST['password']) ? $_POST['password']: false;
            $cpassword=isset($_POST['conPassword']) ? $_POST['conPassword']: false;

            if($password!=$cpassword){
                echo "<p style='color:red'>Passwords dont match. Please try again.</p>";
                echo "<script>
                        document.getElementById('sendTheOTP').style.display = 'none';
                        document.getElementById('choosenewpassword').style.display = 'block';
                    </script>";
            }

            else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query= "UPDATE users SET password=? WHERE email=?";
                $statement=$db->prepare($query);
                $result=$statement->execute([$hashed_password,$_SESSION['fpemail']]);
                echo "<p style='color:Green'>Passwords changed successfully.</p>";
            }
        }
    ?>

<!-- Footer -->
<?php include 'footer.php'; ?>
    
</body>
</html>


