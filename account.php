<?php
// Mock Session Check
$isLoggedIn = isset($_GET['mock_login']) && $_GET['mock_login'] === 'true';

// If not logged in, we simulate a guest view or redirect
$username = "John Doe";
$joinDate = "December 2025";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username; ?>'s Profile - SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> 
        body { background-color: #14181c; color: #9ab; font-family: sans-serif; } 
        .glass { background: rgba(44, 52, 64, 0.5); backdrop-filter: blur(4px); }
        .stat-box { border-left: 1px solid #2c3440; }
        .stat-box:first-child { border-left: none; }
    </style>
</head>
<body class="min-h-screen pb-20">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-[100] h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <a href="index.php?mock_login=true" class="flex items-center gap-2 flex-shrink-0">
                <div class="bg-[#00e054] p-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                </div>
                <span class="text-xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
            </a>
            <div class="flex items-center gap-6 text-[10px] uppercase tracking-widest font-bold">
                <a href="index.php?mock_login=true" class="hover:text-white transition-colors">Browse</a>
                <a href="index.php" class="text-[#ff4b4b] hover:opacity-80 transition-colors">Sign Out</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 pt-28">
        <!-- Header -->
        <header class="flex flex-col md:flex-row items-center md:items-end gap-6 mb-12">
            <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-[#00e054] to-blue-500 flex items-center justify-center text-[#14181c] text-4xl font-black ring-4 ring-[#2c3440]">
                JD
            </div>
            <div class="text-center md:text-left flex-1">
                <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter mb-1"><?php echo $username; ?></h1>
                <p class="text-xs uppercase tracking-widest font-bold text-[#678]">Member since <?php echo $joinDate; ?></p>
            </div>
            <div class="flex gap-4">
                <button class="bg-[#2c3440] hover:bg-[#456] text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded transition-colors">Edit Profile</button>
            </div>
        </header>

        <!-- Stats Bar -->
        <section class="grid grid-cols-3 border-y border-[#2c3440] py-6 mb-12">
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1">42</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Series Watched</span>
            </div>
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1">12</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Watchlist</span>
            </div>
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1">156</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Ratings</span>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Left Column: Activity -->
            <div class="md:col-span-2">
                <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2">Recent Activity</h2>
                <div class="space-y-4">
                    <?php 
                    $activities = [
                        ["type" => "rated", "show" => "The Bear", "value" => "★★★★★", "time" => "2 hours ago"],
                        ["type" => "watched", "show" => "Shogun", "value" => "S1 E05", "time" => "Yesterday"],
                        ["type" => "added", "show" => "Severance", "value" => "Watchlist", "time" => "3 days ago"]
                    ];
                    foreach ($activities as $act):
                    ?>
                        <div class="glass p-4 rounded-lg flex items-center justify-between border border-transparent hover:border-[#2c3440] transition-colors">
                            <div>
                                <p class="text-xs text-[#678] uppercase font-bold tracking-tighter">
                                    You <?php echo $act['type']; ?>
                                </p>
                                <p class="text-white font-bold"><?php echo $act['show']; ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[#00e054] text-xs font-bold"><?php echo $act['value']; ?></p>
                                <p class="text-[10px] text-[#678]"><?php echo $act['time']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div>
                <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2">Account Settings</h2>
                <ul class="space-y-3 text-sm font-bold">
                    <li><a href="#" class="text-[#9ab] hover:text-[#00e054] transition-colors">Privacy & Security</a></li>
                    <li><a href="#" class="text-[#9ab] hover:text-[#00e054] transition-colors">Notifications</a></li>
                    <li><a href="#" class="text-[#9ab] hover:text-[#00e054] transition-colors">Email Preferences</a></li>
                    <li><a href="#" class="text-[#9ab] hover:text-[#00e054] transition-colors">Help Center</a></li>
                </ul>
                
                <div class="mt-8 p-4 bg-[#ff4b4b]/5 border border-[#ff4b4b]/20 rounded-lg">
                    <p class="text-[10px] text-[#ff4b4b] uppercase font-black mb-2 tracking-widest">Danger Zone</p>
                    <button class="text-xs text-[#ff4b4b] hover:underline">Delete Account</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>