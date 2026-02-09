<?php
session_start();

// Admin authentication
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'omersr12@gmail.com') {
    header('Location: index.php');
    exit;
}

require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    updateLastActive($_SESSION['user_id']);
}

$current_page = 'admin';
$page_title = 'Command Centre - SeriesList';
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #0a0a0f;
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 255, 255, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 255, 136, 0.1) 0px, transparent 50%);
            color: #e0e0e0;
            font-family: 'Courier New', monospace;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            border-color: #00ffff;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        
        .status-pulse {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        
        .status-online { background: #00ff88; box-shadow: 0 0 10px #00ff88; }
        .status-idle { background: #ffaa00; box-shadow: 0 0 10px #ffaa00; }
        .status-offline { background: #666; box-shadow: 0 0 5px #666; }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .activity-ticker {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #00ffff #1a1a2e;
        }
        
        .activity-ticker::-webkit-scrollbar {
            width: 6px;
        }
        
        .activity-ticker::-webkit-scrollbar-track {
            background: #1a1a2e;
        }
        
        .activity-ticker::-webkit-scrollbar-thumb {
            background: #00ffff;
            border-radius: 3px;
        }
        
        .activity-item {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .neon-text {
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.8);
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #00ff88 0%, #00ffff 100%);
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .impersonate-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(90deg, #ff0000, #ff6600);
            color: white;
            padding: 10px;
            text-align: center;
            z-index: 9999;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
            display: none;
        }
    </style>
</head>
<body>
    <!-- Impersonation Bar -->
    <div id="impersonateBar" class="impersonate-bar">
        ⚠️ Impersonating <span id="impersonateUser"></span> - 
        <button onclick="exitImpersonate()" class="underline font-bold">Exit God Mode</button>
    </div>

    <div class="container mx-auto px-4 py-8 <?php echo isset($_SESSION['admin_origin']) ? 'mt-12' : ''; ?>">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold neon-text mb-2">
                <i class="fas fa-satellite-dish"></i> COMMAND CENTRE
            </h1>
            <p class="text-cyan-400">System Status: <span class="text-green-400">OPERATIONAL</span></p>
            <a href="index.php" class="text-sm text-slate-400 hover:text-cyan-400">
                <i class="fas fa-arrow-left"></i> Back to Main
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Server Load -->
            <div class="glass-card rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                        <i class="fas fa-server"></i> SERVER LOAD
                    </h3>
                    <div id="serverLoad" class="text-2xl font-bold text-cyan-400">--</div>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div id="serverLoadBar" class="h-full bg-gradient-to-r from-cyan-500 to-green-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
            
            <!-- Total Users -->
            <div class="glass-card rounded-lg p-6">
                <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                    <i class="fas fa-users"></i> TOTAL USERS
                </h3>
                <div id="totalUsers" class="text-3xl font-bold text-green-400">0</div>
            </div>
            
            <!-- Total Shows -->
            <div class="glass-card rounded-lg p-6">
                <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                    <i class="fas fa-tv"></i> TOTAL SHOWS
                </h3>
                <div id="totalShows" class="text-3xl font-bold text-purple-400">0</div>
            </div>
            
            <!-- Total Friendships -->
            <div class="glass-card rounded-lg p-6">
                <h3 class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-2">
                    <i class="fas fa-heart"></i> FRIENDSHIPS
                </h3>
                <div id="totalFriendships" class="text-3xl font-bold text-pink-400">0</div>
            </div>
        </div>

        <!-- Online/Idle/Offline Users -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Online Users -->
            <div class="glass-card rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-green-400">
                        <i class="fas fa-circle status-pulse status-online"></i> ONLINE
                    </h3>
                    <span id="onlineCount" class="text-3xl font-bold text-green-400">0</span>
                </div>
                <div id="onlineUsers" class="space-y-2"></div>
            </div>

            <!-- Idle Users -->
            <div class="glass-card rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-amber-400">
                        <i class="fas fa-circle status-pulse status-idle"></i> IDLE
                    </h3>
                    <span id="idleCount" class="text-3xl font-bold text-amber-400">0</span>
                </div>
                <div id="idleUsers" class="space-y-2"></div>
            </div>

            <!-- Offline Users -->
            <div class="glass-card rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-slate-400">
                        <i class="fas fa-circle status-pulse status-offline"></i> OFFLINE
                    </h3>
                    <span id="offlineCount" class="text-3xl font-bold text-slate-400">0</span>
                </div>
                <div id="offlineUsers" class="space-y-2"></div>
            </div>
        </div>

        <!-- Live Activity Ticker & Trending Shows -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Activity Feed -->
            <div class="glass-card rounded-lg p-6">
                <h3 class="text-2xl font-bold neon-text mb-4">
                    <i class="fas fa-terminal"></i> LIVE ACTIVITY STREAM
                </h3>
                <div id="activityFeed" class="activity-ticker space-y-2">
                    <p class="text-slate-500 text-center">Initializing feed...</p>
                </div>
            </div>

            <!-- Trending Shows -->
            <div class="glass-card rounded-lg p-6">
                <h3 class="text-2xl font-bold neon-text mb-4">
                    <i class="fas fa-fire"></i> TRENDING SHOWS
                </h3>
                <div id="trendingShows" class="space-y-4">
                    <p class="text-slate-500 text-center">Loading data...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let lastActivityId = 0;
        let impersonating = <?php echo isset($_SESSION['admin_origin']) ? 'true' : 'false'; ?>;

        // Load ALL stats in one call
        async function loadStats() {
            try {
                const response = await fetch('api_admin.php?action=get_stats');
                const data = await response.json();
                
                if (!data.success) return;
                
                // Update server load
                const load = data.server_load || 0;
                document.getElementById('serverLoad').textContent = load.toFixed(2);
                const loadPercent = Math.min((load / 2) * 100, 100); // Cap at 2.0 = 100%
                document.getElementById('serverLoadBar').style.width = loadPercent + '%';
                if (load > 1.5) {
                    document.getElementById('serverLoadBar').className = 'h-full bg-gradient-to-r from-red-500 to-orange-500 transition-all duration-500';
                } else if (load > 0.8) {
                    document.getElementById('serverLoadBar').className = 'h-full bg-gradient-to-r from-amber-500 to-yellow-500 transition-all duration-500';
                } else {
                    document.getElementById('serverLoadBar').className = 'h-full bg-gradient-to-r from-cyan-500 to-green-500 transition-all duration-500';
                }
                
                // Update totals
                document.getElementById('totalUsers').textContent = data.stats.total_users;
                document.getElementById('totalShows').textContent = data.stats.total_shows;
                document.getElementById('totalFriendships').textContent = data.stats.total_friendships;
                
                // Update users (categorize by status)
                const online = [], idle = [], offline = [];
                data.users.forEach(user => {
                    const secondsAgo = user.seconds_ago;
                    if (secondsAgo < 120 || user.manual_status === 'online') {
                        online.push(user);
                    } else if (secondsAgo < 300 && user.manual_status !== 'offline') {
                        idle.push(user);
                    } else {
                        offline.push(user);
                    }
                });
                
                document.getElementById('onlineCount').textContent = online.length;
                document.getElementById('idleCount').textContent = idle.length;
                document.getElementById('offlineCount').textContent = offline.length;
                
                renderUsers('onlineUsers', online, 'green');
                renderUsers('idleUsers', idle, 'amber');
                renderUsers('offlineUsers', offline, 'slate');
                
                // Update activity feed
                if (data.activities.length > 0) {
                    renderActivity(data.activities);
                }
                
                // Update trending
                if (data.trending.length > 0) {
                    renderTrending(data.trending);
                }
                
            } catch (error) {
                console.error('Failed to load stats:', error);
            }
        }
        
        // Kept for backwards compatibility
        async function loadUsers() {
            await loadStats();
        }

        function renderUsers(containerId, users, color) {
            const container = document.getElementById(containerId);
            if (users.length === 0) {
                container.innerHTML = '<p class="text-sm text-slate-500">None</p>';
                return;
            }
            
            container.innerHTML = users.map(user => `
                <div class="flex items-center justify-between p-2 rounded hover:bg-${color}-500/10">
                    <div class="flex items-center gap-2">
                        <img src="${user.avatar}" class="w-8 h-8 rounded-full">
                        <span class="text-sm">${user.username}</span>
                    </div>
                    <button onclick="impersonate(${user.id}, '${user.username.replace(/'/g, "\\'")}')" 
                            class="text-xs text-cyan-400 hover:text-cyan-300">
                        <i class="fas fa-user-secret"></i>
                    </button>
                </div>
            `).join('');
        }

        // Load activity feed
        function renderActivity(activities) {
            const feed = document.getElementById('activityFeed');
            feed.innerHTML = activities.map(activity => `
                <div class="activity-item p-3 rounded bg-slate-900/50 border border-slate-700">
                    <div class="flex items-center gap-2 mb-1">
                        <img src="${activity.avatar}" class="w-6 h-6 rounded-full">
                        <span class="text-sm text-cyan-400">${activity.username}</span>
                        <span class="text-xs text-slate-500">${timeAgo(activity.created_at)}</span>
                    </div>
                    <p class="text-sm text-slate-300">${activity.action} <span class="text-white">${activity.show_title}</span></p>
                </div>
            `).join('');
        }

        // Load trending shows
        function renderTrending(trending) {
            const container = document.getElementById('trendingShows');
            container.innerHTML = trending.map((show, index) => {
                const completedPercent = (show.completed / show.total_fans) * 100;
                const watchingPercent = (show.watching / show.total_fans) * 100;
                
                return `
                    <div class="p-3 rounded bg-slate-900/50 border border-slate-700">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-bold ${index === 0 ? 'text-yellow-400' : 'text-white'}">
                                ${index + 1}. ${show.title}
                            </span>
                            <span class="text-sm text-cyan-400">${show.total_fans} fans</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-green-400 w-20">Completed:</span>
                                <div class="flex-1 bg-slate-800 rounded h-2">
                                    <div class="progress-bar rounded h-full" style="width: ${completedPercent}%"></div>
                                </div>
                                <span class="text-xs text-slate-400">${show.completed}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-amber-400 w-20">Watching:</span>
                                <div class="flex-1 bg-slate-800 rounded h-2">
                                    <div class="progress-bar rounded h-full" style="width: ${watchingPercent}%"></div>
                                </div>
                                <span class="text-xs text-slate-400">${show.watching}</span>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Impersonate user
        async function impersonate(userId, username) {
            if (!confirm(`Enter God Mode as ${username}?`)) return;
            
            try {
                const response = await fetch('api_admin.php?action=impersonate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: userId })
                });
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = 'index.php';
                }
            } catch (error) {
                console.error('Impersonation failed:', error);
                alert('Impersonation failed!');
            }
        }

        async function exitImpersonate() {
            try {
                await fetch('api_admin.php?action=exit_impersonate');
                window.location.href = 'admin.php';
            } catch (error) {
                console.error('Exit failed:', error);
            }
        }

        function timeAgo(timestamp) {
            const seconds = Math.floor((new Date() - new Date(timestamp)) / 1000);
            if (seconds < 60) return 'just now';
            if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
            if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
            return Math.floor(seconds / 86400) + 'd ago';
        }

        // Auto-refresh - ONE call for everything
        loadStats();
        setInterval(loadStats, 5000); // Every 5 seconds
        
        // Check if impersonating
        if (impersonating) {
            document.getElementById('impersonateBar').style.display = 'block';
            <?php
            if (isset($_SESSION['admin_origin'])) {
                $stmt = getDB()->prepare("SELECT username FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $impersonatedUser = $stmt->fetchColumn();
                echo "document.getElementById('impersonateUser').textContent = '" . htmlspecialchars($impersonatedUser) . "';";
            }
            ?>
        }
    </script>
</body>
</html>
