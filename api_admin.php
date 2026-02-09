<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Check admin access
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'omersr12@gmail.com') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

require_once 'db.php';

$action = $_GET['action'] ?? '';
$db = getDB();

switch ($action) {
    case 'get_activity':
        // Get latest 20 activities
        $stmt = $db->prepare("
            SELECT ua.*, u.username, u.avatar 
            FROM user_activity ua
            JOIN users u ON ua.user_id = u.id
            ORDER BY ua.created_at DESC
            LIMIT 20
        ");
        $stmt->execute();
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'activities' => $activities]);
        break;
        
    case 'get_trending':
        // Get top 5 trending shows
        $stmt = $db->query("
            SELECT 
                title,
                COUNT(*) as total_fans,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'Watching' THEN 1 ELSE 0 END) as watching
            FROM series
            GROUP BY title
            HAVING COUNT(*) > 0
            ORDER BY total_fans DESC
            LIMIT 5
        ");
        $trending = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'trending' => $trending]);
        break;
        
    case 'impersonate':
        // God mode - impersonate a user
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'POST required']);
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $targetUserId = $data['user_id'] ?? null;
        
        if ($targetUserId) {
            $_SESSION['admin_origin'] = $_SESSION['user_id'];
            $_SESSION['user_id'] = $targetUserId;
            
            $stmt = $db->prepare("SELECT email, username FROM users WHERE id = ?");
            $stmt->execute([$targetUserId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No user ID']);
        }
        break;
        
    case 'exit_impersonate':
        // Exit impersonation mode
        if (isset($_SESSION['admin_origin'])) {
            $_SESSION['user_id'] = $_SESSION['admin_origin'];
            unset($_SESSION['admin_origin']);
            
            // Restore admin credentials
            $stmt = $db->prepare("SELECT email, username FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['username'] = $admin['username'];
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Not impersonating']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>
