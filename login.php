<?php
// Mock logic for the login page
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        $message = "Login successful! Redirecting...";
        // In a real app, you'd verify against a database and start a session
    } else {
        $message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> 
        body { background-color: #14181c; color: #9ab; font-family: sans-serif; } 
        .glass { background: rgba(44, 52, 64, 0.5); backdrop-filter: blur(4px); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full glass p-8 rounded-xl border border-[#2c3440] shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-block bg-[#00e054] p-2 rounded-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="2.5"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
            </div>
            <h1 class="text-2xl font-black text-white uppercase italic tracking-tighter">Sign In</h1>
            <p class="text-xs text-[#678] mt-2 uppercase tracking-widest font-bold">Access your watchlist</p>
        </div>

        <?php if ($message): ?>
            <div class="mb-6 p-3 rounded bg-[#00e054]/10 border border-[#00e054]/50 text-[#00e054] text-sm text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-[10px] uppercase font-bold text-[#678] mb-1 ml-1">Email Address</label>
                <input type="email" name="email" required class="w-full bg-[#14181c] border border-[#2c3440] rounded-lg px-4 py-3 text-white outline-none focus:border-[#00e054] transition-colors">
            </div>
            <div>
                <label class="block text-[10px] uppercase font-bold text-[#678] mb-1 ml-1">Password</label>
                <input type="password" name="password" required class="w-full bg-[#14181c] border border-[#2c3440] rounded-lg px-4 py-3 text-white outline-none focus:border-[#00e054] transition-colors">
            </div>
            <button type="submit" class="w-full bg-[#00e054] text-[#14181c] font-black uppercase tracking-widest py-3 rounded-lg hover:brightness-110 transition-all mt-4">
                Login
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#2c3440] text-center">
            <p class="text-sm">New to SeriesList? <a href="register.php" class="text-white hover:text-[#00e054] font-bold transition-colors">Create account</a></p>
            <a href="index.php" class="inline-block mt-4 text-xs uppercase tracking-widest font-bold text-[#678] hover:text-white transition-colors">← Back to Browse</a>
        </div>
    </div>
</body>
</html>