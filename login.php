<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-4">
    
    <div class="mb-8 flex items-center gap-2">
        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">L</div>
        <span class="text-2xl font-black text-slate-800 tracking-tight">Series<span class="text-indigo-600">List</span></span>
    </div>

    <div id="authContainer" class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-slate-200">
        <div id="loginForm">
            <h2 class="text-slate-800 text-2xl font-bold mb-1">Login</h2>
            <p class="text-slate-600 text-sm mb-6">Access your watchlist and ratings</p>

            <div id="successMsg" class="hidden mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                Login successful! Redirecting...
            </div>

            <form id="actualForm" onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-600 mb-2">Email Address</label>
                    <input type="email" required class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-600 mb-2">Password</label>
                    <input type="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all transform active:scale-[0.98]">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-slate-600">New to SeriesList?</span>
                <button onclick="toggleAuth()" class="text-indigo-600 hover:text-indigo-700 font-bold ml-1">Create account</button>
            </div>
        </div>

        <div id="registerForm" class="hidden">
            <h2 class="text-slate-800 text-2xl font-bold mb-1">Join the Club</h2>
            <p class="text-slate-600 text-sm mb-6">Track every show you watch</p>
            
            <form onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-600 mb-2">Full Name</label>
                    <input type="text" required class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-600 mb-2">Email</label>
                    <input type="email" required class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-600 mb-2">Password</label>
                    <input type="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full bg-slate-600 hover:bg-slate-700 text-white font-bold py-3 rounded-lg transition-all">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-slate-600">Already a member?</span>
                <button onclick="toggleAuth()" class="text-indigo-600 hover:text-indigo-700 font-bold ml-1">Sign in</button>
            </div>
        </div>
    </div>

    <a href="index.php" class="mt-8 text-slate-600 hover:text-slate-800 text-sm transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>
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