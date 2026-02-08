<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Update current user's last active timestamp
$currentUserId = $_SESSION['user_email'] ?? 'user@example.com';
if (isset($_SESSION['global_users'][$currentUserId])) {
    $_SESSION['global_users'][$currentUserId]['last_active'] = time();
}

// Helper function to check if user is online (active in last 5 minutes)
function isUserOnline($userId) {
    if (!isset($_SESSION['global_users'][$userId])) return false;
    $lastActive = $_SESSION['global_users'][$userId]['last_active'] ?? 0;
    return (time() - $lastActive) < 300; // 5 minutes
}

// Initialize global users storage (in production, use database)
if (!isset($_SESSION['global_users'])) {
    $_SESSION['global_users'] = [];
}

// Migrate old user structure to new structure
foreach ($_SESSION['global_users'] as $email => $userData) {
    // Check if user has old structure (missing 'id' field)
    if (!isset($userData['id'])) {
        $_SESSION['global_users'][$email] = [
            'id' => $email,
            'username' => $userData['name'] ?? 'User',
            'email' => $email,
            'password' => $userData['password'] ?? '',
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($userData['name'] ?? 'User') . '&background=4f46e5&color=fff',
            'created_at' => $userData['created_at'] ?? time(),
            'registered_at' => $userData['created_at'] ?? time()
        ];
    }
}

// Register current user in global users if not exists
$currentUserId = $_SESSION['user_email'] ?? 'user@example.com';
$currentUserName = $_SESSION['user_name'] ?? 'User';

if (!isset($_SESSION['global_users'][$currentUserId])) {
    $_SESSION['global_users'][$currentUserId] = [
        'id' => $currentUserId,
        'username' => $currentUserName,
        'email' => $currentUserId,
        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($currentUserName) . '&background=4f46e5&color=fff',
        'registered_at' => time()
    ];
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
        
        // Debug: log search attempt
        error_log("Search query: " . $query . " by user: " . $currentUserId);
        error_log("Global users count: " . count($_SESSION['global_users']));
        
        // Search in registered users
        $results = [];
        foreach ($_SESSION['global_users'] as $user) {
            error_log("Checking user: " . ($user['id'] ?? 'no-id') . " username: " . ($user['username'] ?? 'no-username'));
            
            // Don't show current user or already friends
            if ($user['id'] === $currentUserId) {
                error_log("Skipping current user");
                continue;
            }
            
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
                error_log("Skipping friend");
                continue;
            }
            
            // Search by username or email
            if (stripos($user['username'], $query) !== false || stripos($user['email'], $query) !== false) {
                error_log("MATCH FOUND: " . $user['username']);
                $results[] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'avatar' => $user['avatar'],
                    'online' => isUserOnline($user['id'])
                ];
            } else {
                error_log("No match for query");
            }
        }
        
        error_log("Total results: " . count($results));
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
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
