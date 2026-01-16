<?php
session_start(); // Start the session to track user login status

// Destroy all session data
session_unset(); 
session_destroy();

// Redirect to the homepage or login page
header("Location: index.php"); // Redirect to the homepage
exit();
?>
