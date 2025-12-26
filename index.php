<?php
// Mock Session Check
$isLoggedIn = isset($_GET['mock_login']) && $_GET['mock_login'] === 'true';

// Series Data
$SERIES_LIST = [
    [
        "id" => 10,
        "title" => "The Rookie",
        "year" => "2018",
        "rating" => 4.8,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1594909122845-11baa439b7bf?q=80&w=300&h=450&fit=crop",
        "color" => "from-blue-900",
        "description" => "Starting over isn't easy, especially for small-town guy John Nolan who, after a life-altering incident, is pursuing his dream of being an LAPD officer."
    ],
    [
        "id" => 11,
        "title" => "The Rookie: Feds",
        "year" => "2022",
        "rating" => 4.2,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=300&h=450&fit=crop",
        "color" => "from-orange-900",
        "description" => "Special Agent Simone Clark, the oldest rookie in the FBI Academy, is assigned to support the LA field office."
    ],
    [
        "id" => 2,
        "title" => "The Bear",
        "year" => "2022",
        "rating" => 4.8,
        "genre" => "Comedy/Drama",
        "poster" => "https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=300&h=450&fit=crop",
        "color" => "from-teal-900",
        "description" => "A young chef from the fine dining world returns to Chicago to run his family's sandwich shop."
    ],
    [
        "id" => 1,
        "title" => "Succession",
        "year" => "2018",
        "rating" => 4.9,
        "genre" => "Drama",
        "poster" => "https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=400&h=600&fit=crop",
        "color" => "from-gray-900",
        "description" => "The Roy family is known for controlling the biggest media and entertainment company in the world."
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Discovery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> 
        body { background-color: #14181c; color: #9ab; font-family: sans-serif; } 
        .glass { background: rgba(44, 52, 64, 0.5); backdrop-filter: blur(4px); }
        .show-card:hover .overlay { opacity: 1; }
    </style>
</head>
<body class="min-h-screen pb-20">
    <nav class="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-[100] h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="index.php?<?php echo $isLoggedIn ? 'mock_login=true' : ''; ?>" class="flex items-center gap-2">
                    <div class="bg-[#00e054] p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="3"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                    </div>
                    <span class="text-xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
                </a>
            </div>
            
            <div class="flex items-center gap-6">
                <?php if ($isLoggedIn): ?>
                    <a href="trivia.php" class="hidden md:block text-[10px] font-bold uppercase tracking-widest text-[#00e054] hover:brightness-110">Play Trivia</a>
                    <a href="account.php?mock_login=true" class="relative group flex items-center gap-2 p-1 hover:bg-[#2c3440] rounded-full transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#00e054] to-blue-500 flex items-center justify-center text-[#14181c] font-bold text-xs">JD</div>
                        <span class="text-white text-[10px] font-bold uppercase tracking-widest hidden sm:block">My Account</span>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-[10px] font-bold uppercase tracking-widest hover:text-white">Sign In</a>
                    <a href="login.php" class="bg-[#00e054] text-[#14181c] text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded hover:brightness-110 transition-all">Join Free</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 pt-24">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main List -->
            <div class="flex-1">
                <h2 class="text-[#9ab] uppercase tracking-widest text-[10px] font-bold mb-6 border-b border-[#2c3440] pb-2">Popular This Week</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <?php foreach ($SERIES_LIST as $show): ?>
                        <div class="show-card group relative aspect-[2/3] rounded overflow-hidden border border-[#2c3440] hover:border-[#00e054] transition-all">
                            <img src="<?php echo $show['poster']; ?>" class="w-full h-full object-cover">
                            <div class="overlay absolute inset-0 bg-black/80 opacity-0 transition-opacity flex flex-col items-center justify-center p-4 text-center">
                                <h3 class="text-white font-black uppercase italic tracking-tighter mb-2"><?php echo $show['title']; ?></h3>
                                <div class="flex items-center gap-1 text-[#00e054] mb-4">
                                    <span class="text-xs font-bold"><?php echo $show['rating']; ?>/5</span>
                                </div>
                                <button class="bg-white text-black text-[10px] font-black uppercase px-4 py-2 rounded-sm hover:bg-[#00e054] transition-colors">See Details</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-64 space-y-6">
                <div class="bg-[#2c3440] p-6 rounded-lg shadow-xl border border-[#456]/20">
                    <h3 class="text-white text-xs font-bold uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="text-[#00e054]">●</span> Rookie Hub
                    </h3>
                    <p class="text-sm text-[#9ab] leading-relaxed mb-6">
                        Think you know everything about Officer Nolan and the Mid-Wilshire team?
                    </p>
                    <a href="trivia.php" class="block w-full bg-[#00e054] text-[#14181c] text-center text-[10px] font-black uppercase tracking-widest py-3 rounded hover:scale-[1.02] transition-transform shadow-lg shadow-[#00e054]/10">
                        The Rookie Trivia
                    </a>
                </div>

                <div class="glass p-6 rounded-lg border border-[#2c3440]">
                    <h3 class="text-[#678] text-[10px] font-bold uppercase tracking-widest mb-4">Quick Browse</h3>
                    <ul class="space-y-3 text-[11px] font-bold uppercase tracking-widest">
                        <li><a href="#" class="hover:text-white transition-colors">Coming Soon</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">High Ratings</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Crime Dramas</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>