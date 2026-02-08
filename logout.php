<?php
session_start();

// Preserve global data before clearing session
$global_users = $_SESSION['global_users'] ?? [];
$friends_data_all = $_SESSION['friends_data_all'] ?? [];

// Clear only login-related session data
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_email']);
unset($_SESSION['username']);
unset($_SESSION['user_name']);
unset($_SESSION['connections']);
unset($_SESSION['friends_data']);

// Restore global data
$_SESSION['global_users'] = $global_users;
$_SESSION['friends_data_all'] = $friends_data_all;

// Redirect to login page
header('Location: login.php');
exit;
?>