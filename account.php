<?php
session_start();

// Handle OAuth status messages
$status_message = '';
$status_type = '';

if (isset($_GET['connected'])) {
    $status_message = ucfirst($_GET['connected']) . ' connected successfully!';
    $status_type = 'success';
} elseif (isset($_GET['disconnected'])) {
    $status_message = ucfirst($_GET['disconnected']) . ' disconnected successfully!';
    $status_type = 'success';
} elseif (isset($_GET['error'])) {
    $status_message = 'Connection failed. Please try again.';
    $status_type = 'error';
}

// Get connection status
$connections = $_SESSION['connections'] ?? [];
?>
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
                <a href="./" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Library</a>
                <a href="trivia" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Trivia</a>
                <a href="voice" class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">Voice</a>
                <a href="account" class="px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">Account</a>
            </div>
            <div class="flex items-center gap-2">
                <div class="md:hidden relative">
                    <button id="mobileMenuBtn" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors rounded-lg hover:bg-slate-50" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div id="mobileMenu" class="hidden absolute right-0 top-12 bg-white border border-slate-200 rounded-lg shadow-lg py-2 min-w-[120px]">
                        <a href="./" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Library</a>
                        <a href="trivia" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Trivia</a>
                        <a href="voice" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Voice</a>
                        <a href="account" class="block px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50">Account</a>
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
                    <h2 id="profileUsername" class="text-slate-800 font-bold text-lg mt-4">User</h2>

                </div>

                <nav class="flex flex-col text-sm font-medium">
                    <a href="#" onclick="showSection('profile')" class="bg-indigo-50 text-indigo-600 px-4 py-3 rounded-t-lg border-b border-slate-100" id="profileTab">Profile Settings</a>
                    <a href="#" onclick="showSection('avatar')" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 border-b border-slate-100 transition-colors" id="avatarTab">Avatar & Cover</a>
                    <a href="#" onclick="showSection('security')" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 border-b border-slate-100 transition-colors" id="securityTab">Security</a>
                    <a href="#" onclick="showSection('connections')" class="bg-white hover:bg-slate-50 text-slate-600 px-4 py-3 rounded-b-lg transition-colors" id="connectionsTab">Connections</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <section class="flex-1">
                <div class="flex justify-between items-center mb-8">
                    <h1 id="sectionTitle" class="text-slate-800 text-2xl font-bold">Profile Settings</h1>
                    <div id="statusMessage" class="text-green-600 text-sm font-medium hidden"></div>
                    <?php if ($status_message): ?>
                    <div class="<?php echo $status_type === 'success' ? 'text-green-600' : 'text-red-600'; ?> text-sm font-medium">
                        <?php echo htmlspecialchars($status_message); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Profile Settings Section -->
                <div id="profileSection" class="section-content">
                    <form onsubmit="handleSave(event)" class="space-y-6 bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Username</label>
                                <input 
                                    type="text" 
                                    id="usernameInput"
                                    class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                    value="User"
                                />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Email</label>
                                <input 
                                    type="email" 
                                    id="emailInput"
                                    class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                    value="user@example.com"
                                />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Bio</label>
                            <textarea 
                                id="bioInput"
                                class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm min-h-[120px] focus:ring-2 focus:ring-indigo-500 outline-none"
                            >TV and movie enthusiast. Always looking for the next great series to binge.</textarea>
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
                </div>

                <!-- Avatar & Cover Section -->
                <div id="avatarSection" class="section-content hidden">
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Profile Picture</h3>
                        <div class="flex items-center gap-6">
                            <img id="avatarPreview" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&h=200&fit=crop" class="w-20 h-20 rounded-full border-4 border-slate-200 object-cover" />
                            <div>
                                <button onclick="openAvatarModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Change Avatar</button>
                                <p class="text-xs text-slate-500 mt-2">Click to select from available avatars</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div id="securitySection" class="section-content hidden">
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Password & Security</h3>
                        <form onsubmit="handlePasswordChange(event)" class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Current Password</label>
                                <input type="password" id="currentPassword" class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Enter current password" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-600">New Password</label>
                                <input type="password" id="newPassword" class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Enter new password" required minlength="6" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="w-full p-3 rounded-lg border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Confirm new password" required />
                            </div>
                            <div id="passwordMessage" class="text-sm font-medium hidden"></div>
                            <div class="pt-4">
                                <button type="submit" id="passwordBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-8 py-3 rounded-lg transition-all disabled:opacity-50">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Connections Section -->
                <div id="connectionsSection" class="section-content hidden">
                    <div class="bg-white border border-slate-200 p-6 sm:p-8 rounded-2xl shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Connected Services</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-google text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">Google Account</p>
                                        <p class="text-xs text-slate-500">Sync your watchlist across devices</p>
                                    </div>
                                </div>
                                <?php if (isset($connections['google'])): ?>
                                <a href="oauth.php?provider=google&action=disconnect" class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">Connected</a>
                                <?php else: ?>
                                <a href="oauth.php?provider=google&action=connect" class="text-slate-400 hover:text-indigo-600 text-sm font-medium transition-colors">Connect</a>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-github text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">GitHub</p>
                                        <p class="text-xs text-slate-500">Connect your developer profile</p>
                                    </div>
                                </div>
                                <?php if (isset($connections['github'])): ?>
                                <a href="oauth.php?provider=github&action=disconnect" class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">Connected</a>
                                <?php else: ?>
                                <a href="oauth.php?provider=github&action=connect" class="text-slate-400 hover:text-indigo-600 text-sm font-medium transition-colors">Connect</a>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-spotify text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">Spotify</p>
                                        <p class="text-xs text-slate-500">Discover soundtracks from your shows</p>
                                    </div>
                                </div>
                                <?php if (isset($connections['spotify'])): ?>
                                <a href="oauth.php?provider=spotify&action=disconnect" class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">Connected</a>
                                <?php else: ?>
                                <a href="oauth.php?provider=spotify&action=connect" class="text-slate-400 hover:text-indigo-600 text-sm font-medium transition-colors">Connect</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
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

        function openAvatarModal() {
            document.getElementById('avatarModal').classList.remove('hidden');
        }

        function closeAvatarModal() {
            document.getElementById('avatarModal').classList.add('hidden');
        }

        function handleSave(e) {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            const status = document.getElementById('statusMessage');
            
            // Get form values
            const username = document.getElementById('usernameInput').value;
            const email = document.getElementById('emailInput').value;
            const bio = document.getElementById('bioInput').value;
            const avatar = document.getElementById('profileAvatar').src;
            
            // Save to localStorage
            const profileData = { username, email, bio, avatar };
            localStorage.setItem('userProfile', JSON.stringify(profileData));
            
            btn.disabled = true;
            btn.textContent = 'Saving...';
            
            // Simulate save
            setTimeout(() => {
                btn.disabled = false;
                btn.textContent = 'Save Changes';
                status.textContent = 'Profile updated successfully!';
                status.classList.remove('hidden');
                
                // Update display
                document.getElementById('profileUsername').textContent = username;
                
                setTimeout(() => status.classList.add('hidden'), 3000);
            }, 800);
        }

        function selectAvatar(src) {
            document.getElementById('profileAvatar').src = src;
            document.getElementById('avatarPreview').src = src;
            closeAvatarModal();
        }
        
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.section-content').forEach(s => s.classList.add('hidden'));
            
            // Remove active state from all tabs
            document.querySelectorAll('nav a').forEach(tab => {
                tab.classList.remove('bg-indigo-50', 'text-indigo-600');
                tab.classList.add('bg-white', 'text-slate-600');
            });
            
            // Show selected section and activate tab
            const sections = {
                'profile': { element: 'profileSection', title: 'Profile Settings', tab: 'profileTab' },
                'avatar': { element: 'avatarSection', title: 'Avatar & Cover', tab: 'avatarTab' },
                'security': { element: 'securitySection', title: 'Password & Security', tab: 'securityTab' },
                'connections': { element: 'connectionsSection', title: 'Connected Services', tab: 'connectionsTab' }
            };
            
            const current = sections[section];
            if (current) {
                document.getElementById(current.element).classList.remove('hidden');
                document.getElementById('sectionTitle').textContent = current.title;
                const activeTab = document.getElementById(current.tab);
                activeTab.classList.remove('bg-white', 'text-slate-600');
                activeTab.classList.add('bg-indigo-50', 'text-indigo-600');
            }
        }
        
        function handlePasswordChange(e) {
            e.preventDefault();
            const current = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            const btn = document.getElementById('passwordBtn');
            const msg = document.getElementById('passwordMessage');
            
            if (newPass !== confirm) {
                msg.textContent = 'Passwords do not match';
                msg.className = 'text-red-600 text-sm font-medium';
                msg.classList.remove('hidden');
                return;
            }
            
            if (newPass.length < 6) {
                msg.textContent = 'Password must be at least 6 characters';
                msg.className = 'text-red-600 text-sm font-medium';
                msg.classList.remove('hidden');
                return;
            }
            
            btn.disabled = true;
            btn.textContent = 'Updating...';
            
            // Simulate password change
            setTimeout(() => {
                localStorage.setItem('userPassword', newPass);
                msg.textContent = 'Password updated successfully!';
                msg.className = 'text-green-600 text-sm font-medium';
                msg.classList.remove('hidden');
                btn.disabled = false;
                btn.textContent = 'Update Password';
                e.target.reset();
                setTimeout(() => msg.classList.add('hidden'), 3000);
            }, 1000);
        }
        
        // Auto-hide status messages after 5 seconds
        <?php if ($status_message): ?>
        setTimeout(() => {
            const statusEl = document.querySelector('.text-green-600, .text-red-600');
            if (statusEl && statusEl.textContent.includes('<?php echo addslashes($status_message); ?>')) {
                statusEl.style.opacity = '0';
                setTimeout(() => statusEl.remove(), 300);
            }
        }, 5000);
        <?php endif; ?>
        
        // Load saved profile data on page load
        window.addEventListener('load', () => {
            const saved = localStorage.getItem('userProfile');
            if (saved) {
                const profile = JSON.parse(saved);
                document.getElementById('usernameInput').value = profile.username || 'User';
                document.getElementById('emailInput').value = profile.email || 'user@example.com';
                document.getElementById('bioInput').value = profile.bio || 'TV and movie enthusiast. Always looking for the next great series to binge.';
                document.getElementById('profileAvatar').src = profile.avatar || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&h=200&fit=crop';
                document.getElementById('profileUsername').textContent = profile.username || 'User';
            }
        });
    </script>
</body>
</html>