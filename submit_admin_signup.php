<?php
session_start(); 
require_once 'connectdb.php';

// set the admin code - the admin must input this exactly in order to log in
define('ADMIN_CODE', 'Admin2024');

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    // store the form inputs
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;
    $admin_code = $_POST['admin_code'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;

    // validate the form inputs and output errors if invalid
    if (empty($username)) { exit("No username entered."); }
    if (empty($password)) { exit("No password entered."); }
    if (empty($email)) { exit("No email entered."); }
    if (empty($admin_code)) { exit("No admin access code entered."); }
    if (empty($phone_number)) { exit("No phone number entered."); }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { exit("Invalid email."); }
    if ($admin_code !== ADMIN_CODE) { exit("Invalid admin access code."); }
    if ($password !== $confirm_password) { exit("Passwords don't match."); }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // hash the password

    try {    
        // register admin by inserting their info into the database
        $query = "INSERT INTO users (email, full_name, password, phone_number, type) VALUES (?, ?, ?, ?, 'admin')";
        $stmt = $db->prepare($query);

        if ($stmt->execute([$email, $username, $hashed_password, $phone_number])) {
            echo "Admin account created successfully!";
            header("Location: Login_Page.php");
            exit();
        } else {
            echo "Admin sign-up unsuccessful!";
        }
    } catch (PDOException $ex) {
        echo "Sorry, a database error occurred!";
        error_log($ex->getMessage());
        echo "Error: " . $ex->getMessage();
    }
}
?>
