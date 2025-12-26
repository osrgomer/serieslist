<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #14181c; color: #9ab; font-family: sans-serif; }
        .glass { background: rgba(44, 52, 64, 0.5); backdrop-filter: blur(8px); }
        .auth-card { border: 1px solid #2c3440; transition: transform 0.3s ease; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">
    
    <div class="mb-8 flex items-center gap-2">
        <div class="bg-[#00e054] p-1.5 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#14181c" stroke-width="3"><path d="M2 8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8Z"/><polyline points="7 21 12 16 17 21"/></svg>
        </div>
        <span class="text-2xl font-black text-white italic uppercase tracking-tighter">SeriesList</span>
    </div>

    <div id="authContainer" class="w-full max-w-md glass p-8 rounded-xl auth-card shadow-2xl">
        <div id="loginForm">
            <h2 class="text-white text-2xl font-bold mb-1">Login</h2>
            <p class="text-[#678] text-sm mb-6">Access your watchlist and ratings</p>

            <div id="successMsg" class="hidden mb-4 p-3 bg-[#00e054]/20 border border-[#00e054] text-[#00e054] text-sm rounded">
                Login successful! Redirecting...
            </div>

            <form id="actualForm" onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-[#678] mb-2">Email Address</label>
                    <input type="email" required class="w-full bg-[#14181c] border border-[#2c3440] rounded p-3 text-white focus:outline-none focus:border-[#00e054] transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-[#678] mb-2">Password</label>
                    <input type="password" required class="w-full bg-[#14181c] border border-[#2c3440] rounded p-3 text-white focus:outline-none focus:border-[#00e054] transition-colors">
                </div>
                <button type="submit" class="w-full bg-[#00e054] hover:bg-[#00c044] text-[#14181c] font-bold py-3 rounded transition-all transform active:scale-[0.98]">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-[#678]">New to SeriesList?</span>
                <button onclick="toggleAuth()" class="text-white hover:text-[#00e054] font-bold ml-1">Create account</button>
            </div>
        </div>

        <div id="registerForm" class="hidden">
            <h2 class="text-white text-2xl font-bold mb-1">Join the Club</h2>
            <p class="text-[#678] text-sm mb-6">Track every show you watch</p>
            
            <form onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-[#678] mb-2">Full Name</label>
                    <input type="text" required class="w-full bg-[#14181c] border border-[#2c3440] rounded p-3 text-white focus:outline-none focus:border-[#00e054]">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-[#678] mb-2">Email</label>
                    <input type="email" required class="w-full bg-[#14181c] border border-[#2c3440] rounded p-3 text-white focus:outline-none focus:border-[#00e054]">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-[#678] mb-2">Password</label>
                    <input type="password" required class="w-full bg-[#14181c] border border-[#2c3440] rounded p-3 text-white focus:outline-none focus:border-[#00e054]">
                </div>
                <button type="submit" class="w-full bg-[#456] hover:bg-[#567] text-white font-bold py-3 rounded transition-all">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-[#678]">Already a member?</span>
                <button onclick="toggleAuth()" class="text-white hover:text-[#00e054] font-bold ml-1">Sign in</button>
            </div>
        </div>
    </div>

    <a href="index.php" class="mt-8 text-[#678] hover:text-white text-sm transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
        Back to Browse
    </a>

    <script>
        function toggleAuth() {
            document.getElementById('loginForm').classList.toggle('hidden');
            document.getElementById('registerForm').classList.toggle('hidden');
        }

        function handleLogin(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const success = document.getElementById('successMsg');
            
            // UI Feedback
            btn.disabled = true;
            btn.innerText = 'Authenticating...';
            
            if (success) success.classList.remove('hidden');

            // Simulate server delay then redirect
            // We append mock_login=true so index.php lets us in
            setTimeout(() => {
                window.location.href = 'index.php?mock_login=true';
            }, 1200);
        }
    </script>
</body>
</html>