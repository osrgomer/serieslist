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
        
        // Check if global_users exists
        if (!isset($_SESSION['global_users']) || empty($_SESSION['global_users'])) {
            echo json_encode(['success' => true, 'users' => [], 'error' => 'No users in database']);
            exit;
        }
        
        // Search in registered users
        $results = [];
        foreach ($_SESSION['global_users'] as $user) {
            // Don't show current user
            if ($user['id'] === $currentUserId) {
                continue;
            }
            
            // Check if already friends
            $isFriend = false;
            if (isset($_SESSION['friends_data']['friends'])) {
                foreach ($_SESSION['friends_data']['friends'] as $friend) {
                    if ($friend['id'] === $user['id']) {
                        $isFriend = true;
                        break;
                    }
                }
            }
            
            if ($isFriend) {
                continue;
            }
            
            // Search by username or email
            if (stripos($user['username'], $query) !== false || stripos($user['email'], $query) !== false) {
                $results[] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'avatar' => $user['avatar'],
                    'online' => isUserOnline($user['id'])
                ];
            }
        }
        
        echo json_encode(['success' => true, 'users' => $results]);
        break;
        
    case 'get_friends':
        // Load friends from global storage for current user
        $userFriends = [];
        
        // Check user's own friends_data first
        if (isset($_SESSION['friends_data']['friends'])) {
            $userFriends = $_SESSION['friends_data']['friends'];
        }
        
        // Also check global friends storage
        if (isset($_SESSION['friends_data_all'][$currentUserId]['friends'])) {
            // Merge with global storage (avoid duplicates)
            foreach ($_SESSION['friends_data_all'][$currentUserId]['friends'] as $globalFriend) {
                $isDuplicate = false;
                foreach ($userFriends as $existingFriend) {
                    if ($existingFriend['id'] === $globalFriend['id']) {
                        $isDuplicate = true;
                        break;
                    }
                }
                if (!$isDuplicate) {
                    $userFriends[] = $globalFriend;
                }
            }
        }
        
        // Update online status for all friends in real-time
        foreach ($userFriends as &$friend) {
            $friend['online'] = isUserOnline($friend['id']);
        }
        
        echo json_encode([
            'success' => true,
            'friends' => $userFriends
        ]);
        break;
        
    case 'get_requests':
        echo json_encode([
            'success' => true,
            'requests' => $_SESSION['friends_data']['requests'] ?? []
        ]);
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
        // Get REAL activity from friends
        $activities = [];
        $friends = $_SESSION['friends_data']['friends'] ?? [];
        $friendIds = array_column($friends, 'id');
        
        // Get activity for each friend
        foreach ($friendIds as $friendId) {
            if (isset($_SESSION['user_activity'][$friendId])) {
                $friendActivities = $_SESSION['user_activity'][$friendId];
                // Get last 5 activities per friend
                $recentActivities = array_slice($friendActivities, -5);
                $activities = array_merge($activities, $recentActivities);
            }
        }
        
        // Sort by time (most recent first)
        usort($activities, function($a, $b) {
            return $b['time'] - $a['time'];
        });
        
        // Limit to 20 most recent activities
        $activities = array_slice($activities, 0, 20);
        
        echo json_encode([
            'success' => true,
            'activities' => $activities
        ]);
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
