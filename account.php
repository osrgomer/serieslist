<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeriesList - Account Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- React and Babel for browser-side compilation -->
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #14181c; color: #9ab; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        .lb-input { background: #1b2228; border: 1px solid #2c3440; transition: all 0.2s; }
        .lb-input:focus { border-color: #00e054; outline: none; box-shadow: 0 0 0 1px #00e054; }
        .animate-spin-custom { animation: spin 1s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        // Firebase Mocking / Integration Logic
        // In a real environment, __firebase_config would be injected.
        // For the sake of this file working immediately, we handle the config.
        const firebaseConfig = window.__firebase_config ? JSON.parse(window.__firebase_config) : {
            apiKey: "mock-key",
            authDomain: "mock-domain",
            projectId: "mock-project",
        };

        const App = () => {
            const [loading, setLoading] = useState(false);
            const [status, setStatus] = useState({ type: '', message: '' });
            const [isModalOpen, setIsModalOpen] = useState(false);
            const [profile, setProfile] = useState({
                username: 'SeriesFan99',
                email: 'fan@example.com',
                bio: 'Obsessed with prestige drama and sci-fi series. Always looking for the next binge.',
                avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&h=200&fit=crop'
            });

            const handleSave = (e) => {
                e.preventDefault();
                setLoading(true);
                // Simulate Firestore Save
                setTimeout(() => {
                    setLoading(false);
                    setStatus({ type: 'success', message: 'Profile updated successfully!' });
                    setTimeout(() => setStatus({ type: '', message: '' }), 3000);
                }, 800);
            };

            return (
                <div className="min-h-screen pb-20">
                    {/* Header */}
                    <nav className="bg-[#14181c] border-b border-[#2c3440] h-16 flex items-center sticky top-0 z-50">
                        <div className="max-w-5xl mx-auto w-full px-4 flex justify-between items-center">
                            <div className="flex items-center gap-8">
                                <h1 className="text-white font-black text-2xl tracking-tighter">SERIESLIST</h1>
                                <div className="hidden md:flex gap-6 text-[11px] font-bold uppercase tracking-widest">
                                    <a href="#" className="hover:text-white">Profile</a>
                                    <a href="#" className="hover:text-white">Activity</a>
                                    <a href="#" className="text-white border-b-2 border-[#00e054] pb-1">Settings</a>
                                </div>
                            </div>
                            <div className="flex items-center gap-4">
                                <img src={profile.avatar} className="w-8 h-8 rounded-full border border-[#2c3440]" />
                            </div>
                        </div>
                    </nav>

                    <div className="max-w-5xl mx-auto px-4 pt-12">
                        <div className="flex flex-col lg:flex-row gap-12">
                            
                            {/* Left Col */}
                            <aside className="w-full lg:w-64 space-y-6">
                                <div className="bg-[#1b2228] border border-[#2c3440] rounded-lg p-6 text-center">
                                    <div className="relative inline-block group cursor-pointer" onClick={() => setIsModalOpen(true)}>
                                        <img src={profile.avatar} className="w-24 h-24 rounded-full border-4 border-[#2c3440] group-hover:border-[#00e054] transition-all object-cover" />
                                        <div className="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i data-lucide="camera" className="text-white w-6 h-6"></i>
                                        </div>
                                    </div>
                                    <h2 className="text-white font-bold text-lg mt-4">{profile.username}</h2>
                                    <p className="text-[10px] text-[#678] font-bold uppercase tracking-widest mt-1">PRO MEMBER</p>
                                </div>

                                <nav className="flex flex-col text-xs font-bold uppercase tracking-widest">
                                    <a href="#" className="bg-[#2c3440] text-white px-4 py-3 rounded-t-lg border-b border-[#14181c]">Profile Settings</a>
                                    <a href="#" className="bg-[#1b2228] hover:bg-[#232a31] px-4 py-3 border-b border-[#14181c]">Avatar & Cover</a>
                                    <a href="#" className="bg-[#1b2228] hover:bg-[#232a31] px-4 py-3 border-b border-[#14181c]">Security</a>
                                    <a href="#" className="bg-[#1b2228] hover:bg-[#232a31] px-4 py-3 rounded-b-lg">Connections</a>
                                </nav>
                            </aside>

                            {/* Main Col */}
                            <section className="flex-1">
                                <div className="flex justify-between items-center mb-8">
                                    <h1 className="text-white text-2xl font-serif italic">Settings</h1>
                                    {status.message && (
                                        <div className="text-[#00e054] text-xs font-bold animate-pulse">
                                            {status.message}
                                        </div>
                                    )}
                                </div>

                                <form onSubmit={handleSave} className="space-y-8 bg-[#1b2228] border border-[#2c3440] p-8 rounded-lg shadow-xl">
                                    <div className="grid md:grid-cols-2 gap-6">
                                        <div className="space-y-2">
                                            <label className="text-[10px] font-bold uppercase tracking-widest text-[#678]">Username</label>
                                            <input 
                                                type="text" 
                                                className="lb-input w-full p-3 rounded text-white text-sm"
                                                value={profile.username}
                                                onChange={e => setProfile({...profile, username: e.target.value})}
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <label className="text-[10px] font-bold uppercase tracking-widest text-[#678]">Email</label>
                                            <input 
                                                type="email" 
                                                className="lb-input w-full p-3 rounded text-white text-sm"
                                                value={profile.email}
                                                onChange={e => setProfile({...profile, email: e.target.value})}
                                            />
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <label className="text-[10px] font-bold uppercase tracking-widest text-[#678]">Bio</label>
                                        <textarea 
                                            className="lb-input w-full p-3 rounded text-white text-sm min-h-[120px]"
                                            value={profile.bio}
                                            onChange={e => setProfile({...profile, bio: e.target.value})}
                                        ></textarea>
                                        <p className="text-[10px] text-[#456]">Markdown is supported for formatting your biography.</p>
                                    </div>

                                    <div className="pt-6 border-t border-[#2c3440] flex justify-end">
                                        <button 
                                            disabled={loading}
                                            className="bg-[#00e054] hover:bg-[#00c54a] text-[#14181c] font-black uppercase text-[11px] tracking-widest px-8 py-3 rounded transition-all disabled:opacity-50"
                                        >
                                            {loading ? 'Saving...' : 'Save Changes'}
                                        </button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    {/* Modal Overlay */}
                    {isModalOpen && (
                        <div className="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-[100]">
                            <div className="bg-[#1b2228] border border-[#2c3440] p-8 rounded-xl max-w-md w-full">
                                <div className="flex justify-between mb-6">
                                    <h3 className="text-white font-bold">Select Avatar</h3>
                                    <button onClick={() => setIsModalOpen(false)} className="text-[#678] hover:text-white">✕</button>
                                </div>
                                <div className="grid grid-cols-4 gap-4">
                                    {[1, 2, 3, 4, 5, 6, 7, 8].map(i => (
                                        <img 
                                            key={i}
                                            src={`https://i.pravatar.cc/150?img=${i+10}`} 
                                            className="rounded-full cursor-pointer hover:ring-2 ring-[#00e054] transition-all"
                                            onClick={() => {
                                                setProfile({...profile, avatar: `https://i.pravatar.cc/150?img=${i+10}`});
                                                setIsModalOpen(false);
                                            }}
                                        />
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            );
        };

        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);

        // Initialize icons
        setTimeout(() => lucide.createIcons(), 100);
    </script>
</body>
</html>