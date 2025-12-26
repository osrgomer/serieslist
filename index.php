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
    ],
    [
        "id" => 6,
        "title" => "The Last of Us",
        "year" => "2023",
        "seasons" => 1,
        "rating" => 4.9,
        "genre" => "Sci-Fi/Drama",
        "poster" => "https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=400&h=600&fit=crop",
        "description" => "After a global crisis, survivors journey across a changed world in this acclaimed adaptation."
    ],
    [
        "id" => 5,
        "title" => "Andor",
        "year" => "2022",
        "seasons" => 1,
        "rating" => 4.6,
        "genre" => "Sci-Fi",
        "poster" => "https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?w=400&h=600&fit=crop",
        "description" => "The journey of Cassian Andor during the formative years of the rebellion against the Empire."
    ]
];

// State Management via GET/POST
$view = isset($_GET['view']) ? $_GET['view'] : 'home';
$showId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Filter Logic
$filteredShows = array_filter($INITIAL_SHOWS, function($show) use ($search) {
    if (empty($search)) return true;
    return stripos($show['title'], $search) !== false;
});

// Detail View Logic
$selectedShow = null;
if ($showId) {
    foreach ($INITIAL_SHOWS as $show) {
        if ($show['id'] === $showId) {
            $selectedShow = $show;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - PHP Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #14181c; color: #9ab; font-family: ui-sans-serif, system-ui, sans-serif; }
        .poster-card:hover img { border-color: #00e054; }
    </style>
</head>
<body class="min-h-screen pb-20">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-50 h-16 flex items-center px-4">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <a href="?view=home" class="flex items-center gap-2">
                <div class="bg-[#00e054] p-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                </div>
                <span class="text-xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
            </a>
            
            <div class="flex items-center gap-4">
                <form action="index.php" method="GET" class="relative">
                    <input type="hidden" name="view" value="home">
                    <input 
                        type="text" 
                        name="search"
                        value="<?php echo htmlspecialchars($search); ?>"
                        class="bg-[#2c3440] text-white pl-8 pr-4 py-1.5 rounded-full text-sm outline-none w-40 md:w-64 focus:ring-1 focus:ring-[#00e054] transition-all" 
                        placeholder="Search series..."
                    >
                    <div class="absolute left-3 top-2.5 text-[#678]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
                <a href="?view=profile" class="text-[#9ab] hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 pt-24">

        <?php if ($view === 'home'): ?>
            <h2 class="text-[#9ab] uppercase tracking-widest text-xs font-bold mb-6">Trending Series</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php foreach ($filteredShows as $show): ?>
                    <a href="?view=show-detail&id=<?php echo $show['id']; ?>" class="relative group block overflow-hidden rounded-md border-2 border-transparent hover:border-[#00e054] transition-all duration-200">
                        <img src="<?php echo $show['poster']; ?>" alt="<?php echo $show['title']; ?>" class="w-full aspect-[2/3] object-cover">
                        <div class="absolute bottom-0 left-0 right-0 p-2 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-white text-xs font-bold truncate"><?php echo $show['title']; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php if (empty($filteredShows)): ?>
                <p class="text-center py-20 text-[#678]">No series found matching your search.</p>
            <?php endif; ?>

        <?php elseif ($view === 'show-detail' && $selectedShow): ?>
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-10 items-start">
                    <div class="w-48 h-72 flex-shrink-0 overflow-hidden rounded-md border-2 border-[#2c3440]">
                        <img src="<?php echo $selectedShow['poster']; ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h1 class="text-5xl font-black text-white mb-2 leading-tight"><?php echo $selectedShow['title']; ?></h1>
                        <div class="flex items-center gap-4 mb-6 text-sm">
                            <span class="text-[#9ab] font-bold"><?php echo $selectedShow['year']; ?></span>
                            <span class="bg-[#2c3440] px-2 py-0.5 rounded text-xs font-bold text-white uppercase tracking-wider"><?php echo $selectedShow['seasons']; ?> Seasons</span>
                            <div class="flex items-center gap-1 text-[#00e054] font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#00e054" stroke="#00e054" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span><?php echo $selectedShow['rating']; ?></span>
                            </div>
                        </div>
                        <p class="text-xl text-white/90 leading-relaxed mb-8">
                            <?php echo $selectedShow['description']; ?>
                        </p>
                        <div class="flex flex-wrap gap-2 mb-8">
                            <?php 
                            $genres = explode('/', $selectedShow['genre']);
                            foreach ($genres as $g): 
                            ?>
                                <span class="border border-[#2c3440] rounded px-3 py-1 text-[10px] uppercase font-bold text-[#9ab] tracking-widest"><?php echo trim($g); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="?view=home" class="text-xs uppercase tracking-widest font-bold text-[#678] hover:text-[#00e054] flex items-center gap-2 transition-colors">
                            <span>← Back to Discovery</span>
                        </a>
                    </div>
                </div>
            </div>

        <?php elseif ($view === 'profile'): ?>
            <div class="py-10 max-w-4xl mx-auto">
                <div class="flex items-center gap-6 mb-12">
                    <div class="w-24 h-24 bg-[#2c3440] rounded-full flex items-center justify-center border-4 border-[#14181c] ring-2 ring-[#00e054]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter">SeriesFan_01</h1>
                        <p class="text-[#678] font-medium">Member since Dec 2025</p>
                    </div>
                </div>
                <h3 class="uppercase tracking-widest text-[10px] font-bold text-[#678] mb-6 pb-2 border-b border-[#2c3440]">Favorite Series</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <a href="?view=show-detail&id=<?php echo $INITIAL_SHOWS[$i]['id']; ?>" class="block rounded-md overflow-hidden border-2 border-transparent hover:border-[#00e054]">
                            <img src="<?php echo $INITIAL_SHOWS[$i]['poster']; ?>" class="w-full aspect-[2/3] object-cover">
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>