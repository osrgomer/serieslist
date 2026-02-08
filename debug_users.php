<?php
session_start();

// Temporary debug page - DELETE AFTER USE
echo "<h2>Debug: Global Users</h2>";
echo "<pre>";
print_r($_SESSION['global_users'] ?? 'No global users');
echo "</pre>";

echo "<h2>Available Users:</h2>";
if (isset($_SESSION['global_users'])) {
    foreach ($_SESSION['global_users'] as $email => $user) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
        echo "<strong>Email:</strong> $email<br>";
        echo "<strong>Username:</strong> " . ($user['username'] ?? $user['name'] ?? 'N/A') . "<br>";
        echo "<strong>Has password:</strong> " . (isset($user['password']) ? 'YES' : 'NO') . "<br>";
        echo "<strong>Has id:</strong> " . (isset($user['id']) ? 'YES' : 'NO') . "<br>";
        echo "</div>";
    }
}
?>
