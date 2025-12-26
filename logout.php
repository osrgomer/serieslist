<?php
/**

logout.php

Handles the termination of the user session.
*/

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This only works if the session was started with cookies.
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
}

// Finally, destroy the session.
session_destroy();

// Redirect to the landing page or login page
header("Location: index.php");
exit;
?>