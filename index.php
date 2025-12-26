<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Browse TV Shows</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #14181c; color: #9ab; font-family: sans-serif; }
        .show-card:hover .overlay { opacity: 1; }
        .glass { background: rgba(20, 24, 28, 0.95); backdrop-filter: blur(4px); }
    </style>
</head>
<body>
    <?php
    // Mock Session Logic
    $isLoggedIn = isset($_GET['mock_login']) && $_GET['mock_login'] === 'true';
    $profileLink = $isLoggedIn ? "account.php" : "login.php";
    ?>

    <!-- Navigation -->
    <nav class="border-b border-[#2c3440] py-4 px-6 sticky top-0 z-50 glass">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="index.php" class="flex items-center gap-2">
                    <div class="bg-[#00e054] p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="3"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                    </div>
                    <span class="text-xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
                </a>
                <div class="hidden md:flex gap-6 text-[11px] font-bold uppercase tracking-widest">
                    <a href="#" class="text-white">Series</a>
                    <a href="#" class="hover:text-white">Watchlist</a>
                    <a href="#" class="hover:text-white">People</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <?php if ($isLoggedIn): ?>
                    <!-- Logged In State -->
                    <div class="relative group">
                        <a href="account.php" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#00e054] to-blue-500 flex items-center justify-center text-[#14181c] font-bold text-xs">
                                JD
                            </div>
                            <span class="text-white text-xs font-bold hidden sm:inline">John Doe</span>
                        </a>
                        <!-- Dropdown -->
                        <div class="absolute right-0 mt-2 w-48 bg-[#2c3440] border border-[#456] rounded shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <a href="account.php" class="block px-4 py-2 text-xs text-white hover:bg-[#456]">Profile</a>
                            <a href="index.php" class="block px-4 py-2 text-xs text-[#ff4b4b] hover:bg-[#456]">Sign Out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest State -->
                    <a href="login.php" class="text-[11px] font-bold uppercase tracking-widest hover:text-white">Sign In</a>
                    <a href="login.php" class="bg-[#456] text-white text-[11px] font-bold uppercase tracking-widest px-4 py-2 rounded hover:bg-[#567]">Join</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-12">
        <section>
            <div class="flex justify-between items-end border-b border-[#2c3440] pb-2 mb-6">
                <h2 class="text-[#9ab] text-xs font-bold uppercase tracking-widest">Popular this week</h2>
                <a href="#" class="text-[10px] text-[#678] uppercase font-bold hover:text-white">More</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
                <!-- Show Cards -->
                <?php
                $shows = [
                    ['title' => 'Shogun', 'year' => '2024', 'rating' => '4.5', 'color' => 'from-orange-900'],
                    ['title' => 'The Bear', 'year' => '2023', 'rating' => '4.8', 'color' => 'from-blue-900'],
                    ['title' => 'Succession', 'year' => '2018', 'rating' => '4.9', 'color' => 'from-gray-900'],
                    ['title' => 'Severance', 'year' => '2022', 'rating' => '4.4', 'color' => 'from-teal-900'],
                    ['title' => 'The Boys', 'year' => '2019', 'rating' => '4.2', 'color' => 'from-red-900'],
                    ['title' => 'Fallout', 'year' => '2024', 'rating' => '4.6', 'color' => 'from-yellow-900'],
                ];

                foreach ($shows as $show):
                ?>
                <div class="show-card relative group cursor-pointer">
                    <div class="aspect-[2/3] bg-gradient-to-b <?php echo $show['color']; ?> to-[#1a2028] rounded border border-[#2c3440] overflow-hidden transition-all group-hover:border-[#00e054] group-hover:scale-[1.02]">
                        <div class="absolute inset-0 flex items-center justify-center p-4 text-center">
                             <span class="text-white font-black text-xl italic uppercase leading-none"><?php echo $show['title']; ?></span>
                        </div>
                        <div class="overlay absolute inset-0 bg-black/80 opacity-0 transition-opacity flex flex-col items-center justify-center p-4">
                            <div class="flex gap-1 mb-2">
                                <svg class="text-[#00e054] w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-white font-bold text-sm"><?php echo $show['rating']; ?></span>
                            </div>
                            <button class="bg-white text-black text-[10px] font-black uppercase px-3 py-1.5 rounded-sm hover:bg-[#00e054] transition-colors">Details</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>