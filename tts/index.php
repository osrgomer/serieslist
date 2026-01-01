<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vocalist AI - Browser TTS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 font-sans">

  <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">L</div>
        <span class="font-bold text-xl tracking-tight hidden sm:block">Series<span class="text-indigo-600">List</span></span>
        <span class="font-bold text-lg tracking-tight sm:hidden">SL</span>
      </div>
      <div class="hidden md:flex items-center gap-1">
        <a href="../index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Library</a>
        <a href="../trivia.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Trivia</a>
        <a href="index.php" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Voice</a>
        <a href="../account.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Account</a>
      </div>
      <div class="flex items-center gap-2">
        <div class="md:hidden relative">
          <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
            <i class="fas fa-bars"></i>
          </button>
          <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
            <a href="../index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Library</a>
            <a href="../trivia.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Trivia</a>
            <a href="index.php" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Voice</a>
            <a href="../account.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Account</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-2xl mx-auto p-4 md:p-8 flex justify-center">
    <div class="w-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

      <!-- Status bar -->
      <div id="statusBar" class="px-6 py-2.5 flex justify-between text-[10px] uppercase tracking-[0.2em] font-black bg-indigo-600 text-white">
        <span id="statusText">System Ready</span>
        <span>v2.5-TTS</span>
      </div>

      <div class="p-6 sm:p-8 space-y-6">

        <h1 class="text-2xl font-black text-slate-800">Vocalist AI</h1>

        <!-- Controls -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <select id="voice" class="p-4 bg-slate-50 rounded-2xl font-bold border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="default">System Default</option>
            <option value="female">Female Voice</option>
            <option value="male">Male Voice</option>
            <option value="google">Google US English</option>
            <option value="microsoft">Microsoft Voice</option>
          </select>

          <input id="persona" class="p-4 bg-slate-50 rounded-2xl font-bold border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none" value="cheerful" />
        </div>

        <!-- Textarea -->
        <textarea id="text"
          class="w-full h-36 p-5 bg-slate-50 rounded-3xl resize-none border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none"
        >Hello! I am ready to speak.</textarea>

        <button id="generateBtn"
          class="w-full py-5 rounded-3xl font-black text-white bg-slate-900 hover:bg-indigo-600 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
          Generate Voice
        </button>

        <!-- Logs -->
        <div>
          <div class="flex justify-between text-[10px] uppercase text-slate-400 mb-2">
            <span>Process Monitor</span>
            <button id="clearLogs" class="text-indigo-500 hover:text-indigo-600 transition-colors">Wipe Logs</button>
          </div>

          <div id="logs"
            class="bg-slate-900 rounded-3xl p-4 h-44 overflow-y-auto text-emerald-400 font-mono text-xs">
            Awaiting Pipeline Input
          </div>
        </div>

      </div>
    </div>
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
<script src="app.js"></script>
</body>
</html>
