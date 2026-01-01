<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .modal-backdrop { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); }
        .animate-in { animation: fadeIn 0.2s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .spinner { border: 3px solid rgba(79, 70, 229, 0.1); border-top: 3px solid #4f46e5; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Better focus states for accessibility */
        button:focus, input:focus, select:focus {
            outline: 2px solid #4f46e5;
            outline-offset: 2px;
        }
        
        /* Smooth transitions */
        * { transition: all 0.2s ease; }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .mobile-stack { flex-direction: column; gap: 0.5rem; }
            .mobile-full { width: 100%; }
            .mobile-text-sm { font-size: 0.75rem; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">L</div>
                <span class="font-bold text-xl tracking-tight hidden sm:block">Series<span class="text-indigo-600">List</span></span>
                <span class="font-bold text-lg tracking-tight sm:hidden">SL</span>
            </div>
            <nav class="hidden md:flex items-center gap-1">
                <a href="index.php" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Library</a>
                <a href="trivia.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Trivia</a>
                <a href="tts/index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Voice</a>
                <a href="account.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Account</a>
            </nav>
            <div class="flex items-center gap-2">
                <div class="md:hidden relative">
                    <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
                        <a href="index.php" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Library</a>
                        <a href="trivia.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Trivia</a>
                        <a href="tts/index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Voice</a>
                        <a href="account.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Account</a>
                    </div>
                </div>
                <button id="settingsBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Settings">
                    <i class="fas fa-cog"></i>
                </button>
                <button id="addBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 sm:px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 shadow-md active:scale-95">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add Series</span><span class="sm:hidden">Add</span>
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-4 space-y-6">
        <!-- Connection Banner -->
        <div id="connectionBanner" class="hidden bg-amber-50 border border-amber-200 p-3 rounded-xl text-amber-800 text-xs font-medium flex items-center gap-2">
            <i class="fas fa-wifi-slash"></i> Offline Mode: Saving locally until connection restored.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Your Library</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span id="statCount" class="text-2xl sm:text-3xl font-black text-slate-800">0</span>
                    <span class="text-slate-400 text-sm">Entries</span>
                </div>
            </div>
            <div class="lg:col-span-2 bg-slate-900 rounded-2xl p-4 sm:p-5 text-white shadow-lg relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                <h3 class="font-bold mb-1 flex items-center gap-2 text-sm sm:text-base"><i class="fas fa-wand-magic-sparkles text-indigo-400"></i> AI Insights</h3>
                <p id="aiStatus" class="text-slate-400 text-xs sm:text-sm mb-3 min-h-[1.25rem]">Initializing storage...</p>
                <button id="recBtn" class="bg-indigo-600 text-white px-4 sm:px-5 py-2 rounded-full text-xs font-bold hover:bg-indigo-500 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">Get Recommendation</button>
            </div>
        </div>

        <div id="listGrid" class="grid grid-cols-1 gap-3">
            <div id="statusMessage" class="py-20 text-center text-slate-400">
                <div class="spinner mx-auto mb-4"></div>
                <p id="loadingText">Connecting to cloud storage...</p>
            </div>
        </div>
    </main>

    <!-- Modals -->
    <div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="this.parentElement.classList.add('hidden')"></div>
        <div class="bg-white rounded-2xl w-full max-w-md relative z-10 shadow-2xl p-4 sm:p-6 animate-in max-h-[90vh] overflow-y-auto">
            <form id="seriesForm" class="space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-lg">New Entry</h3>
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1 rounded" aria-label="Close modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <input type="text" id="formTitle" required placeholder="Series Title" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-200 text-sm" aria-label="Series title">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <select id="formStatus" class="px-4 py-3 border rounded-lg bg-white border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm" aria-label="Status">
                            <option>Watching</option>
                            <option>Completed</option>
                            <option>Planned</option>
                            <option>Dropped</option>
                        </select>
                        <input type="number" id="formRating" min="0" max="10" step="0.1" placeholder="Rating / 10" class="px-4 py-3 border rounded-lg border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm" aria-label="Rating out of 10">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <span class="absolute right-3 top-3 text-[10px] text-slate-400 font-bold pointer-events-none">EP</span>
                            <input type="number" id="formProgress" placeholder="Watched" class="w-full px-4 py-3 pr-8 border rounded-lg border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm" aria-label="Episodes watched">
                        </div>
                        <div class="relative">
                            <span class="absolute right-3 top-3 text-[10px] text-slate-400 font-bold pointer-events-none">TOTAL</span>
                            <input type="number" id="formTotal" placeholder="Total" class="w-full px-4 py-3 pr-12 border rounded-lg border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm" aria-label="Total episodes">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100 mt-4 disabled:opacity-50 disabled:cursor-not-allowed">Add to Library</button>
            </form>
        </div>
    </div>

    <div id="settingsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="this.parentElement.classList.add('hidden')"></div>
        <div class="bg-white rounded-2xl w-full max-w-md relative z-10 shadow-2xl p-6 animate-in">
            <h3 class="font-bold text-lg mb-4">Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Gemini API Key</label>
                    <input type="password" id="apiKeyInput" placeholder="Enter key..." class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-200">
                    <p class="text-[10px] text-slate-400 mt-1 italic">Key is stored securely in your private cloud profile.</p>
                </div>
                <button id="saveSettingsBtn" class="w-full bg-slate-800 text-white font-bold py-2 rounded-lg hover:bg-slate-900 transition-colors">Save Configuration</button>
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, collection, addDoc, onSnapshot, doc, updateDoc, deleteDoc, setDoc } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        let db, auth, user, currentAppId;
        let geminiKey = "";
        let currentSeries = [];
        let isCloudMode = false;

        const banner = document.getElementById('connectionBanner');

        const init = async () => {
            const loadingText = document.getElementById('loadingText');
            let attempts = 0;

            const checkEnvironment = () => {
                const hasConfig = typeof __firebase_config !== 'undefined' && __firebase_config;
                if (hasConfig) {
                    setupFirebase();
                } else if (attempts < 10) {
                    attempts++;
                    setTimeout(checkEnvironment, 1000);
                } else {
                    setupOfflineMode();
                }
            };
            checkEnvironment();
        };

        const setupFirebase = async () => {
            try {
                const firebaseConfig = JSON.parse(__firebase_config);
                currentAppId = typeof __app_id !== 'undefined' ? __app_id : 'series-tracker-v1';
                const app = initializeApp(firebaseConfig);
                auth = getAuth(app);
                db = getFirestore(app);

                onAuthStateChanged(auth, (u) => {
                    if (u) {
                        user = u;
                        isCloudMode = true;
                        banner.classList.add('hidden');
                        startDataListeners();
                    } else {
                        banner.classList.remove('hidden');
                    }
                });

                if (typeof __initial_auth_token !== 'undefined' && __initial_auth_token) {
                    await signInWithCustomToken(auth, __initial_auth_token).catch(() => signInAnonymously(auth));
                } else {
                    await signInAnonymously(auth);
                }
            } catch (e) {
                console.error("Firebase Initialization Failed:", e);
                setupOfflineMode();
            }
        };

        const setupOfflineMode = () => {
            isCloudMode = false;
            document.getElementById('aiStatus').innerText = "Add API Key to unlock recommendations.";
            const localData = localStorage.getItem('series_v2_backup');
            currentSeries = localData ? JSON.parse(localData) : [];
            renderList(currentSeries);
        };

        const startDataListeners = () => {
            if (!user || !db) return;
            const seriesRef = collection(db, 'artifacts', currentAppId, 'public', 'data', 'series_' + user.uid);
            onSnapshot(seriesRef, (snapshot) => {
                currentSeries = snapshot.docs.map(d => ({ id: d.id, ...d.data() }));
                localStorage.setItem('series_v2_backup', JSON.stringify(currentSeries));
                renderList(currentSeries);
            }, (err) => {
                if (err.code === 'permission-denied') setupOfflineMode();
            });

            const settingsRef = doc(db, 'artifacts', currentAppId, 'public', 'data', 'profiles', user.uid);
            onSnapshot(settingsRef, (snap) => {
                if (snap.exists()) geminiKey = snap.data().apiKey || "";
                document.getElementById('aiStatus').innerText = geminiKey ? "AI ready for suggestions." : "Add API Key to unlock recommendations.";
            });
        };

        const renderList = (list) => {
            const container = document.getElementById('listGrid');
            document.getElementById('statCount').textContent = list.length;
            
            if (list.length === 0) {
                container.innerHTML = `<div class="py-20 text-center text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">Your library is empty. Click 'Add Series' to start.</div>`;
                return;
            }

            // Sort by most recently updated
            const sortedList = [...list].sort((a, b) => (b.updatedAt || 0) - (a.updatedAt || 0));

            container.innerHTML = sortedList.map(item => {
                const isOver = item.total > 0 && item.progress >= item.total;
                const progressColor = isOver ? 'text-green-600' : 'text-indigo-600';
                
                return `
                <div class="bg-white p-3 sm:p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 shadow-sm hover:border-indigo-100 hover:shadow-md transition-all animate-in">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 truncate text-sm sm:text-base" title="${item.title}">${item.title}</h4>
                        <div class="flex gap-2 sm:gap-3 items-center mt-1 text-xs text-slate-400 flex-wrap">
                            <span class="px-2 py-0.5 ${isOver ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'} rounded uppercase font-bold text-[9px] tracking-tight whitespace-nowrap">
                                ${isOver ? 'Completed' : item.status}
                            </span>
                            <span class="flex items-center gap-1 whitespace-nowrap">
                                <i class="fas fa-star text-yellow-400"></i> 
                                <span class="font-semibold text-slate-600">${item.rating || '—'}</span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4 flex-shrink-0">
                        <div class="text-left sm:text-right">
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg sm:text-base font-black ${progressColor}">${item.progress || 0}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">/ ${item.total || '?'} ep</span>
                            </div>
                            ${item.total > 0 && item.progress < item.total ? `<div class="text-[9px] text-slate-400 font-medium">${item.total - item.progress} left</div>` : ''}
                        </div>
                        <div class="flex gap-1">
                            <button onclick="window.incrementValue('${item.id}', ${item.progress || 0}, ${item.total || 0})" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors active:scale-90" aria-label="Increment progress">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                            <button onclick="window.removeEntry('${item.id}')" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-slate-50 text-slate-300 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" aria-label="Remove series">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `}).join('');
        };

        window.incrementValue = async (id, cur, total) => {
            // Prevent 31/30 logic - only increment if below total or total is undefined
            if (total > 0 && cur >= total) return;
            
            const newVal = cur + 1;
            const newStatus = (total > 0 && newVal >= total) ? 'Completed' : 'Watching';

            if (isCloudMode && user && !id.startsWith('local_')) {
                await updateDoc(doc(db, 'artifacts', currentAppId, 'public', 'data', 'series_' + user.uid, id), { 
                    progress: newVal,
                    status: newStatus,
                    updatedAt: Date.now()
                });
            } else {
                const idx = currentSeries.findIndex(s => s.id === id);
                if (idx !== -1) {
                    currentSeries[idx].progress = newVal;
                    currentSeries[idx].status = newStatus;
                    currentSeries[idx].updatedAt = Date.now();
                }
                localStorage.setItem('series_v2_backup', JSON.stringify(currentSeries));
                renderList(currentSeries);
            }
        };

        window.removeEntry = async (id) => {
            if (isCloudMode && user && !id.startsWith('local_')) {
                await deleteDoc(doc(db, 'artifacts', currentAppId, 'public', 'data', 'series_' + user.uid, id));
            } else {
                currentSeries = currentSeries.filter(s => s.id !== id);
                localStorage.setItem('series_v2_backup', JSON.stringify(currentSeries));
                renderList(currentSeries);
            }
        };

        document.getElementById('addBtn').onclick = () => document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('settingsBtn').onclick = () => {
            document.getElementById('apiKeyInput').value = geminiKey;
            document.getElementById('settingsModal').classList.remove('hidden');
        };

        document.getElementById('saveSettingsBtn').onclick = async () => {
            const key = document.getElementById('apiKeyInput').value.trim();
            if (isCloudMode && user) {
                const profileRef = doc(db, 'artifacts', currentAppId, 'public', 'data', 'profiles', user.uid);
                await setDoc(profileRef, { apiKey: key }, { merge: true });
            } else {
                geminiKey = key;
            }
            document.getElementById('settingsModal').classList.add('hidden');
        };

        document.getElementById('seriesForm').onsubmit = async (e) => {
            e.preventDefault();
            const total = Number(document.getElementById('formTotal').value) || 0;
            const progress = Number(document.getElementById('formProgress').value) || 0;
            let status = document.getElementById('formStatus').value;

            // Simple validation: If progress matches total, force Completed status
            if (total > 0 && progress >= total) status = 'Completed';

            const data = {
                title: document.getElementById('formTitle').value,
                status: status,
                rating: Number(document.getElementById('formRating').value) || 0,
                progress: progress,
                total: total,
                updatedAt: Date.now()
            };

            if (isCloudMode && user) {
                await addDoc(collection(db, 'artifacts', currentAppId, 'public', 'data', 'series_' + user.uid), data);
            } else {
                data.id = "local_" + Date.now();
                currentSeries.push(data);
                localStorage.setItem('series_v2_backup', JSON.stringify(currentSeries));
                renderList(currentSeries);
            }
            document.getElementById('addModal').classList.add('hidden');
            e.target.reset();
        };

        document.getElementById('recBtn').onclick = async () => {
            if (!geminiKey) return alert("Please add your Gemini API key in settings.");
            if (currentSeries.length === 0) return alert("Add some series first to get recommendations.");
            
            const aiStatus = document.getElementById('aiStatus');
            const recBtn = document.getElementById('recBtn');
            const originalText = aiStatus.innerText;
            
            recBtn.disabled = true;
            aiStatus.innerText = "Consulting AI...";
            
            try {
                const userList = currentSeries.map(s => `${s.title} (${s.rating}/10)`).join(', ');
                const prompt = `Based on these shows I liked: ${userList}. Recommend ONE show I should watch next. Give ONLY the title.`;

                const res = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key=${geminiKey}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
                });
                const d = await res.json();
                const suggestion = d.candidates?.[0]?.content?.parts?.[0]?.text || "No suggestion found.";
                aiStatus.innerHTML = `Recommended: <span class="text-indigo-400 font-bold">${suggestion}</span>`;
            } catch (err) {
                aiStatus.innerText = "Connection failed. Try again.";
                setTimeout(() => aiStatus.innerText = originalText, 3000);
            } finally {
                recBtn.disabled = false;
            }
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

        init();
    </script>
</body>
</html>