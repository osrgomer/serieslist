<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Account Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">L</div>
                <span class="font-bold text-xl tracking-tight hidden sm:block">Series<span class="text-indigo-600">List</span></span>
                <span class="font-bold text-lg tracking-tight sm:hidden">SL</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Library</a>
                <a href="trivia.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Trivia</a>
                <a href="tts/index.php" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Voice</a>
                <a href="account.php" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Account</a>
            </div>
            <div class="flex items-center gap-2">
                <div class="md:hidden relative">
                    <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
                        <a href="index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Library</a>
                        <a href="trivia.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Trivia</a>
                        <a href="tts/index.php" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Voice</a>
                        <a href="account.php" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Account</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 pt-8 pb-20">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 text-center shadow-sm">
                    <div class="relative inline-block group cursor-pointer" onclick="openAvatarModal()">
                        <img id="profileAvatar" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&h=200&fit=crop" class="w-24 h-24 rounded-full border-4 border-slate-200 group-hover:border-indigo-300 transition-all object-cover" />
                        <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-camera text-white"></i>
                        </div>
                    </div>
                    <h2 id="profileUsername" class="text-slate-800 font-bold text-lg mt-4">SeriesFan99</h2>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-1">Pro Member</p>
                </div>

                <nav class="flex flex-col text-sm font-medium">
                    <a href="#" class="bg-indigo-50 text-indigo-600 px-4 py-3 rounded-t-lg border-b border-slate-100">Profile Settings</a>
                    <a href="#" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 border-b border-slate-100 transition-colors">Avatar & Cover</a>
                    <a href="#" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 border-b border-slate-100 transition-colors">Security</a>
                    <a href="#" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 rounded-b-lg transition-colors">Connections</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <section class="flex-1">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-slate-800 text-2xl font-bold">Account Settings</h1>
                    <div id="statusMessage" class="text-green-600 text-sm font-medium hidden"></div>
                </div>

                <form onsubmit="handleSave(event)" class="space-y-6 bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Username</label>
                            <input 
                                type="text" 
                                id="usernameInput"
                                class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                value="SeriesFan99"
                            />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Email</label>
                            <input 
                                type="email" 
                                id="emailInput"
                                class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                value="fan@example.com"
                            />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Bio</label>
                        <textarea 
                            id="bioInput"
                            class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm min-h-[120px] focus:ring-2 focus:ring-indigo-500 outline-none"
                        >Obsessed with prestige drama and sci-fi series. Always looking for the next binge.</textarea>
                        <p class="text-xs text-slate-500">Markdown is supported for formatting your biography.</p>
                    </div>

                    <div class="pt-6 border-t border-slate-200 flex justify-end">
                        <button 
                            type="submit"
                            id="saveBtn"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-8 py-3 rounded-lg transition-all disabled:opacity-50"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div id="avatarModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white border border-slate-200 p-6 rounded-2xl max-w-md w-full">
            <div class="flex justify-between mb-6">
                <h3 class="text-slate-800 font-bold">Select Avatar</h3>
                <button onclick="closeAvatarModal()" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <img src="https://i.pravatar.cc/150?img=11" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=12" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=13" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=14" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=15" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=16" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=17" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
                <img src="https://i.pravatar.cc/150?img=18" class="rounded-full cursor-pointer hover:ring-2 ring-indigo-500 transition-all" onclick="selectAvatar(this.src)" />
            </div>
        </div>
    </div>

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

        function handleSave(e) {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            const status = document.getElementById('statusMessage');
            
            btn.disabled = true;
            btn.textContent = 'Saving...';
            
            // Simulate save
            setTimeout(() => {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
                status.textContent = 'Profile updated successfully!';
                status.classList.remove('hidden');
                setTimeout(() => status.classList.add('hidden'), 3000);
            }, 800);
        }

        function openAvatarModal() {
            document.getElementById('avatarModal').classList.remove('hidden');
        }

        function closeAvatarModal() {
            document.getElementById('avatarModal').classList.add('hidden');
        }

        function selectAvatar(src) {
            document.getElementById('profileAvatar').src = src;
            closeAvatarModal();
        }
    </script>
</body>
</html>