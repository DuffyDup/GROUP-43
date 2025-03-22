<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: Login_Page.php'); // Redirect to login
exit();
?>
<script src="theme.js" defer></script>
