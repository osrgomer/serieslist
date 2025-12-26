<?php
// INITIAL_SHOWS Data Array
$INITIAL_SHOWS = [
    [
        "id" => 10,
        "title" => "The Rookie",
        "year" => "2018",
        "seasons" => 7,
        "rating" => 4.8,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1599508411083-d97f2670732e?w=400&h=600&fit=crop",
        "description" => "John Nolan, a man in his 40s, becomes the oldest rookie at the LAPD. Based on a true story of pursuing a fresh start and helping the community."
    ],
    [
        "id" => 11,
        "title" => "The Rookie: Feds",
        "year" => "2022",
        "seasons" => 1,
        "rating" => 4.2,
        "genre" => "Crime Drama",
        "poster" => "https://images.unsplash.com/photo-1585007600263-ad126256759c?w=400&h=600&fit=crop",
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

$view = isset($_GET['view']) ? $_GET['view'] : 'home';
$showId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$filteredShows = array_filter($INITIAL_SHOWS, function($show) use ($search) {
    return empty($search) || stripos($show['title'], $search) !== false;
});

$selectedShow = null;
if ($showId) {
    foreach ($INITIAL_SHOWS as $show) {
        if ($show['id'] === $showId) { $selectedShow = $show; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { background-color: #14181c; color: #9ab; font-family: sans-serif; } </style>
</head>
<body class="min-h-screen pb-20">
    <nav class="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-50 h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="index.php" class="flex items-center gap-2">
                    <div class="bg-[#00e054] p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                    </div>
                    <span class="text-xl font-black text-white italic uppercase">SeriesList</span>
                </a>
                <div class="hidden md:flex gap-6 text-[10px] uppercase tracking-widest font-bold">
                    <a href="index.php" class="text-white border-b-2 border-[#00e054] pb-1">Browse</a>
                    <a href="trivia.php" class="hover:text-white transition-colors">Trivia Quiz</a>
                </div>
            </div>
            
            <form action="index.php" method="GET" class="relative hidden sm:block">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="bg-[#2c3440] text-white pl-8 pr-4 py-1.5 rounded-full text-sm outline-none w-64 focus:ring-1 focus:ring-[#00e054]" placeholder="Search series...">
                <div class="absolute left-3 top-2.5 text-[#678]"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 pt-24">
        <?php if ($view === 'home'): ?>
            <h2 class="text-[#9ab] uppercase tracking-widest text-xs font-bold mb-6">Trending Series</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php foreach ($filteredShows as $show): ?>
                    <a href="?view=show-detail&id=<?php echo $show['id']; ?>" class="group block relative overflow-hidden rounded-md border-2 border-transparent hover:border-[#00e054] transition-all">
                        <img src="<?php echo $show['poster']; ?>" class="w-full aspect-[2/3] object-cover">
                        <div class="absolute bottom-0 p-2 bg-black/60 w-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-white text-xs font-bold"><?php echo $show['title']; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php elseif ($view === 'show-detail' && $selectedShow): ?>
            <div class="flex flex-col md:flex-row gap-10">
                <img src="<?php echo $selectedShow['poster']; ?>" class="w-48 h-72 rounded shadow-xl">
                <div>
                    <h1 class="text-5xl font-black text-white mb-4"><?php echo $selectedShow['title']; ?></h1>
                    <p class="text-xl mb-6"><?php echo $selectedShow['description']; ?></p>
                    <a href="index.php" class="text-xs font-bold uppercase tracking-widest text-[#00e054]">← Back Home</a>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>