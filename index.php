<?php
// Mock Authentication for demonstration
$isLoggedIn = isset($_GET['mock_login']) && $_GET['mock_login'] === 'true';
$userId = "JD_77";

// Shared Series Data
$SERIES_DATABASE = [
    [
        "id" => 10,
        "title" => "The Rookie",
        "year" => "2018–2026",
        "rating" => 4.9,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1594909122845-11baa439b7bf?q=80&w=300&h=450&fit=crop",
        "trending" => true,
        "badge" => "Season 8 Jan 6",
        "description" => "John Nolan and the LAPD return for Season 8 on Jan 6, 2026. The premiere 'Czech Mate' takes the crew to Prague for a global operation."
    ],
    [
        "id" => 2,
        "title" => "The Bear",
        "year" => "2022–Present",
        "rating" => 4.8,
        "genre" => "Drama",
        "poster" => "https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=300&h=450&fit=crop",
        "trending" => true,
        "badge" => null,
        "description" => "A young chef from the fine dining world returns to Chicago to run his family's sandwich shop."
    ],
    [
        "id" => 11,
        "title" => "The Rookie: Feds",
        "year" => "2022",
        "rating" => 4.2,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=300&h=450&fit=crop",
        "trending" => false,
        "badge" => null,
        "description" => "Special Agent Simone Clark joins the LA field office in this high-octane spin-off."
    ],
    [
        "id" => 12,
        "title" => "S.W.A.T.",
        "year" => "2017–Present",
        "rating" => 4.5,
        "genre" => "Action",
        "poster" => "https://images.unsplash.com/photo-1509248961158-e54f6934749c?q=80&w=300&h=450&fit=crop",
        "trending" => false,
        "badge" => null,
        "description" => "A local S.W.A.T. sergeant is tasked to run a specialized tactical unit in Los Angeles."
    ],
    [
        "id" => 13,
        "title" => "Slow Horses",
        "year" => "2022–Present",
        "rating" => 4.7,
        "genre" => "Espionage",
        "poster" => "https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=300&h=450&fit=crop",
        "trending" => true,
        "badge" => "Top Rated",
        "description" => "A group of MI5 agents who have botched their careers end up in a dumping ground department."
    ],
    [
        "id" => 14,
        "title" => "Poker Face",
        "year" => "2023–Present",
        "rating" => 4.4,
        "genre" => "Mystery",
        "poster" => "https://images.unsplash.com/photo-1511193311914-0346f16efe50?q=80&w=300&h=450&fit=crop",
        "trending" => false,
        "badge" => null,
        "description" => "Charlie has an extraordinary ability to determine when someone is lying."
    ]
];

$trendingShows = array_filter($SERIES_DATABASE, fn($s) => $s['trending']);
$allShows = $SERIES_DATABASE;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #14181c; color: #9ab; }
        .show-card:hover .overlay { opacity: 1; }
        .glass-nav { background: rgba(20, 24, 28, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="min-h-screen pb-20">
    <nav class="fixed top-0 w-full glass-nav border-b border-[#2c3440] z-[100] h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <a href="index.php?mock_login=true" class="flex items-center gap-2">
                <div class="bg-[#00e054] p-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="3"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                </div>
                <span class="text-xl font-black text-white italic tracking-tighter uppercase">SeriesList</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="account.php?mock_login=true" class="flex items-center gap-2 px-3 py-1.5 hover:bg-[#2c3440] rounded-full transition-all border border-transparent hover:border-[#456]">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-[#00e054] to-blue-500 flex items-center justify-center text-[#14181c] font-bold text-[10px]">JD</div>
                    <span class="text-white text-[10px] font-bold uppercase tracking-widest hidden sm:block">Edit Profile</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 pt-24">
        <!-- TRENDING SECTION -->
        <section class="mb-16">
            <h2 class="text-white uppercase tracking-[0.2em] text-xs font-bold mb-8 flex items-center gap-3">
                Trending Now <span class="h-px flex-1 bg-[#2c3440]"></span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
                <?php foreach ($trendingShows as $show): ?>
                    <div class="group relative aspect-[16/9] rounded-lg overflow-hidden border border-[#2c3440] hover:border-[#00e054] transition-all">
                        <img src="<?php echo $show['poster']; ?>" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent p-6 flex flex-col justify-end">
                            <?php if($show['badge']): ?>
                                <span class="absolute top-4 right-4 bg-[#00e054] text-[#14181c] text-[9px] font-black px-2 py-0.5 rounded uppercase"><?php echo $show['badge']; ?></span>
                            <?php endif; ?>
                            <h3 class="text-white font-black italic text-2xl uppercase tracking-tighter mb-1"><?php echo $show['title']; ?></h3>
                            <p class="text-[10px] uppercase font-bold text-[#00e054] tracking-widest"><?php echo $show['genre']; ?> • <?php echo $show['year']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ALL SERIES SECTION -->
        <section>
            <h2 class="text-[#9ab] uppercase tracking-[0.2em] text-xs font-bold mb-8 flex items-center gap-3">
                Complete Library <span class="h-px flex-1 bg-[#2c3440]"></span>
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php foreach ($allShows as $show): ?>
                    <div class="show-card group relative aspect-[2/3] rounded border border-[#2c3440] overflow-hidden cursor-pointer hover:scale-105 transition-transform">
                        <img src="<?php echo $show['poster']; ?>" class="w-full h-full object-cover" alt="">
                        <div class="overlay absolute inset-0 bg-[#14181c]/95 opacity-0 transition-opacity p-4 flex flex-col items-center justify-center text-center">
                            <h4 class="text-white font-bold text-xs uppercase mb-2"><?php echo $show['title']; ?></h4>
                            <p class="text-[9px] line-clamp-4 leading-relaxed mb-4"><?php echo $show['description']; ?></p>
                            <button class="w-full py-2 bg-[#2c3440] hover:bg-[#00e054] text-white hover:text-[#14181c] text-[9px] font-bold uppercase transition-colors rounded">Details</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>