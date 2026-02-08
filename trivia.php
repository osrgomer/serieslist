<?php
// Trivia Questions Data
$questions = [
    [
        "q" => "What is the name of the main character played by Nathan Fillion?",
        "options" => ["Tim Bradford", "John Nolan", "Wade Grey", "Jackson West"],
        "correct" => 1
    ],
    [
        "q" => "Which station do the characters primarily operate out of?",
        "options" => ["Mid-Wilshire", "Central Bureau", "Pacific Division", "Hollywood Station"],
        "correct" => 0
    ],
    [
        "q" => "What business did John Nolan run before joining the LAPD?",
        "options" => ["Car dealership", "Security firm", "Construction company", "Restaurant"],
        "correct" => 2
    ],
    [
        "q" => "Officer Aaron Thorsen uses an app that translates what?",
        "options" => ["Dog barks", "Cat meows", "Police codes", "Baby cries"],
        "correct" => 1
    ],
    [
        "q" => "What is John Nolan's age when he becomes a rookie?",
        "options" => ["35", "40", "45", "50"],
        "correct" => 2
    ],
    [
        "q" => "Who is Tim Bradford's first rookie partner?",
        "options" => ["Lucy Chen", "Jackson West", "John Nolan", "Celina Juarez"],
        "correct" => 0
    ],
    [
        "q" => "What is Lucy Chen's undercover identity when she goes undercover?",
        "options" => ["Rachel", "Sava", "Isabella", "Maria"],
        "correct" => 1
    ],
    [
        "q" => "Who is the Watch Commander of Mid-Wilshire Station?",
        "options" => ["Wade Grey", "Percy West", "Zoe Anderson", "Doug Stanton"],
        "correct" => 0
    ],
    [
        "q" => "What happens to Captain Zoe Anderson?",
        "options" => ["She retires", "She gets promoted", "She is killed by a serial killer", "She transfers"],
        "correct" => 2
    ],
    [
        "q" => "Who does John Nolan date in the first season?",
        "options" => ["Lucy Chen", "Grace Sawyer", "Jessica Russo", "Bailey Nune"],
        "correct" => 1
    ],
    [
        "q" => "What is Angela Lopez's job before becoming a detective?",
        "options" => ["Street cop", "Undercover officer", "Traffic officer", "K9 handler"],
        "correct" => 0
    ],
    [
        "q" => "Who is Wesley Evers?",
        "options" => ["District Attorney", "Defense Attorney", "Judge", "FBI Agent"],
        "correct" => 1
    ],
    [
        "q" => "What crime led to John Nolan becoming a police officer?",
        "options" => ["Home invasion", "Bank robbery", "Car theft", "Kidnapping"],
        "correct" => 1
    ],
    [
        "q" => "Who plays Officer Tim Bradford?",
        "options" => ["Richard T. Jones", "Eric Winter", "Titus Makin Jr.", "Jenna Dewan"],
        "correct" => 1
    ],
    [
        "q" => "What is the nickname of Sergeant Wade Grey?",
        "options" => ["The Boss", "The Commander", "Sarge", "No nickname"],
        "correct" => 2
    ],
    [
        "q" => "Which rookie doesn't make it through the probationary period?",
        "options" => ["Lucy Chen", "Jackson West", "John Nolan", "None of them"],
        "correct" => 3
    ],
    [
        "q" => "What is Tim Bradford's call sign?",
        "options" => ["7-Adam-15", "7-Adam-19", "7-Adam-07", "7-Adam-21"],
        "correct" => 1
    ],
    [
        "q" => "Who does Angela Lopez marry?",
        "options" => ["Jackson West", "Wesley Evers", "James Murray", "Doug Stanton"],
        "correct" => 1
    ],
    [
        "q" => "What type of vehicle is the shop (patrol car)?",
        "options" => ["Ford Crown Victoria", "Dodge Charger", "Chevrolet Caprice", "Ford Explorer"],
        "correct" => 1
    ],
    [
        "q" => "What does P1 mean in LAPD radio codes?",
        "options" => ["Priority 1 - Emergency", "Patrol 1", "Police 1", "Precinct 1"],
        "correct" => 0
    ],
    [
        "q" => "Who kidnaps Lucy Chen?",
        "options" => ["Rosalind Dyer", "Caleb Wright", "Oscar Hutchinson", "Sandra de la Cruz"],
        "correct" => 1
    ],
    [
        "q" => "What is Bailey Nune's profession?",
        "options" => ["Nurse", "Firefighter", "Paramedic", "Doctor"],
        "correct" => 1
    ],
    [
        "q" => "Which character is played by Melissa O'Neil?",
        "options" => ["Angela Lopez", "Lucy Chen", "Nyla Harper", "Bailey Nune"],
        "correct" => 1
    ],
    [
        "q" => "What gang organization is a recurring antagonist in the series?",
        "options" => ["Los Angelicos", "Southern Front", "SoCal Mafia", "La Fiera's Cartel"],
        "correct" => 1
    ]
];

$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($questions as $index => $item) {
        if (isset($_POST['q' . $index]) && (int)$_POST['q' . $index] === $item['correct']) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rookie Trivia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f8fafc; color: #334155; font-family: -apple-system, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 pb-20">
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">L</div>
                <span class="font-bold text-xl tracking-tight hidden sm:block">Series<span class="text-indigo-600">List</span></span>
                <span class="font-bold text-lg tracking-tight sm:hidden">SL</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Library</a>
                <a href="trivia.php" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Trivia</a>
                <a href="tts/index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Voice</a>
                <a href="account.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Account</a>
            </div>
            <div class="flex items-center gap-2">
                <div class="md:hidden relative">
                    <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
                        <a href="index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Library</a>
                        <a href="trivia.php" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Trivia</a>
                        <a href="tts/index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Voice</a>
                        <a href="account.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Account</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 pt-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-slate-800 mb-2 uppercase tracking-tighter">The Rookie Trivia</h1>
            <p class="text-slate-600">Test your Mid-Wilshire knowledge!</p>
        </div>

        <?php if ($score !== null): ?>
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-lg text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Quiz Complete!</h2>
                <p class="text-4xl font-black text-indigo-600 mb-4"><?php echo $score; ?> / <?php echo count($questions); ?></p>
                <a href="trivia.php" class="inline-block bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">Try Again</a>
            </div>
        <?php else: ?>
            <form method="POST" class="space-y-6">
                <?php foreach ($questions as $index => $item): ?>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <p class="text-slate-800 font-bold mb-4"><?php echo ($index + 1) . ". " . $item['q']; ?></p>
                        <div class="space-y-2">
                            <?php foreach ($item['options'] as $optIndex => $optText): ?>
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer border border-transparent hover:border-slate-200 transition-colors">
                                    <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $optIndex; ?>" required class="accent-indigo-600">
                                    <span class="text-sm text-slate-700"><?php echo $optText; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase py-4 rounded-xl hover:bg-indigo-700 hover:scale-[1.02] transition-all shadow-lg">Submit Score</button>
            </form>
        <?php endif; ?>
    </main>
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').onclick = () => {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        };
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const menu = document.getElementById('mobileMenu');
            const btn = document.getElementById('mobileMenuBtn');
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>