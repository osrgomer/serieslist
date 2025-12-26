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
        body { background-color: #14181c; color: #9ab; }
    </style>
</head>
<body class="min-h-screen pb-20">
    <nav class="bg-[#14181c] border-b border-[#2c3440] h-16 flex items-center px-4 mb-8">
        <div class="max-w-6xl mx-auto w-full flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2">
                <div class="bg-[#00e054] p-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
                </div>
                <span class="text-xl font-black text-white italic uppercase">SeriesList</span>
            </a>
            <a href="/" class="text-xs uppercase font-bold tracking-widest text-[#678] hover:text-white">Back to Home</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-white italic mb-2 uppercase italic tracking-tighter">The Rookie Trivia</h1>
            <p class="text-[#678]">Test your Mid-Wilshire knowledge!</p>
        </div>

        <?php if ($score !== null): ?>
            <div class="bg-[#2c3440] p-8 rounded-lg border-2 border-[#00e054] text-center mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Quiz Complete!</h2>
                <p class="text-4xl font-black text-[#00e054] mb-4"><?php echo $score; ?> / <?php echo count($questions); ?></p>
                <a href="trivia.php" class="inline-block bg-[#00e054] text-[#14181c] font-bold px-6 py-2 rounded hover:bg-white transition-colors">Try Again</a>
            </div>
        <?php else: ?>
            <form method="POST" class="space-y-6">
                <?php foreach ($questions as $index => $item): ?>
                    <div class="bg-[#2c3440] p-6 rounded-lg border border-[#456]">
                        <p class="text-white font-bold mb-4"><?php echo ($index + 1) . ". " . $item['q']; ?></p>
                        <div class="space-y-2">
                            <?php foreach ($item['options'] as $optIndex => $optText): ?>
                                <label class="flex items-center gap-3 p-3 rounded hover:bg-[#14181c] cursor-pointer border border-transparent hover:border-[#678]">
                                    <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $optIndex; ?>" required class="accent-[#00e054]">
                                    <span class="text-sm"><?php echo $optText; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="w-full bg-[#00e054] text-[#14181c] font-black uppercase py-4 rounded-lg hover:scale-[1.02] transition-transform">Submit Score</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>