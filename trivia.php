<?php
session_start();

// Trivia Categories
$triviaCategories = [
    'the-rookie' => [
        'title' => 'The Rookie',
        'description' => 'Test your Mid-Wilshire knowledge!',
        'icon' => 'fa-shield-halved',
        'color' => 'blue',
        'questions' => [
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
            ]
        ]
    ],
    'arrow' => [
        'title' => 'Arrow',
        'description' => 'Prove you\'re a Star City hero!',
        'icon' => 'fa-bow-arrow',
        'color' => 'green',
        'questions' => [
            [
                "q" => "What is Oliver Queen's superhero alias?",
                "options" => ["The Flash", "Green Arrow", "The Hood", "Speedy"],
                "correct" => 1
            ],
            [
                "q" => "What city does Oliver Queen protect?",
                "options" => ["Central City", "Gotham City", "Star City", "Metropolis"],
                "correct" => 2
            ],
            [
                "q" => "Who is Oliver Queen's sister?",
                "options" => ["Laurel Lance", "Felicity Smoak", "Thea Queen", "Sara Lance"],
                "correct" => 2
            ],
            [
                "q" => "What island was Oliver stranded on?",
                "options" => ["Lian Yu", "Hong Kong", "Nanda Parbat", "Starling City"],
                "correct" => 0
            ],
            [
                "q" => "Who plays Oliver Queen/Green Arrow?",
                "options" => ["Stephen Amell", "Grant Gustin", "Colton Haynes", "David Ramsey"],
                "correct" => 0
            ],
            [
                "q" => "What is the name of Oliver's best friend and bodyguard?",
                "options" => ["Roy Harper", "John Diggle", "Tommy Merlyn", "Malcolm Merlyn"],
                "correct" => 1
            ],
            [
                "q" => "Who is the Black Canary?",
                "options" => ["Thea Queen", "Moira Queen", "Laurel Lance", "Felicity Smoak"],
                "correct" => 2
            ],
            [
                "q" => "What organization does Malcolm Merlyn lead?",
                "options" => ["HIVE", "League of Assassins", "The Undertaking", "Argus"],
                "correct" => 1
            ],
            [
                "q" => "What is Felicity Smoak's role in Team Arrow?",
                "options" => ["Fighter", "IT/Tech expert", "Doctor", "Lawyer"],
                "correct" => 1
            ],
            [
                "q" => "Who trained Oliver Queen to be a skilled fighter?",
                "options" => ["John Diggle", "Slade Wilson", "Malcolm Merlyn", "All of the above"],
                "correct" => 3
            ]
        ]
    ],
    'nyc' => [
        'title' => 'New York City',
        'description' => 'How well do you know the Big Apple?',
        'icon' => 'fa-city',
        'color' => 'yellow',
        'questions' => [
            [
                "q" => "Which borough is the Statue of Liberty located in?",
                "options" => ["Manhattan", "Brooklyn", "Queens", "Liberty Island (part of Manhattan)"],
                "correct" => 3
            ],
            [
                "q" => "What is the most famous street in NYC for theater?",
                "options" => ["Fifth Avenue", "Broadway", "Wall Street", "Madison Avenue"],
                "correct" => 1
            ],
            [
                "q" => "How many boroughs does NYC have?",
                "options" => ["3", "4", "5", "6"],
                "correct" => 2
            ],
            [
                "q" => "What year did the Twin Towers fall?",
                "options" => ["1999", "2000", "2001", "2002"],
                "correct" => 2
            ],
            [
                "q" => "Which park is known as NYC's 'backyard'?",
                "options" => ["Prospect Park", "Central Park", "Battery Park", "Bryant Park"],
                "correct" => 1
            ],
            [
                "q" => "What is NYC's nickname?",
                "options" => ["The Windy City", "The Big Apple", "The City of Angels", "Sin City"],
                "correct" => 1
            ],
            [
                "q" => "Which subway line is the longest in NYC?",
                "options" => ["A train", "1 train", "Q train", "7 train"],
                "correct" => 0
            ],
            [
                "q" => "What bridge connects Manhattan and Brooklyn?",
                "options" => ["George Washington Bridge", "Brooklyn Bridge", "Manhattan Bridge", "Williamsburg Bridge"],
                "correct" => 1
            ],
            [
                "q" => "What is the tallest building in NYC?",
                "options" => ["Empire State Building", "Chrysler Building", "One World Trade Center", "432 Park Avenue"],
                "correct" => 2
            ],
            [
                "q" => "What famous square is known for New Year's Eve celebrations?",
                "options" => ["Madison Square", "Times Square", "Union Square", "Herald Square"],
                "correct" => 1
            ]
        ]
    ],
    'tech' => [
        'title' => 'Technology',
        'description' => 'Test your tech knowledge!',
        'icon' => 'fa-microchip',
        'color' => 'purple',
        'questions' => [
            [
                "q" => "Who is the founder of Microsoft?",
                "options" => ["Steve Jobs", "Bill Gates", "Elon Musk", "Mark Zuckerberg"],
                "correct" => 1
            ],
            [
                "q" => "What does 'AI' stand for?",
                "options" => ["Automated Intelligence", "Artificial Intelligence", "Advanced Integration", "Applied Information"],
                "correct" => 1
            ],
            [
                "q" => "Which company created the iPhone?",
                "options" => ["Samsung", "Google", "Apple", "Nokia"],
                "correct" => 2
            ],
            [
                "q" => "What programming language is known for web development?",
                "options" => ["Python", "Java", "JavaScript", "C++"],
                "correct" => 2
            ],
            [
                "q" => "What does 'URL' stand for?",
                "options" => ["Universal Resource Locator", "Uniform Resource Locator", "United Reference Link", "Universal Reference Link"],
                "correct" => 1
            ],
            [
                "q" => "Which company owns YouTube?",
                "options" => ["Facebook", "Amazon", "Google", "Microsoft"],
                "correct" => 2
            ],
            [
                "q" => "What year was Facebook founded?",
                "options" => ["2002", "2003", "2004", "2005"],
                "correct" => 2
            ],
            [
                "q" => "What does 'VPN' stand for?",
                "options" => ["Virtual Private Network", "Verified Personal Network", "Visual Private Node", "Virtual Public Network"],
                "correct" => 0
            ],
            [
                "q" => "Who is the CEO of Tesla?",
                "options" => ["Jeff Bezos", "Elon Musk", "Tim Cook", "Sundar Pichai"],
                "correct" => 1
            ],
            [
                "q" => "What is the most popular search engine?",
                "options" => ["Bing", "Yahoo", "Google", "DuckDuckGo"],
                "correct" => 2
            ]
        ]
    ]
];

// Get selected category
$category = $_GET['category'] ?? null;
$score = null;

if ($category && isset($triviaCategories[$category])) {
    $currentTrivia = $triviaCategories[$category];
    $questions = $currentTrivia['questions'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $score = 0;
        foreach ($questions as $index => $item) {
            if (isset($_POST['q' . $index]) && (int)$_POST['q' . $index] === $item['correct']) {
                $score++;
            }
        }
    }
} else {
    $currentTrivia = null;
}

// Header configuration
$current_page = 'trivia';
$page_title = 'Trivia Hub';
$extra_head = '';
?>
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

// Header configuration
$current_page = 'trivia';
$page_title = 'The Rookie Trivia';
$extra_head = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="theme.js"></script>
    <?php echo $extra_head; ?>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors pb-20">
    <?php include 'header.php'; ?>

    <main class="max-w-5xl mx-auto px-4 pt-8 pb-16">
        <?php if (!$currentTrivia): ?>
            <!-- Category Selection -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-black text-slate-800 dark:text-slate-100 mb-2 uppercase tracking-tighter">Trivia Hub</h1>
                <p class="text-slate-600 dark:text-slate-400">Choose your category and test your knowledge!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php 
                $colorMap = [
                    'blue' => 'from-blue-500 to-blue-600',
                    'green' => 'from-green-500 to-green-600',
                    'yellow' => 'from-yellow-500 to-yellow-600',
                    'purple' => 'from-purple-500 to-purple-600',
                ];
                
                foreach ($triviaCategories as $key => $cat): 
                    $gradient = $colorMap[$cat['color']] ?? 'from-indigo-500 to-indigo-600';
                ?>
                    <a href="?category=<?php echo $key; ?>" class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                        <div class="bg-gradient-to-r <?php echo $gradient; ?> p-6 text-white">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas <?php echo $cat['icon']; ?> text-4xl"></i>
                                <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full"><?php echo count($cat['questions']); ?> Questions</span>
                            </div>
                            <h3 class="text-2xl font-black mb-1"><?php echo htmlspecialchars($cat['title']); ?></h3>
                            <p class="text-white/90 text-sm"><?php echo htmlspecialchars($cat['description']); ?></p>
                        </div>
                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-medium">Start Quiz</span>
                            <i class="fas fa-arrow-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            
        <?php else: ?>
            <!-- Quiz Page -->
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center gap-3 mb-8">
                    <a href="trivia" class="text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-black text-slate-800 dark:text-slate-100 mb-2 uppercase tracking-tighter"><?php echo htmlspecialchars($currentTrivia['title']); ?> Trivia</h1>
                    <p class="text-slate-600 dark:text-slate-400"><?php echo htmlspecialchars($currentTrivia['description']); ?></p>
                </div>

                <?php if ($score !== null): ?>
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-lg text-center mb-8">
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2">Quiz Complete!</h2>
                        <p class="text-4xl font-black text-indigo-600 dark:text-indigo-400 mb-4"><?php echo $score; ?> / <?php echo count($questions); ?></p>
                        <?php
                        $percentage = ($score / count($questions)) * 100;
                        if ($percentage >= 80) {
                            echo '<p class="text-green-600 dark:text-green-400 font-bold mb-4">🎉 Excellent!</p>';
                        } elseif ($percentage >= 60) {
                            echo '<p class="text-blue-600 dark:text-blue-400 font-bold mb-4">👍 Good job!</p>';
                        } else {
                            echo '<p class="text-yellow-600 dark:text-yellow-400 font-bold mb-4">💪 Keep trying!</p>';
                        }
                        ?>
                        <div class="flex gap-3 justify-center">
                            <a href="?category=<?php echo $category; ?>" class="inline-block bg-indigo-600 dark:bg-indigo-500 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors">Try Again</a>
                            <a href="trivia" class="inline-block bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold px-6 py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Choose Another</a>
                        </div>
                    </div>
                <?php else: ?>
                    <form method="POST" class="space-y-6">
                        <?php foreach ($questions as $index => $item): ?>
                            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                <p class="text-slate-800 dark:text-slate-100 font-bold mb-4"><?php echo ($index + 1) . ". " . $item['q']; ?></p>
                                <div class="space-y-2">
                                    <?php foreach ($item['options'] as $optIndex => $optText): ?>
                                        <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer border border-transparent hover:border-slate-200 dark:hover:border-slate-600 transition-colors">
                                            <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $optIndex; ?>" required class="accent-indigo-600 dark:accent-indigo-500">
                                            <span class="text-sm text-slate-700 dark:text-slate-300"><?php echo $optText; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white font-black uppercase py-4 rounded-xl hover:bg-indigo-700 dark:hover:bg-indigo-600 hover:scale-[1.02] transition-all shadow-lg">Submit Score</button>
                    </form>
                <?php endif; ?>
            </div>
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