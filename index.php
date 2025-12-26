<?php
// Mock Session Check
// In a real application, you would use session_start() and check $_SESSION['user']
// For this preview, we'll simulate a redirect if a "login" hasn't happened.
$isLoggedIn = isset($_GET['mock_login']) && $_GET['mock_login'] === 'true';

if (!$isLoggedIn && !isset($_GET['view'])) {
    // If not logged in and not looking at a specific public view, 
    // we redirect to the login page.
    header("Location: login.php");
    exit;
}

// INITIAL_SHOWS Data Array
$INITIAL_SHOWS = [
    [
        "id" => 10,
        "title" => "The Rookie",
        "year" => "2018",
        "seasons" => 7,
        "rating" => 4.8,
        "genre" => "Crime Drama",
        "poster" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_4Xm5yN16H09jxneLuDToqdRFXTgnaJsBRg&s",
        "description" => "John Nolan, a man in his 40s, becomes the oldest rookie at the LAPD. Based on a true story of pursuing a fresh start and helping the community."
    ],
    [
        "id" => 11,
        "title" => "The Rookie: Feds",
        "year" => "2022",
        "seasons" => 1,
        "rating" => 4.2,
        "genre" => "Crime Drama",
        "poster" => "https://m.media-amazon.com/images/M/MV5BNGQyYTc3OGQtZWU5MS00MTgwLWFhYTAtYzZmYjc2N2ZiODk2XkEyXkFqcGc@._V1_.jpg",
        "description" => "Simone Clark, a former guidance counselor, becomes the oldest rookie at the FBI Academy and brings her unique perspective to the Bureau."
    ],
    [
        "id" => 1,
        "title" => "Succession",
        "year" => "2018",
        "seasons" => 4,
        "rating" => 4.9,
        "genre" => "Drama",
        "poster" => "https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=400&h=600&fit=crop",
        "description" => "The story of a global media family and the fight for control of the company."
    ],
    [
        "id" => 2,
        "title" => "The Bear",
        "year" => "2022",
        "seasons" => 3,
        "rating" => 4.8,
        "genre" => "Comedy/Drama",
        "poster" => "https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400&h=600&fit=crop",
        "description" => "A young chef returns home to Chicago to run his family's beef sandwich shop."
    ]
];

$CHARACTERS = [
    ["name" => "John Nolan", "role" => "The Rookie", "actor" => "Nathan Fillion"],
    ["name" => "Tim Bradford", "role" => "Training Officer", "actor" => "Eric Winter"],
    ["name" => "Lucy Chen", "role" => "Undercover Specialist", "actor" => "Melissa O'Neil"],
    ["name" => "Angela Lopez", "role" => "Detective", "actor" => "Alyssa Diaz"]
];

$view = isset($_GET['view']) ? $_GET['view'] : 'home';
$showId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$filteredShows = array_filter($INITIAL_SHOWS, function($show) {
    global $search;
    return empty($search) || stripos($show['title'], $search) !== false;
});

$selectedShow = null;
if ($showId) {
    foreach ($INITIAL_SHOWS as $show) {
        if ($show['id'] === $showId) { $selectedShow = $show; break; }
    }
}

function url($path) {
    return "/serieslist/" . ltrim($path, '/');
}
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
    </style>
</head>
<body class="min-h-screen pb-20">
    <nav class="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-[100] h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <div class="flex items-center gap-4 sm:gap-8">
                <a href="<?php echo url('home/'); ?>" class="flex items-center gap-2 flex-shrink-0">
                    <div class="bg-[#00e054] p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                    </div>
                    <span class="text-xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
                </a>
                <div class="hidden md:flex gap-6 text-[10px] uppercase tracking-widest font-bold">
                    <a href="<?php echo url('home/'); ?>" class="text-white border-b-2 border-[#00e054] pb-1">Browse</a>
                    <a href="<?php echo url('trivia/'); ?>" class="hover:text-white transition-colors">Trivia Quiz</a>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-6">
                <form action="<?php echo url('home/'); ?>" method="GET" class="relative hidden sm:block">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="bg-[#2c3440] text-white pl-8 pr-4 py-1.5 rounded-full text-sm outline-none w-40 lg:w-64 focus:ring-1 focus:ring-[#00e054]" placeholder="Search series...">
                    <div class="absolute left-3 top-2.5 text-[#678]"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                </form>

                <a href="login.php" class="relative z-[110] p-2 hover:text-[#00e054] text-white transition-colors flex items-center justify-center rounded-full hover:bg-[#2c3440]" title="Account Info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-circle"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 pt-24">
        <?php if ($view === 'home'): ?>
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1">
                    <h2 class="text-[#9ab] uppercase tracking-widest text-xs font-bold mb-6">Trending Series</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mb-12">
                        <?php foreach ($filteredShows as $show): ?>
                            <a href="<?php echo url('show/' . $show['id'] . '/'); ?>" class="group block relative overflow-hidden rounded-md border-2 border-transparent hover:border-[#00e054] transition-all">
                                <img src="<?php echo $show['poster']; ?>" class="w-full aspect-[2/3] object-cover">
                                <div class="absolute bottom-0 p-3 bg-gradient-to-t from-black to-transparent w-full opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-white text-xs font-bold"><?php echo $show['title']; ?></p>
                                    <p class="text-[10px] text-[#9ab]"><?php echo $show['year']; ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <section class="mt-12">
                        <h2 class="text-white uppercase tracking-widest text-xs font-bold mb-6 border-b border-[#2c3440] pb-2">Character Spotlight</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach ($CHARACTERS as $char): ?>
                                <div class="glass p-4 rounded-lg border border-[#2c3440] hover:border-[#456] transition-colors">
                                    <h3 class="text-white font-bold"><?php echo $char['name']; ?></h3>
                                    <p class="text-xs text-[#00e054] uppercase tracking-tighter font-bold"><?php echo $char['role']; ?></p>
                                    <p class="text-[11px] mt-1 text-[#678]">Played by <?php echo $char['actor']; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <aside class="w-full lg:w-64 space-y-8">
                    <div class="bg-[#2c3440] p-6 rounded-lg text-center">
                        <p class="text-xs text-[#00e054] mb-2 uppercase font-bold tracking-widest">Logged In</p>
                        <a href="index.php" class="text-[10px] text-[#678] hover:text-white underline">Sign Out</a>
                    </div>
                </aside>
            </div>
        <?php elseif ($view === 'show-detail' && $selectedShow): ?>
            <div class="max-w-4xl mx-auto">
                <a href="<?php echo url('home/'); ?>" class="text-xs font-bold uppercase tracking-widest text-[#678] hover:text-[#00e054] mb-8 inline-block transition-colors">← Back Home</a>
                <div class="flex flex-col md:flex-row gap-10">
                    <div class="w-full md:w-64 flex-shrink-0">
                        <img src="<?php echo $selectedShow['poster']; ?>" class="w-full rounded shadow-2xl border border-[#2c3440]">
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-white font-bold"><?php echo $selectedShow['rating']; ?>/5.0</span>
                            <span class="text-[#678] text-xs"><?php echo $selectedShow['seasons']; ?> Seasons</span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-6xl font-black text-white mb-6 leading-tight uppercase italic tracking-tighter"><?php echo $selectedShow['title']; ?></h1>
                        <p class="text-2xl text-white/80 leading-relaxed mb-8 font-light"><?php echo $selectedShow['description']; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>