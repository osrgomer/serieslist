<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Track & Play</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide-react/0.263.0/lucide-react.min.js"></script>
    <style>
        :root {
            --bg-dark: #14181c;
            --bg-card: #1b2228;
            --accent: #00e054;
            --text-main: #9ab;
            --text-bright: #fff;
        }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }
        .nav-link {
            transition: color 0.2s ease;
        }
        .nav-link:hover {
            color: var(--text-bright);
        }
        .btn-primary {
            background-color: var(--accent);
            color: #000;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.25rem;
            transition: transform 0.1s ease;
        }
        .btn-primary:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <div id="app"></div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, onAuthStateChanged, signInAnonymously, signInWithCustomToken, signOut } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, getDoc, setDoc, collection, onSnapshot } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // Global variables provided by environment
        const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : { apiKey: "mock" };
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'serieslist-app';
        
        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getFirestore(app);

        // State Management
        let state = {
            user: null,
            currentPage: 'home', // 'home', 'profile', 'trivia'
            series: [],
            loading: true
        };

        // Navigation Helper
        function navigate(page) {
            state.currentPage = page;
            render();
        }

        // Auth Logic
        const initAuth = async () => {
            if (typeof __initial_auth_token !== 'undefined' && __initial_auth_token) {
                await signInWithCustomToken(auth, __initial_auth_token);
            } else {
                await signInAnonymously(auth);
            }
        };

        onAuthStateChanged(auth, (user) => {
            state.user = user;
            state.loading = false;
            if (user) {
                setupDataListener(user.uid);
            }
            render();
        });

        function setupDataListener(uid) {
            const userDocRef = doc(db, 'artifacts', appId, 'users', uid, 'profile', 'data');
            onSnapshot(userDocRef, (doc) => {
                if (doc.exists()) {
                    state.series = doc.data().series || [];
                    render();
                }
            }, (error) => console.error("Firestore error:", error));
        }

        // Components
        function Header() {
            return `
                <header class="bg-[#1b2228] border-b border-[#2c3440] py-4 px-6 mb-8">
                    <div class="max-w-6xl mx-auto flex justify-between items-center">
                        <div class="flex items-center gap-8">
                            <h1 onclick="window.navigate('home')" class="text-white text-2xl font-black tracking-tighter cursor-pointer flex items-center gap-2">
                                <span class="bg-[#00e054] text-black px-1 rounded">S</span> SeriesList
                            </h1>
                            <nav class="hidden md:flex gap-6 uppercase text-xs font-bold tracking-widest pt-1">
                                <a href="#" onclick="window.navigate('home')" class="nav-link ${state.currentPage === 'home' ? 'text-white' : ''}">Home</a>
                                <a href="#" onclick="window.navigate('trivia')" class="nav-link ${state.currentPage === 'trivia' ? 'text-white' : ''}">Trivia</a>
                            </nav>
                        </div>
                        <div class="flex items-center gap-4">
                            ${state.user ? `
                                ${state.currentPage !== 'profile' ? `
                                    <button onclick="window.navigate('profile')" class="text-xs uppercase font-bold tracking-widest nav-link">Profile</button>
                                ` : ''}
                                <button onclick="window.handleLogout()" class="text-xs uppercase font-bold tracking-widest nav-link opacity-60">Logout</button>
                            ` : `
                                <button class="btn-primary text-xs uppercase">Sign In</button>
                            `}
                        </div>
                    </div>
                </header>
            `;
        }

        function HomePage() {
            return `
                <main class="max-w-6xl mx-auto px-6 pb-20">
                    <section class="mb-12">
                        <h2 class="text-4xl text-white font-serif mb-4">Track series you've watched.</h2>
                        <h2 class="text-4xl text-white font-serif mb-8">Save those you want to see.</h2>
                        <div class="bg-gradient-to-r from-[#2c3440] to-transparent p-8 rounded-lg border border-[#343d4c]">
                            <p class="text-lg mb-6">Welcome back. Start your next obsession or test your knowledge.</p>
                            <button onclick="window.navigate('trivia')" class="btn-primary">Play Series Trivia</button>
                        </div>
                    </section>

                    <section>
                        <h3 class="uppercase text-xs font-bold tracking-widest border-b border-[#2c3440] pb-2 mb-6">Popular this week</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            ${[1, 2, 3, 4, 5].map(i => `
                                <div class="group cursor-pointer">
                                    <div class="aspect-[2/3] bg-[#2c3440] rounded border-2 border-transparent group-hover:border-[#00e054] transition-all overflow-hidden relative">
                                        <div class="absolute inset-0 flex items-center justify-center text-[#456]">Poster ${i}</div>
                                    </div>
                                    <p class="mt-2 text-sm text-white font-medium truncate">Example Series ${i}</p>
                                </div>
                            `).join('')}
                        </div>
                    </section>
                </main>
            `;
        }

        function ProfilePage() {
            return `
                <main class="max-w-4xl mx-auto px-6">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-24 h-24 bg-[#2c3440] rounded-full border-2 border-[#456]"></div>
                        <div>
                            <h2 class="text-3xl text-white font-bold">${state.user?.uid.substring(0, 8) || 'User'}</h2>
                            <p class="text-[#678]">Member since 2025</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="col-span-2">
                            <h3 class="uppercase text-xs font-bold tracking-widest border-b border-[#2c3440] pb-2 mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                ${state.series.length > 0 ? state.series.map(s => `
                                    <div class="bg-[#1b2228] p-4 rounded border border-[#2c3440] flex justify-between">
                                        <span class="text-white">${s.name}</span>
                                        <span class="text-[#00e054]">★★★★☆</span>
                                    </div>
                                `).join('') : `<p class="text-sm italic">No activity yet. Go watch something!</p>`}
                            </div>
                        </div>
                        <div>
                            <h3 class="uppercase text-xs font-bold tracking-widest border-b border-[#2c3440] pb-2 mb-4">Stats</h3>
                            <div class="bg-[#1b2228] p-4 rounded border border-[#2c3440] space-y-4">
                                <div><p class="text-2xl text-white font-bold">${state.series.length}</p><p class="text-[10px] uppercase font-bold">Series Watched</p></div>
                                <div><p class="text-2xl text-white font-bold">0</p><p class="text-[10px] uppercase font-bold">Reviews Written</p></div>
                            </div>
                        </div>
                    </div>
                </main>
            `;
        }

        function TriviaPage() {
            return `
                <main class="max-w-2xl mx-auto px-6 py-12">
                    <div class="bg-[#1b2228] border border-[#2c3440] rounded-xl p-10 text-center">
                        <span class="text-[#00e054] text-xs font-bold uppercase tracking-widest mb-4 block">Question 1 of 5</span>
                        <h2 class="text-2xl text-white font-bold mb-8">In "Breaking Bad", what is the primary color used in the logo for the element symbols?</h2>
                        <div class="grid gap-4">
                            ${['Blue', 'Green', 'Yellow', 'Red'].map(opt => `
                                <button class="w-full py-4 px-6 bg-[#2c3440] hover:bg-[#343d4c] text-white rounded font-medium transition-colors border border-transparent hover:border-[#00e054]">
                                    ${opt}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                </main>
            `;
        }

        function render() {
            const root = document.getElementById('app');
            if (state.loading) {
                root.innerHTML = `<div class="flex items-center justify-center min-h-screen"><p class="animate-pulse">Loading SeriesList...</p></div>`;
                return;
            }

            let pageContent = '';
            switch(state.currentPage) {
                case 'profile': pageContent = ProfilePage(); break;
                case 'trivia': pageContent = TriviaPage(); break;
                default: pageContent = HomePage();
            }

            root.innerHTML = `
                ${Header()}
                ${pageContent}
            `;
        }

        // Global Action Handlers
        window.navigate = navigate;
        window.handleLogout = async () => {
            await signOut(auth);
            navigate('home');
        };

        // Initialize
        initAuth();
        render();

    </script>
</body>
</html>