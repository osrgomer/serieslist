import React, { useState, useMemo, useEffect } from 'react';
import { 
  Tv, 
  Star, 
  Clock, 
  Search, 
  User, 
  CheckCircle2, 
  TrendingUp, 
  Plus,
  LayoutGrid,
  Flame,
  Bell,
  Filter,
  BarChart3,
  Heart,
  MessageSquare
} from 'lucide-react';

const INITIAL_SHOWS = [
  { id: 1, title: "Succession", year: "2018", seasons: 4, episodesPerSeason: 10, poster: "https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1594908900066-3f47337549d8?w=1200&h=400&fit=crop", rating: 4.9, genre: "Drama", status: "Ended" },
  { id: 2, title: "The Bear", year: "2022", seasons: 3, episodesPerSeason: 8, poster: "https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&h=400&fit=crop", rating: 4.8, genre: "Comedy/Drama", status: "Returning" },
  { id: 3, title: "Severance", year: "2022", seasons: 1, episodesPerSeason: 9, poster: "https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=1200&h=400&fit=crop", rating: 4.7, genre: "Sci-Fi", status: "Returning" },
  { id: 4, title: "The White Lotus", year: "2021", seasons: 2, episodesPerSeason: 7, poster: "https://images.unsplash.com/photo-1544161515-4ad6ce6ec896?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&h=400&fit=crop", rating: 4.5, genre: "Satire", status: "Returning" },
  { id: 5, title: "Andor", year: "2022", seasons: 1, episodesPerSeason: 12, poster: "https://images.unsplash.com/photo-1534447677768-be436bb09401?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?w=1200&h=400&fit=crop", rating: 4.6, genre: "Sci-Fi", status: "Returning" },
];

export default function App() {
  const [view, setView] = useState('home');
  const [selectedShow, setSelectedShow] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  
  // This useEffect injects the "Canvas Look" directly into your local browser's head
  useEffect(() => {
    const style = document.createElement('style');
    style.textContent = `
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
      
      :root {
        --brand-green: #00e054;
        --bg-dark: #14181c;
        --panel-dark: #1b2228;
        --border-dark: #2c3440;
        --text-muted: #9ab;
      }

      body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        background-color: var(--bg-dark);
        color: var(--text-muted);
        margin: 0;
        -webkit-font-smoothing: antialiased;
      }

      .glass {
        background: rgba(20, 24, 28, 0.8) !important;
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
      }

      .premium-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }

      .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
      }

      .mask-gradient {
        mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
      }
      
      /* Fix for potential Tailwind conflicts in some browsers */
      h1, h2, h3 { font-style: italic; text-transform: uppercase; }
    `;
    document.head.appendChild(style);
    return () => document.head.removeChild(style);
  }, []);

  const [watchedData] = useState({
    watchlist: [3, 5],
    completed: [1],
    favorites: [1, 2, 3, 4],
    logs: [
      { id: 101, showId: 1, user: "Alex", date: "2h ago", rating: 5, comment: "One of the best finales ever." },
      { id: 102, showId: 2, user: "Jordan", date: "5h ago", rating: 4, comment: "Intensity level is through the roof!" }
    ]
  });

  const filteredShows = useMemo(() => {
    return INITIAL_SHOWS.filter(s => s.title.toLowerCase().includes(searchQuery.toLowerCase()));
  }, [searchQuery]);

  const handleShowClick = (show) => {
    setSelectedShow(show);
    setView('show-detail');
    window.scrollTo(0, 0);
  };

  const NavItem = ({ icon: Icon, label, active, onClick }) => (
    <button 
      onClick={onClick}
      className={`flex items-center gap-3 px-4 py-3 w-full rounded-xl transition-all duration-300 group ${
        active ? 'bg-[#00e054] text-[#14181c] shadow-[0_0_25px_rgba(0,224,84,0.3)]' : 'text-[#9ab] hover:bg-[#2c3440] hover:text-white'
      }`}
    >
      <Icon size={18} className={active ? '' : 'group-hover:scale-110 transition-transform'} />
      <span className="font-bold text-sm tracking-tight">{label}</span>
    </button>
  );

  return (
    <div className="min-h-screen bg-[#14181c] text-[#9ab] flex selection:bg-[#00e054] selection:text-[#14181c]">
      
      {/* SIDEBAR */}
      <aside className="w-64 border-r border-[#2c3440] p-6 hidden lg:flex flex-col gap-8 fixed h-full bg-[#14181c] z-50">
        <div className="flex items-center gap-2 mb-4 px-2 cursor-pointer" onClick={() => setView('home')}>
          <div className="bg-[#00e054] p-1.5 rounded-lg shadow-[0_0_15px_rgba(0,224,84,0.3)]">
            <Tv size={24} className="text-[#14181c]" />
          </div>
          <span className="text-2xl font-black text-white italic tracking-tighter uppercase leading-none">SeriesList</span>
        </div>

        <nav className="space-y-1">
          <p className="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#678] mb-2">Discovery</p>
          <NavItem icon={LayoutGrid} label="Browse" active={view === 'home'} onClick={() => setView('home')} />
          <NavItem icon={TrendingUp} label="Popular" />
          <NavItem icon={Flame} label="Newest" />
        </nav>

        <nav className="space-y-1">
          <p className="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#678] mb-2">My Library</p>
          <NavItem icon={Clock} label="Watchlist" />
          <NavItem icon={CheckCircle2} label="History" />
          <NavItem icon={Heart} label="Favorites" />
        </nav>

        <div className="mt-auto pt-6 border-t border-[#2c3440]">
          <NavItem icon={User} label="My Profile" active={view === 'profile'} onClick={() => setView('profile')} />
        </div>
      </aside>

      {/* CONTENT */}
      <main className="flex-1 lg:ml-64 relative">
        <header className="h-20 px-8 flex items-center justify-between sticky top-0 z-40 bg-[#14181c]/80 glass border-b border-[#2c3440]/50">
          <div className="relative w-full max-w-md group">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-[#678] group-focus-within:text-[#00e054] transition-colors" size={18} />
            <input 
              type="text"
              placeholder="Search 10,000+ series..."
              className="w-full bg-[#1b2228] border border-[#2c3440] rounded-2xl py-2.5 pl-12 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-[#00e054]/20 transition-all text-sm"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
          </div>
          
          <div className="flex items-center gap-6">
            <button className="text-[#678] hover:text-white transition relative">
              <Bell size={20} />
              <span className="absolute -top-1 -right-1 w-2 h-2 bg-[#00e054] rounded-full shadow-[0_0_8px_#00e054]"></span>
            </button>
            <button className="bg-[#00e054] text-[#14181c] px-5 py-2 rounded-xl font-black uppercase text-[11px] tracking-wider flex items-center gap-2 hover:translate-y-[-1px] active:translate-y-[1px] hover:shadow-[0_8px_20px_rgba(0,224,84,0.3)] transition-all">
              <Plus size={16} strokeWidth={3} /> Log Entry
            </button>
          </div>
        </header>

        <div className="p-8">
          {view === 'home' && (
            <div className="space-y-12 animate-in fade-in duration-700">
              {!searchQuery && (
                <section className="relative h-[440px] rounded-[32px] overflow-hidden group cursor-pointer shadow-2xl">
                  <img src={INITIAL_SHOWS[0].backdrop} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[2000ms]" alt="Hero" />
                  <div className="absolute inset-0 bg-gradient-to-r from-[#14181c] via-[#14181c]/60 to-transparent" />
                  <div className="absolute bottom-12 left-12 max-w-2xl">
                    <div className="flex items-center gap-2 mb-4">
                      <span className="bg-[#00e054] text-[#14181c] text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-tighter">Editor's Choice</span>
                    </div>
                    <h1 className="text-7xl font-black text-white italic uppercase tracking-tighter mb-6 leading-[0.85]">
                      {INITIAL_SHOWS[0].title}
                    </h1>
                    <div className="flex items-center gap-4">
                       <button onClick={() => handleShowClick(INITIAL_SHOWS[0])} className="bg-white text-black px-10 py-4 rounded-xl font-black uppercase text-xs hover:bg-[#00e054] transition-all transform hover:scale-105 active:scale-95">
                        Start Tracking
                      </button>
                      <button className="bg-white/10 glass text-white border border-white/20 px-10 py-4 rounded-xl font-black uppercase text-xs hover:bg-white/20 transition-all">
                        Watchlist
                      </button>
                    </div>
                  </div>
                </section>
              )}

              <section>
                <div className="flex items-center justify-between mb-8 border-b border-[#2c3440] pb-4">
                  <h2 className="text-white text-2xl font-black tracking-tighter uppercase italic flex items-center gap-3">
                    <TrendingUp className="text-[#00e054]" /> Trending Now
                  </h2>
                  <button className="flex items-center gap-2 text-[#678] hover:text-white font-bold uppercase text-[10px] tracking-widest transition-colors">
                    View All <Filter size={14} />
                  </button>
                </div>
                
                <div className="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-8">
                  {filteredShows.map(show => (
                    <div key={show.id} onClick={() => handleShowClick(show)} className="group cursor-pointer premium-card">
                      <div className="aspect-[2/3] rounded-2xl overflow-hidden border-2 border-transparent group-hover:border-[#00e054] transition-all duration-300 shadow-xl bg-[#1b2228] relative">
                        <img src={show.poster} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt={show.title} />
                        <div className="absolute top-3 right-3 glass px-2 py-1 rounded-lg flex items-center gap-1 border border-white/10">
                          <Star size={10} className="fill-[#00e054] text-[#00e054]" />
                          <span className="text-[10px] font-bold text-white">{show.rating}</span>
                        </div>
                      </div>
                      <div className="mt-4">
                        <h3 className="text-white font-black text-sm uppercase italic truncate group-hover:text-[#00e054] transition-colors">{show.title}</h3>
                        <p className="text-[#678] text-[10px] font-bold uppercase tracking-widest mt-1">{show.genre} • {show.year}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </section>
            </div>
          )}

          {view === 'show-detail' && selectedShow && (
            <div className="max-w-6xl mx-auto animate-in fade-in slide-in-from-bottom-8 duration-700 pt-10">
               <button onClick={() => setView('home')} className="text-[#678] hover:text-white font-black uppercase tracking-[0.2em] text-[10px] mb-12 flex items-center gap-2 group transition-colors">
                 <span className="group-hover:-translate-x-1 transition-transform">←</span> Back to Discovery
               </button>
               
               <div className="flex flex-col xl:flex-row gap-16">
                  <div className="w-full xl:w-80 flex-shrink-0">
                    <div className="sticky top-32">
                      <img src={selectedShow.poster} className="w-full rounded-[40px] shadow-2xl border border-white/10" alt="Selected" />
                      <div className="mt-8 grid grid-cols-2 gap-4">
                        <button className="bg-[#00e054] text-[#14181c] py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-2 shadow-xl hover:shadow-[#00e054]/20 transition-all">
                          <CheckCircle2 size={16} strokeWidth={3} /> Log
                        </button>
                        <button className="bg-[#2c3440] text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-2 hover:bg-[#343d4b] transition-all">
                          <Plus size={16} strokeWidth={3} /> Add List
                        </button>
                      </div>
                    </div>
                  </div>

                  <div className="flex-1">
                     <div className="flex items-center gap-3 mb-6">
                        <span className="px-3 py-1 bg-[#2c3440] text-white text-[10px] font-black uppercase rounded-full tracking-wider border border-white/5">{selectedShow.year}</span>
                        <span className="px-3 py-1 bg-[#00e054]/10 text-[#00e054] text-[10px] font-black uppercase rounded-full border border-[#00e054]/20 tracking-wider">{selectedShow.status}</span>
                     </div>
                     <h1 className="text-8xl font-black text-white italic uppercase tracking-tighter mb-8 leading-[0.8]">{selectedShow.title}</h1>
                     
                     <div className="flex items-center gap-12 mb-12 py-10 border-y border-[#2c3440]">
                        <div>
                           <p className="text-[10px] font-black text-[#678] uppercase tracking-[0.2em] mb-1">Average Rating</p>
                           <div className="flex items-center gap-2 text-white">
                              <Star size={32} className="fill-[#00e054] text-[#00e054]" />
                              <span className="text-4xl font-black">{selectedShow.rating}</span>
                           </div>
                        </div>
                        <div className="w-[1px] h-12 bg-[#2c3440]" />
                        <div>
                           <p className="text-[10px] font-black text-[#678] uppercase tracking-[0.2em] mb-1">Duration</p>
                           <p className="text-4xl font-black text-white italic">{selectedShow.seasons} Seasons</p>
                        </div>
                     </div>

                     <p className="text-[#9ab] text-2xl leading-relaxed font-medium mb-16 opacity-80">
                        Experience the drama and suspense of {selectedShow.title}. A masterclass in television production, 
                        perfectly balancing high stakes with deep character development.
                     </p>

                     <h3 className="text-white font-black uppercase tracking-[0.3em] text-[11px] mb-8 flex items-center gap-3">
                        <BarChart3 size={18} className="text-[#00e054]" /> Personal Progress
                     </h3>
                     <div className="grid sm:grid-cols-2 gap-6">
                        {[...Array(selectedShow.seasons)].map((_, i) => (
                           <div key={i} className="bg-[#1b2228] border border-[#2c3440] p-8 rounded-[32px] hover:border-[#00e054]/40 transition-all group cursor-pointer hover:bg-[#1f282f]">
                              <div className="flex justify-between items-center mb-6">
                                 <span className="text-white text-xl font-black italic uppercase tracking-tighter">Season {i + 1}</span>
                                 <span className="text-[#678] text-[10px] font-black uppercase tracking-widest">{selectedShow.episodesPerSeason} Episodes</span>
                              </div>
                              <div className="w-full bg-[#14181c] h-2 rounded-full overflow-hidden">
                                 <div className={`h-full bg-[#00e054] shadow-[0_0_15px_#00e054] transition-all duration-1000 ${i === 0 ? 'w-full' : 'w-0'}`} />
                              </div>
                           </div>
                        ))}
                     </div>
                  </div>
               </div>
            </div>
          )}

          {view === 'profile' && (
            <div className="max-w-5xl mx-auto animate-in fade-in duration-700 pt-10">
               <header className="relative py-16 px-12 rounded-[50px] bg-gradient-to-br from-[#1b2228] to-[#14181c] border border-[#2c3440] overflow-hidden mb-16 shadow-2xl">
                  <div className="absolute top-0 right-0 w-64 h-64 bg-[#00e054]/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2" />
                  <div className="relative flex flex-col md:flex-row items-center gap-12">
                     <div className="w-48 h-48 rounded-full bg-gradient-to-br from-[#00e054] via-[#40bcf4] to-[#00e054] p-1.5 shadow-[0_20px_40px_rgba(0,0,0,0.5)]">
                        <div className="w-full h-full rounded-full bg-[#14181c] flex items-center justify-center">
                           <User size={80} className="text-[#2c3440]" />
                        </div>
                     </div>
                     <div className="text-center md:text-left">
                        <h1 className="text-6xl font-black text-white italic tracking-tighter uppercase mb-3">SeriesFan_01</h1>
                        <p className="text-[#00e054] font-black uppercase tracking-[0.3em] text-xs">Platinum Member • Joined Oct 2023</p>
                     </div>
                  </div>
               </header>

               <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
                  <div className="md:col-span-2 space-y-16">
                     <section>
                        <h2 className="text-white text-xs font-black uppercase tracking-[0.3em] mb-10 pb-2 border-b border-[#2c3440] flex items-center gap-2">
                           <Star size={16} className="text-[#00e054]" /> Hall of Fame
                        </h2>
                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-6">
                           {INITIAL_SHOWS.slice(0, 4).map(show => (
                              <div key={show.id} className="aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl border border-white/5 group cursor-pointer premium-card">
                                 <img src={show.poster} className="w-full h-full object-cover" alt="Fav" />
                              </div>
                           ))}
                        </div>
                     </section>
                  </div>

                  <section className="bg-[#1b2228] p-10 rounded-[40px] border border-[#2c3440] h-fit sticky top-32 shadow-xl">
                     <h3 className="text-white font-black uppercase tracking-[0.2em] text-[11px] mb-10 border-b border-[#2c3440] pb-4">Activity Stats</h3>
                     <div className="space-y-10">
                        <div className="group">
                           <p className="text-[#678] text-[10px] font-black uppercase mb-2 tracking-widest group-hover:text-[#00e054] transition-colors">Screen Time</p>
                           <p className="text-white text-3xl font-black italic tracking-tighter leading-none">12d 4h 32m</p>
                        </div>
                        <div>
                           <p className="text-[#678] text-[10px] font-black uppercase mb-2 tracking-widest">Global Rank</p>
                           <p className="text-white text-3xl font-black italic tracking-tighter leading-none">Top 2%</p>
                        </div>
                        <div>
                           <p className="text-[#678] text-[10px] font-black uppercase mb-2 tracking-widest">Favorite Genre</p>
                           <p className="text-[#00e054] text-3xl font-black italic tracking-tighter leading-none">SCIFI DRAMA</p>
                        </div>
                     </div>
                  </section>
               </div>
            </div>
          )}
        </div>
      </main>
    </div>
  );
}