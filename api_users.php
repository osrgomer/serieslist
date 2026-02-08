<?php
session_start();

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

// Helper function to check if user is online (uses database)
function isUserOnline($userId) {
    return getUserStatus($userId) === 'online';
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
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $friendId = $data['friend_id'] ?? null;
            
            if (!$friendId) {
                echo json_encode(['success' => false, 'message' => 'Invalid friend ID']);
                exit;
            }
            
            // Get friend data from global users
            $friendData = $_SESSION['global_users'][$friendId] ?? null;
            
            if (!$friendData) {
                echo json_encode(['success' => false, 'message' => 'User not found']);
                exit;
            }
            
            // Initialize friends data if not exists
            if (!isset($_SESSION['friends_data'])) {
                $_SESSION['friends_data'] = ['friends' => [], 'requests' => [], 'blocked' => []];
            }
            
            // Check if already friends
            foreach ($_SESSION['friends_data']['friends'] as $friend) {
                if ($friend['id'] == $friendId) {
                    echo json_encode(['success' => false, 'message' => 'Already friends']);
                    exit;
                }
            }
            
            // Add friend to CURRENT user's list
            $_SESSION['friends_data']['friends'][] = [
                'id' => $friendData['id'],
                'username' => $friendData['username'],
                'email' => $friendData['email'],
                'avatar' => $friendData['avatar'],
                'online' => isUserOnline($friendData['id']),
                'addedAt' => time() * 1000
            ];
            
            // ALSO add current user to FRIEND's list (mutual friendship)
            if (!isset($_SESSION['friends_data_all'])) {
                $_SESSION['friends_data_all'] = [];
            }
            if (!isset($_SESSION['friends_data_all'][$friendId])) {
                $_SESSION['friends_data_all'][$friendId] = ['friends' => [], 'requests' => [], 'blocked' => []];
            }
            
            // Get current user data
            $currentUserData = $_SESSION['global_users'][$currentUserId] ?? null;
            if ($currentUserData) {
                // Check if friendship already exists
                $alreadyFriends = false;
                foreach ($_SESSION['friends_data_all'][$friendId]['friends'] as $existingFriend) {
                    if ($existingFriend['id'] === $currentUserId) {
                        $alreadyFriends = true;
                        break;
                    }
                }
                
                if (!$alreadyFriends) {
                    $_SESSION['friends_data_all'][$friendId]['friends'][] = [
                        'id' => $currentUserData['id'],
                        'username' => $currentUserData['username'],
                        'email' => $currentUserData['email'],
                        'avatar' => $currentUserData['avatar'],
                        'online' => isUserOnline($currentUserData['id']),
                        'addedAt' => time() * 1000
                    ];
                }
            }
            
            echo json_encode([
                'success' => true,
                'message' => "You're now friends with {$friendData['username']}!"
            ]);
        }
        break;
        
    case 'remove_friend':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $friendId = $data['friend_id'] ?? null;
            
            if ($friendId) {
                $_SESSION['friends_data']['friends'] = array_values(
                    array_filter($_SESSION['friends_data']['friends'], function($f) use ($friendId) {
                        return $f['id'] != $friendId;
                    })
                );
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Friend removed'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid friend ID'
                ]);
            }
        }
        break;
        
    case 'get_activity':
        // Activity feed not yet migrated to MySQL
        echo json_encode(['success' => true, 'activities' => []]);
        exit;
        break;
        
    case 'set_online_status':
        if ($method === 'POST') {
            require_once 'db.php';
            
            $data = json_decode(file_get_contents('php://input'), true);
            $status = $data['status'] ?? 'auto';
            
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                exit;
            }
            
            if (!in_array($status, ['online', 'offline', 'auto'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid status']);
                exit;
            }
            
            try {
                $userId = $_SESSION['user_id'];
                $result = updateUserStatus($userId, $status);
                
                if ($result) {
                    echo json_encode(['success' => true, 'status' => $status]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Update failed']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'POST required']);
        }
        exit;
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
