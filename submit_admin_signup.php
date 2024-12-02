<?php
session_start(); 
require_once 'connectdb.php';

// set the admin code - the admin must input this exactly in order to log in
define('ADMIN_CODE', 'Admin2024');

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST'){    
    // store the form inputs
    $username=isset($_POST['username'])?$_POST['username']:false;
    $email=isset($_POST['email'])?$_POST['email']:false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : false;
    $admin_code=isset($_POST['admin_code'])?$_POST['admin_code']:false;
    $phone_number = "";

    // validate the form inputs and output errors if invalid
    // check that all form inputs are not empty
    if (empty($username)){ exit("No username entered."); }
    if ($_POST['password'] === ''){ exit("No password entered."); }
    if (empty($email)){ exit("No email entered."); }
    if (empty($admin_code)){ exit("No admin access code entered."); }
    // check the admin code is correct
    if ($admin_code !== ADMIN_CODE) { exit("Invalid admin access code."); }
    // check the email format is correct
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){ exit("Invalid email.");}
    // check the passwords match
    if ($password !== $confirm_password) { exit("Passwords don't match."); }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // hash the password

    try{    
        // register admin by inserting their info into the database
        $query = "INSERT INTO users (email, full_name, password, phone_number, type) VALUES (?, ?, ?, ?, 'admin')";
        $stat=$db->prepare($query);

        if ($stat->execute(array($email, $username, $hashed_password, $phone_number))) {
            echo "Admin account created successfully!";
            // redirect to login page
            header("Location: Login_Page.php");
            exit;
        } else{
            echo "Admin sign-up unsuccessful!";
        }
    }catch (PDOException $ex){
        // log the error
        //error_log($ex->getMessage());
        echo "Sorry, a database error occurred!";
        error_log($ex->getMessage()); // logs the error to the server's error log
        echo "Error: " . $ex->getMessage(); // displays detailed error message
    }
} 
?>