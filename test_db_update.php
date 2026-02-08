<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$userId = $_SESSION['user_id'];

echo "<h1>Testing Database Update for User $userId</h1>";

// Get current status
$db = getDB();
$stmt = $db->prepare("SELECT manual_status FROM users WHERE id = ?");
$stmt->execute([$userId]);
$before = $stmt->fetchColumn();

echo "<h2>BEFORE Update:</h2>";
echo "<pre>manual_status: $before</pre>";

// Try to update to 'online'
echo "<h2>Attempting: UPDATE users SET manual_status = 'online' WHERE id = $userId</h2>";

$result = updateUserStatus($userId, 'online');

echo "<pre>updateUserStatus() returned: " . ($result ? 'TRUE' : 'FALSE') . "</pre>";

// Check after
$stmt = $db->prepare("SELECT manual_status FROM users WHERE id = ?");
$stmt->execute([$userId]);
$after = $stmt->fetchColumn();

echo "<h2>AFTER Update:</h2>";
echo "<pre>manual_status: $after</pre>";

if ($before === $after && $after !== 'online') {
    echo "<div style='background: red; color: white; padding: 10px;'>";
    echo "❌ DATABASE DID NOT UPDATE!";
    echo "</div>";
    
    // Try direct PDO
    echo "<h2>Testing with direct PDO:</h2>";
    $stmt = $db->prepare("UPDATE users SET manual_status = ? WHERE id = ?");
    $directResult = $stmt->execute(['online', $userId]);
    $rowCount = $stmt->rowCount();
    
    echo "<pre>";
    echo "execute() returned: " . ($directResult ? 'TRUE' : 'FALSE') . "\n";
    echo "rowCount(): $rowCount\n";
    echo "</pre>";
    
    // Check again
    $stmt = $db->prepare("SELECT manual_status FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $final = $stmt->fetchColumn();
    echo "<pre>Final status: $final</pre>";
    
} else {
    echo "<div style='background: green; color: white; padding: 10px;'>";
    echo "✅ UPDATE WORKED!";
    echo "</div>";
}
