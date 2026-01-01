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
            <option value="ai-bella">AI Bella (Local)</option>
            <option value="ai-heart">AI Heart (Local)</option>
            <option value="ai-sky">AI Sky (Local)</option>
            <option value="ai-adam">AI Adam (Local)</option>
            <option value="ai-emma">AI Emma (Local)</option>
            <option value="deutsch">Google Deutsch</option>
            <option value="français">Google Français</option>
            <option value="español">Google Español</option>
            <option value="italiano">Google Italiano</option>
            <option value="português">Google Português</option>
            <option value="русский">Google Русский</option>
            <option value="日本語">Google 日本語</option>
            <option value="한국의">Google 한국의</option>
            <option value="中文">Google 中文</option>
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

<script type="module">
  import { KokoroTTS } from "https://cdn.jsdelivr.net/npm/kokoro-js@1.2.1/dist/kokoro.web.min.js";
  
  let isGenerating = false;
  let logs = [];
  let aiTTS = null;

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

  // Initialize AI TTS
  async function initAI() {
    if (aiTTS) return aiTTS;
    addLog("Loading AI Model (90MB)... please wait.");
    
    try {
      aiTTS = await KokoroTTS.from_pretrained("onnx-community/Kokoro-82M-v1.0-ONNX", {
        dtype: "q8",
        device: "wasm"
      });
      addLog("AI TTS Model Ready!");
      return aiTTS;
    } catch (err) {
      addLog(`AI Model Error: ${err.message}`);
      return null;
    }
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

  // Main TTS handler
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
      // Check if it's an AI voice
      if (voiceName.startsWith('ai-')) {
        const model = await initAI();
        if (!model) {
          addLog("AI model not available, falling back to system voice");
          await handleSystemVoice(text, voiceName, persona);
          return;
        }
        
        addLog("Generating AI audio...");
        const voiceMap = {
          'ai-bella': 'af_bella',
          'ai-heart': 'af_heart', 
          'ai-sky': 'af_sky',
          'ai-adam': 'am_adam',
          'ai-emma': 'bf_emma'
        };
        
        const aiVoice = voiceMap[voiceName] || 'af_heart';
        const audioData = await model.generate(text, { voice: aiVoice });
        
        addLog(`Using AI voice: ${aiVoice}`);
        addLog("AI playback started");
        
        // Create blob URL and play with HTML audio element
        const audioBlob = new Blob([audioData], { type: 'audio/wav' });
        const audioUrl = URL.createObjectURL(audioBlob);
        const audio = new Audio(audioUrl);
        
        audio.onended = () => {
          addLog("AI playback finished");
          URL.revokeObjectURL(audioUrl);
          isGenerating = false;
          btn.textContent = "Generate Voice";
          btn.disabled = false;
        };
        
        audio.onerror = (e) => {
          addLog(`AI playback error: ${e.target.error?.message || 'Unknown error'}`);
          addLog("Falling back to system voice...");
          URL.revokeObjectURL(audioUrl);
          handleSystemVoice(text, 'female', persona);
        };
        
        audio.oncanplaythrough = () => {
          addLog("AI audio ready, starting playback");
        };
        
        try {
          await audio.play();
        } catch (playError) {
          addLog(`Play failed: ${playError.message}`);
          addLog("Falling back to system voice...");
          URL.revokeObjectURL(audioUrl);
          await handleSystemVoice(text, 'female', persona);
        }
      } else {
        await handleSystemVoice(text, voiceName, persona);
      }
    } catch (err) {
      addLog("Error: " + err.message);
      isGenerating = false;
      btn.textContent = "Generate Voice";
      btn.disabled = false;
    }
  };

  // Handle system voices
  async function handleSystemVoice(text, voiceName, persona) {
    await waitForVoices();
    
    speechSynthesis.cancel();
    const utterance = new SpeechSynthesisUtterance(text);

    const voices = speechSynthesis.getVoices();
    let selectedVoice = null;
    
    // Try to find the requested voice with simpler patterns
    if (voiceName && voiceName !== 'default') {
      const voicePatterns = {
        'uk': ['uk', 'britain', 'british', 'gb'],
        'us': ['us', 'united states', 'america'],
        'whisper': ['whisper', 'soft'],
        'robot': ['robot', 'synthetic'],
        'deutsch': ['deutsch', 'german', 'de-'],
        'français': ['français', 'french', 'fr-'],
        'español': ['español', 'spanish', 'es-'],
        'italiano': ['italiano', 'italian', 'it-'],
        'português': ['português', 'portuguese', 'pt-'],
        'русский': ['русский', 'russian', 'ru-'],
        '日本語': ['日本語', 'japanese', 'ja-'],
        '한국의': ['한국의', 'korean', 'ko-'],
        '中文': ['中文', '國語', '粤語', '普通话', 'chinese', 'zh-']
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
  }

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

  // Initialize voices when page loads
  window.addEventListener('load', async () => {
    await waitForVoices();
    addLog("Speech synthesis ready");
    addLog(`Available voices: ${speechSynthesis.getVoices().length}`);
  });
</script>
</body>
</html>
