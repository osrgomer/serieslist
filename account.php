<?php
// Mock Data Structure representing your current list
$mySeries = [
    [
        "id" => 1,
        "title" => "The Rookie",
        "status" => "Watching",
        "progress" => "S6 E02",
        "image" => "https://images.unsplash.com/photo-1594909122845-11baa439b7bf?q=80&w=300&h=450&fit=crop",
        "rating" => 5
    ],
    [
        "id" => 2,
        "title" => "The Rookie: Feds",
        "status" => "Completed",
        "progress" => "S1 E22",
        "image" => "https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=300&h=450&fit=crop",
        "rating" => 4
    ],
    [
        "id" => 3,
        "title" => "The Bear",
        "status" => "Plan to Watch",
        "progress" => "S1 E01",
        "image" => "https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=300&h=450&fit=crop",
        "rating" => 0
    ]
];

// Calculate actual stats
$totalSeries = count($mySeries);
$completedCount = count(array_filter($mySeries, fn($s) => $s['status'] === 'Completed'));
$watchingCount = count(array_filter($mySeries, fn($s) => $s['status'] === 'Watching'));

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
                <a href="trivia.php" class="text-[#00e054] hover:opacity-80 transition-colors">Play Trivia</a>
                <a href="index.php" class="text-[#ff4b4b] hover:opacity-80 transition-colors">Sign Out</a>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 pt-28">
        <!-- Header -->
        <header class="flex flex-col md:flex-row items-center md:items-end gap-6 mb-12">
            <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-[#00e054] to-blue-500 flex items-center justify-center text-[#14181c] text-4xl font-black ring-4 ring-[#2c3440]">
                JD
            </div>
            <div class="text-center md:text-left flex-1">
                <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter mb-1"><?php echo $username; ?></h1>
                <p class="text-xs uppercase tracking-widest font-bold text-[#678]">Member since <?php echo $joinDate; ?></p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Restored Trivia Button -->
                <a href="trivia.php" class="bg-[#00e054] hover:bg-[#00c048] text-[#14181c] text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded text-center transition-all transform hover:scale-105 shadow-lg shadow-[#00e054]/20">
                    The Rookie Trivia
                </a>
                <button class="bg-[#2c3440] hover:bg-[#456] text-white text-[10px] font-bold uppercase tracking-widest px-6 py-3 rounded transition-colors">
                    Edit Profile
                </button>
            </div>
        </header>

        <!-- Dynamic Stats Bar -->
        <section class="grid grid-cols-3 border-y border-[#2c3440] py-6 mb-12">
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1"><?php echo $totalSeries; ?></span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Total Shows</span>
            </div>
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1"><?php echo $watchingCount; ?></span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Currently Watching</span>
            </div>
            <div class="stat-box text-center">
                <span class="block text-2xl font-black text-white leading-none mb-1"><?php echo $completedCount; ?></span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-[#678]">Completed</span>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Your Actual List -->
            <div class="lg:col-span-2">
                <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2 flex justify-between">
                    <span>Your Collection</span>
                    <span class="text-[#678]"><?php echo count($mySeries); ?> Entries</span>
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($mySeries as $show): ?>
                        <div class="glass rounded-lg overflow-hidden border border-[#2c3440] flex h-24 hover:border-[#00e054]/50 transition-colors">
                            <img src="<?php echo $show['image']; ?>" class="w-16 h-full object-cover" alt="Poster">
                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-white font-bold text-sm leading-tight"><?php echo $show['title']; ?></h3>
                                        <span class="text-[10px] text-[#00e054] font-black uppercase tracking-tighter bg-[#00e054]/10 px-1.5 rounded">
                                            <?php echo $show['status']; ?>
                                        </span>
                                    </div>
                                    <p class="text-[10px] text-[#678] font-bold uppercase"><?php echo $show['progress']; ?></p>
                                </div>
                                <div class="text-[#00e054] text-[10px]">
                                    <?php echo str_repeat('★', $show['rating']) . str_repeat('☆', 5 - $show['rating']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Column: Settings & Shortcuts -->
            <div>
                <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2">Shortcuts</h2>
                <div class="space-y-3">
                    <a href="index.php?mock_login=true" class="block w-full text-center py-3 border border-[#2c3440] rounded text-xs font-bold hover:bg-[#2c3440] transition-colors">Back to Dashboard</a>
                    <a href="trivia.php" class="block w-full text-center py-3 border border-[#00e054]/20 bg-[#00e054]/5 rounded text-xs font-bold text-[#00e054] hover:bg-[#00e054]/10 transition-colors">Play Rookie Trivia</a>
                </div>

                <div class="mt-12">
                    <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2">Settings</h2>
                    <ul class="space-y-4 text-xs font-bold uppercase tracking-widest">
                        <li><a href="#" class="text-[#678] hover:text-white transition-colors">Privacy & Security</a></li>
                        <li><a href="#" class="text-[#678] hover:text-white transition-colors">Notification Settings</a></li>
                        <li><a href="#" class="text-[#678] hover:text-white transition-colors">Linked Accounts</a></li>
                    </ul>
                </div>
                
                <div class="mt-12 p-4 bg-[#ff4b4b]/5 border border-[#ff4b4b]/20 rounded-lg">
                    <p class="text-[10px] text-[#ff4b4b] uppercase font-black mb-2 tracking-widest">Danger Zone</p>
                    <button class="text-xs text-[#ff4b4b] hover:underline font-bold uppercase">Log Out & Clear History</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>