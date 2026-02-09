<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CRITICAL: Set header BEFORE any output
header('Content-Type: application/json');

// Simple error handling - just output errors as JSON
ini_set('display_errors', 0);
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

// Load database connection
require_once 'db.php';

// Update current user's last active timestamp in database
if (isset($_SESSION['user_id'])) {
    updateLastActive($_SESSION['user_id']);
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'search_users':
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 2) {
            echo json_encode(['success' => true, 'users' => []]);
            exit;
        }
        
        // Search in MySQL database
        $db = getDB();
        $currentUserId = $_SESSION['user_id'];
        
        // Search for users by username or email (exclude current user)
        $stmt = $db->prepare("
            SELECT id, username, email, avatar 
            FROM users 
            WHERE (username LIKE ? OR email LIKE ?) 
            AND id != ?
            LIMIT 20
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $currentUserId]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format results
        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar' => $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['username']),
                'online' => getUserStatus($user['id']) === 'online'
            ];
        }
        
        echo json_encode(['success' => true, 'users' => $results]);
        exit;
        break;
        
    case 'get_friends':
        // Friends system not yet migrated to MySQL
        echo json_encode(['success' => true, 'friends' => []]);
        exit;
        break;
        
    case 'get_requests':
        // Requests not yet migrated to MySQL
        echo json_encode(['success' => true, 'requests' => []]);
        exit;
        break;
        
    case 'add_friend':
        // Friends system not yet migrated to MySQL
        echo json_encode(['success' => false, 'message' => 'Friends feature coming soon']);
        exit;
        
    case 'remove_friend':
        // Friends system not yet migrated to MySQL
        echo json_encode(['success' => false, 'message' => 'Friends feature coming soon']);
        exit;
        
    case 'get_activity':
        // Activity feed not yet migrated to MySQL
        echo json_encode(['success' => true, 'activities' => []]);
        exit;
        
    case 'set_online_status':
        // Use api_set_status.php instead (this is duplicate)
        echo json_encode(['success' => false, 'message' => 'Use api_set_status.php']);
        exit;
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}
