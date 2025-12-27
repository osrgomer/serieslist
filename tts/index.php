<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Vocalist AI - Browser TTS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 p-4 md:p-8 flex justify-center font-sans">

  <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

    <!-- Status bar -->
    <div id="statusBar" class="px-6 py-2.5 flex justify-between text-[10px] uppercase tracking-[0.2em] font-black bg-emerald-500 text-white">
      <span id="statusText">System Ready</span>
      <span>v2.5-TTS</span>
    </div>

    <div class="p-8 space-y-6">

      <h1 class="text-2xl font-black text-slate-800">Vocalist AI</h1>

      <!-- Controls -->
      <div class="grid grid-cols-2 gap-4">
        <select id="voice" class="p-4 bg-slate-50 rounded-2xl font-bold">
          <option>Kore</option>
          <option>Zephyr</option>
          <option>Puck</option>
          <option>Charon</option>
          <option>Fenrir</option>
          <option>Leda</option>
          <option>Orus</option>
          <option>Aoede</option>
        </select>

        <input id="persona" class="p-4 bg-slate-50 rounded-2xl font-bold" value="cheerful" />
      </div>

      <!-- Textarea -->
      <textarea id="text"
        class="w-full h-36 p-5 bg-slate-50 rounded-3xl resize-none"
      >Hello! I am ready to speak.</textarea>

      <button id="generateBtn"
        class="w-full py-5 rounded-3xl font-black text-white bg-slate-900 hover:bg-indigo-600 transition-all">
        Generate Voice
      </button>

      <!-- Logs -->
      <div>
        <div class="flex justify-between text-[10px] uppercase text-slate-400 mb-2">
          <span>Process Monitor</span>
          <button id="clearLogs" class="text-indigo-500">Wipe Logs</button>
        </div>

        <div id="logs"
          class="bg-slate-900 rounded-3xl p-4 h-44 overflow-y-auto text-emerald-400 font-mono text-xs">
          Awaiting Pipeline Input
        </div>
      </div>

    </div>
  </div>

<script src="app.js"></script>
</body>
</html>
