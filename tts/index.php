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
        <a href="../" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Library</a>
        <a href="../trivia" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Trivia</a>
        <a href="../voice" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Voice</a>
        <a href="../account" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Account</a>
      </div>
      <div class="flex items-center gap-2">
        <div class="md:hidden relative">
          <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
            <i class="fas fa-bars"></i>
          </button>
          <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
            <a href="../" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Library</a>
            <a href="../trivia" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Trivia</a>
            <a href="../voice" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Voice</a>
            <a href="../account" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Account</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-2xl mx-auto p-4 md:p-8 flex justify-center">
    <div class="w-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

      <!-- Status bar -->
      <div id="statusBar" class="px-6 py-2.5 flex justify-between text-xs font-semibold tracking-wide bg-indigo-600 text-white">
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
            <option value="google">Google Voice</option>
            <option value="microsoft">Microsoft Voice</option>
            <option value="uk">UK English</option>
            <option value="us">US English</option>
            <option value="whisper">Whisper Mode</option>
            <option value="robot">Robot Voice</option>
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

        <button id="debugBtn"
          class="w-full py-3 rounded-2xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all text-sm">
          Show Available Voices
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
  let isGenerating = false;
  let logs = [];

  const btn = document.getElementById("generateBtn");
  const logsEl = document.getElementById("logs");
  const textEl = document.getElementById("text");
  const voiceEl = document.getElementById("voice");
  const personaEl = document.getElementById("persona");
  const clearBtn = document.getElementById("clearLogs");

  function addLog(msg) {
    const time = new Date().toLocaleTimeString("en-GB");
    logs.unshift(`[${time}] ${msg}`);
    logs = logs.slice(0, 15);
    logsEl.innerHTML = logs.map(l => `<div class="mb-1">${l}</div>`).join("");
  }

  // clear logs
  clearBtn.onclick = () => {
    logs = [];
    logsEl.innerHTML = "Awaiting Pipeline Input";
  };

  // Wait for voices to load
  function waitForVoices() {
    return new Promise(resolve => {
      if (speechSynthesis.getVoices().length > 0) {
        resolve();
      } else {
        speechSynthesis.onvoiceschanged = () => resolve();
      }
    });
  }

  // browser TTS handler
  btn.onclick = async () => {
    if (isGenerating) return;
    const text = textEl.value.trim();
    if (!text) {
      addLog("Error: No text provided");
      return;
    }

    const voiceName = voiceEl.value;
    const persona = personaEl.value;

    addLog(`Initiating request for ${voiceName}...`);
    isGenerating = true;
    btn.textContent = "Speaking...";
    btn.disabled = true;

    try {
      // Wait for voices to be available
      await waitForVoices();
      
      speechSynthesis.cancel();
      const utterance = new SpeechSynthesisUtterance(text);

      // Set voice properties
      const voices = speechSynthesis.getVoices();
      let selectedVoice = null;
      
      // Try to find the requested voice with simpler patterns
      if (voiceName && voiceName !== 'default') {
        const voicePatterns = {
          'uk': ['uk', 'britain', 'british', 'gb'],
          'us': ['us', 'united states', 'america'],
          'whisper': ['whisper', 'soft'],
          'robot': ['robot', 'synthetic'],
        };
        
        const patterns = voicePatterns[voiceName.toLowerCase()] || [voiceName.toLowerCase()];
        
        selectedVoice = voices.find(v => 
          patterns.some(pattern => 
            v.name.toLowerCase().includes(pattern) || 
            v.lang.toLowerCase().includes(pattern)
          )
        );
        
        // Check if we found an exact match or using fallback
        if (selectedVoice) {
          const isExactMatch = patterns.some(pattern => 
            selectedVoice.name.toLowerCase().includes(pattern) || 
            selectedVoice.lang.toLowerCase().includes(pattern)
          );
          
          if (!isExactMatch) {
            addLog(`Requested '${voiceName}' not found, using fallback: ${selectedVoice.name}`);
          } else {
            addLog(`Using voice: ${selectedVoice.name}`);
          }
        }
      }
      
      // Fallback to first female English voice, then any English voice, then first available
      if (!selectedVoice) {
        selectedVoice = voices.find(v => v.lang.startsWith('en') && v.name.toLowerCase().includes('female')) ||
                      voices.find(v => v.lang.startsWith('en')) || 
                      voices[0];
      }
      
      if (selectedVoice) {
        utterance.voice = selectedVoice;
      } else {
        addLog(`Using system default voice (${voiceName} not available)`);
      }

      // Adjust speech based on persona and voice type
      switch(persona.toLowerCase()) {
        case 'cheerful':
          utterance.pitch = 1.2;
          utterance.rate = 1.1;
          break;
        case 'serious':
          utterance.pitch = 0.8;
          utterance.rate = 0.9;
          break;
        case 'calm':
          utterance.pitch = 1.0;
          utterance.rate = 0.8;
          break;
        case 'excited':
          utterance.pitch = 1.3;
          utterance.rate = 1.2;
          break;
        case 'mysterious':
          utterance.pitch = 0.7;
          utterance.rate = 0.7;
          break;
        default:
          utterance.pitch = 1.0;
          utterance.rate = 1.0;
      }
      
      // Special voice modifications
      if (voiceName === 'whisper') {
        utterance.volume = 0.3;
        utterance.rate = 0.6;
      } else if (voiceName === 'robot') {
        utterance.pitch = 0.5;
        utterance.rate = 0.8;
      } else if (voiceName === 'narrator') {
        utterance.pitch = 0.9;
        utterance.rate = 0.85;
      }

      utterance.onstart = () => {
        addLog("Playback started successfully.");
      };

      utterance.onend = () => {
        isGenerating = false;
        btn.textContent = "Generate Voice";
        btn.disabled = false;
        addLog("Playback finished.");
      };

      utterance.onerror = (event) => {
        addLog(`Speech Error: ${event.error}`);
        isGenerating = false;
        btn.textContent = "Generate Voice";
        btn.disabled = false;
      };

      speechSynthesis.speak(utterance);

    } catch (err) {
      addLog("Speech Error: " + err.message);
      isGenerating = false;
      btn.textContent = "Generate Voice";
      btn.disabled = false;
    }
  };

  // Initialize voices when page loads
  window.addEventListener('load', async () => {
    await waitForVoices();
    addLog("Speech synthesis ready");
    addLog(`Available voices: ${speechSynthesis.getVoices().length}`);
  });

  // Debug button to show available voices
  document.getElementById('debugBtn').onclick = () => {
    const voices = speechSynthesis.getVoices();
    addLog(`=== Available Voices (${voices.length}) ===`);
    voices.forEach((voice, i) => {
      addLog(`${i+1}. ${voice.name} (${voice.lang})`);
    });
    addLog(`=== End Voice List ===`);
  };

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
