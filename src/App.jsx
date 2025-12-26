import React, { useState, useMemo } from 'react';
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
      className={`flex items-center gap-3 px-4 py-3 w-full rounded-xl transition-all duration-200 group ${
        active ? 'bg-[#00e054] text-[#14181c]' : 'text-[#9ab] hover:bg-[#2c3440] hover:text-white'
      }`}
    >
      <Icon size={18} className={active ? '' : 'group-hover:scale-110 transition-transform'} />
      <span className="font-bold text-sm tracking-tight">{label}</span>
    </button>
  );

  return (
    <div className="min-h-screen bg-[#14181c] text-[#9ab] font-sans flex selection:bg-[#00e054] selection:text-[#14181c]">
      
      {/* LEFT SIDEBAR */}
      <aside className="w-64 border-r border-[#2c3440] p-6 hidden lg:flex flex-col gap-8 fixed h-full bg-[#14181c] z-50">
        <div className="flex items-center gap-2 mb-4 px-2 cursor-pointer" onClick={() => setView('home')}>
          <div className="bg-[#00e054] p-1.5 rounded-lg">
            <Tv size={24} className="text-[#14181c]" />
          </div>
          <span className="text-2xl font-black text-white italic tracking-tighter uppercase">SeriesList</span>
        </div>

        <div className="space-y-1">
          <p className="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#678] mb-2">Discovery</p>
          <NavItem icon={LayoutGrid} label="Browse" active={view === 'home'} onClick={() => setView('home')} />
          <NavItem icon={TrendingUp} label="Popular" />
          <NavItem icon={Flame} label="Newest" />
        </div>

        <div className="space-y-1">
          <p className="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#678] mb-2">My Library</p>
          <NavItem icon={Clock} label="Watchlist" />
          <NavItem icon={CheckCircle2} label="History" />
          <NavItem icon={Heart} label="Favorites" />
        </div>

        <div className="mt-auto pt-6 border-t border-[#2c3440]">
          <NavItem icon={User} label="My Profile" active={view === 'profile'} onClick={() => setView('profile')} />
        </div>
      </aside>

      {/* CONTENT AREA */}
      <main className="flex-1 lg:ml-64 relative">
        
        {/* HEADER BAR */}
        <header className="h-20 px-8 flex items-center justify-between sticky top-0 z-40 bg-[#14181c]/80 backdrop-blur-md border-b border-[#2c3440]/50">
          <div className="relative w-full max-w-md group">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-[#678] group-focus-within:text-[#00e054]" size={18} />
            <input 
              type="text"
              placeholder="Search 10,000+ series..."
              className="w-full bg-[#1b2228] border border-[#2c3440] rounded-2xl py-2.5 pl-12 pr-4 text-white focus:outline-none focus:ring-1 focus:ring-[#00e054] transition-all text-sm"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
          </div>
          
          <div className="flex items-center gap-6">
            <button className="text-[#678] hover:text-white transition relative">
              <Bell size={20} />
              <span className="absolute -top-1 -right-1 w-2 h-2 bg-[#00e054] rounded-full"></span>
            </button>
            <button className="bg-[#00e054] text-[#14181c] px-5 py-2 rounded-xl font-black uppercase text-[11px] tracking-wider flex items-center gap-2 hover:shadow-[0_0_15px_rgba(0,224,84,0.3)] transition-all">
              <Plus size={16} strokeWidth={3} /> Log Entry
            </button>
          </div>
        </header>

        <div className="p-8">
          {view === 'home' && (
            <div className="space-y-12 animate-in fade-in duration-700">
              
              {/* FEATURED HERO */}
              {!searchQuery && (
                <section className="relative h-[400px] rounded-3xl overflow-hidden group cursor-pointer shadow-2xl">
                  <img src={INITIAL_SHOWS[0].backdrop} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" alt="Hero" />
                  <div className="absolute inset-0 bg-gradient-to-r from-[#14181c] via-[#14181c]/40 to-transparent" />
                  <div className="absolute bottom-10 left-10 max-w-xl">
                    <div className="flex items-center gap-2 mb-3">
                      <span className="bg-[#00e054] text-[#14181c] text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-tighter">Editors Pick</span>
                    </div>
                    <h1 className="text-6xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                      {INITIAL_SHOWS[0].title}
                    </h1>
                    <div className="flex items-center gap-4 mb-6">
                       <button onClick={() => handleShowClick(INITIAL_SHOWS[0])} className="bg-white text-black px-8 py-3 rounded-xl font-black uppercase text-xs hover:bg-[#00e054] transition-colors">
                        View Series
                      </button>
                      <button className="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-3 rounded-xl font-black uppercase text-xs hover:bg-white/20 transition-colors">
                        Watchlist
                      </button>
                    </div>
                  </div>
                </section>
              )}

              {/* GRID */}
              <section>
                <div className="flex items-center justify-between mb-8 border-b border-[#2c3440] pb-4">
                  <h2 className="text-white text-xl font-black tracking-tight uppercase italic flex items-center gap-3">
                    <TrendingUp className="text-[#00e054]" /> New & Trending
                  </h2>
                  <div className="flex items-center gap-2">
                    <button className="p-2 bg-[#1b2228] border border-[#2c3440] rounded-lg text-[#678] hover:text-white transition"><Filter size={16} /></button>
                  </div>
                </div>
                
                <div className="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-8">
                  {filteredShows.map(show => (
                    <div 
                      key={show.id}
                      onClick={() => handleShowClick(show)}
                      className="group cursor-pointer relative"
                    >
                      <div className="aspect-[2/3] rounded-2xl overflow-hidden border-2 border-transparent group-hover:border-[#00e054] transition-all duration-300 shadow-xl bg-[#1b2228] relative">
                        <img src={show.poster} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt={show.title} />
                        <div className="absolute top-3 right-3 bg-black/60 backdrop-blur-md px-2 py-1 rounded-lg flex items-center gap-1">
                          <Star size={10} className="fill-[#00e054] text-[#00e054]" />
                          <span className="text-[10px] font-bold text-white">{show.rating}</span>
                        </div>
                      </div>
                      <div className="mt-4">
                        <h3 className="text-white font-black text-sm uppercase italic truncate">{show.title}</h3>
                        <p className="text-[#678] text-[10px] font-bold uppercase tracking-widest mt-1">{show.genre} • {show.year}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </section>

              {/* FEED & ACTIVITY */}
              <div className="grid xl:grid-cols-3 gap-12 pt-8">
                <section className="xl:col-span-2">
                   <h2 className="text-white text-sm font-black uppercase tracking-[0.2em] mb-6 pb-2 border-b border-[#2c3440] flex items-center gap-2">
                    <MessageSquare size={16} className="text-[#00e054]" /> Recent Reviews
                   </h2>
                   <div className="space-y-4">
                      {watchedData.logs.map(log => {
                        const show = INITIAL_SHOWS.find(s => s.id === log.showId);
                        return (
                          <div key={log.id} className="bg-[#1b2228] border border-[#2c3440] p-5 rounded-2xl flex gap-6 hover:border-[#678] transition-colors">
                            <img src={show.poster} className="w-16 h-24 rounded-lg object-cover shadow-lg" alt="Poster" />
                            <div className="flex-1">
                               <div className="flex items-center justify-between mb-2">
                                  <p className="text-xs font-bold text-[#9ab]"><span className="text-white">{log.user}</span> watched <span className="text-white italic">{show.title}</span></p>
                                  <span className="text-[10px] text-[#678] font-bold uppercase">{log.date}</span>
                               </div>
                               <div className="flex items-center gap-1 mb-3">
                                  {[...Array(5)].map((_, i) => (
                                    <Star key={i} size={12} className={i < log.rating ? "fill-[#00e054] text-[#00e054]" : "text-[#2c3440] fill-[#2c3440]"} />
                                  ))}
                               </div>
                               <p className="text-sm text-[#9ab] italic leading-relaxed">"{log.comment}"</p>
                            </div>
                          </div>
                        )
                      })}
                   </div>
                </section>

                <section>
                   <h2 className="text-white text-sm font-black uppercase tracking-[0.2em] mb-6 pb-2 border-b border-[#2c3440] flex items-center gap-2">
                    <Clock size={16} className="text-[#40bcf4]" /> Upcoming
                   </h2>
                   <div className="grid grid-cols-2 gap-4">
                      {watchedData.watchlist.map(id => {
                        const show = INITIAL_SHOWS.find(s => s.id === id);
                        return (
                          <div key={id} onClick={() => handleShowClick(show)} className="group cursor-pointer">
                            <div className="aspect-[2/3] rounded-xl overflow-hidden mb-2 relative">
                               <img src={show.poster} className="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="Show" />
                            </div>
                            <p className="text-[10px] font-black text-white uppercase truncate">{show.title}</p>
                          </div>
                        )
                      })}
                   </div>
                </section>
              </div>
            </div>
          )}

          {view === 'show-detail' && selectedShow && (
            <div className="max-w-6xl mx-auto animate-in fade-in slide-in-from-bottom-8 duration-700">
               <button onClick={() => setView('home')} className="text-[#678] hover:text-white font-black uppercase tracking-widest text-[10px] mb-12 flex items-center gap-2 group">
                 <span className="group-hover:-translate-x-1 transition-transform">←</span> Return
               </button>
               
               <div className="flex flex-col xl:flex-row gap-16">
                  <div className="w-full xl:w-80 flex-shrink-0">
                    <div className="sticky top-32">
                      <img src={selectedShow.poster} className="w-full rounded-3xl shadow-2xl border border-white/10" alt="Selected" />
                      <div className="mt-8 grid grid-cols-2 gap-3">
                        <button className="bg-[#00e054] text-[#14181c] py-4 rounded-xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-2 shadow-lg">
                          <CheckCircle2 size={16} strokeWidth={3} /> Watched
                        </button>
                        <button className="bg-[#2c3440] text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-2 hover:bg-[#343d4b]">
                          <Plus size={16} strokeWidth={3} /> Add List
                        </button>
                      </div>
                    </div>
                  </div>

                  <div className="flex-1">
                     <div className="flex items-center gap-3 mb-6">
                        <span className="px-3 py-1 bg-[#2c3440] text-white text-[10px] font-black uppercase rounded-full">{selectedShow.year}</span>
                        <span className="px-3 py-1 bg-[#00e054]/10 text-[#00e054] text-[10px] font-black uppercase rounded-full border border-[#00e054]/20">{selectedShow.status}</span>
                     </div>
                     <h1 className="text-7xl font-black text-white italic uppercase tracking-tighter mb-6 leading-[0.9]">{selectedShow.title}</h1>
                     
                     <div className="flex items-center gap-12 mb-12 py-8 border-y border-[#2c3440]">
                        <div>
                           <p className="text-[10px] font-black text-[#678] uppercase tracking-widest mb-1">Rating</p>
                           <div className="flex items-center gap-2 text-white">
                              <Star size={24} className="fill-[#00e054] text-[#00e054]" />
                              <span className="text-3xl font-black">{selectedShow.rating}</span>
                           </div>
                        </div>
                        <div className="w-[1px] h-10 bg-[#2c3440]" />
                        <div>
                           <p className="text-[10px] font-black text-[#678] uppercase tracking-widest mb-1">Seasons</p>
                           <p className="text-3xl font-black text-white">{selectedShow.seasons}</p>
                        </div>
                        <div className="w-[1px] h-10 bg-[#2c3440]" />
                        <div>
                           <p className="text-[10px] font-black text-[#678] uppercase tracking-widest mb-1">Genre</p>
                           <p className="text-xl font-black text-white uppercase italic">{selectedShow.genre}</p>
                        </div>
                     </div>

                     <p className="text-[#9ab] text-xl leading-relaxed font-light mb-12">
                        Experience the drama and suspense of {selectedShow.title}. A masterclass in television production, 
                        perfectly balancing high stakes with deep character development.
                     </p>

                     <h3 className="text-white font-black uppercase tracking-[0.2em] text-xs mb-8 flex items-center gap-3">
                        <BarChart3 size={18} className="text-[#00e054]" /> Progress Tracking
                     </h3>
                     <div className="grid sm:grid-cols-2 gap-4">
                        {[...Array(selectedShow.seasons)].map((_, i) => (
                           <div key={i} className="bg-[#1b2228] border border-[#2c3440] p-6 rounded-2xl hover:border-[#00e054] transition-all group cursor-pointer">
                              <div className="flex justify-between items-center mb-4">
                                 <span className="text-white font-black italic uppercase tracking-tight">Season {i + 1}</span>
                                 <span className="text-[#678] text-[10px] font-bold uppercase">{selectedShow.episodesPerSeason} Ep</span>
                              </div>
                              <div className="w-full bg-[#14181c] h-1.5 rounded-full overflow-hidden">
                                 <div className={`h-full bg-[#00e054] shadow-[0_0_10px_#00e054] ${i === 0 ? 'w-full' : 'w-0'}`} />
                              </div>
                           </div>
                        ))}
                     </div>
                  </div>
               </div>
            </div>
          )}

          {view === 'profile' && (
            <div className="max-w-5xl mx-auto animate-in fade-in duration-700">
               <header className="relative py-12 px-10 rounded-[40px] bg-gradient-to-br from-[#1b2228] to-[#14181c] border border-[#2c3440] overflow-hidden mb-12">
                  <div className="relative flex flex-col md:flex-row items-center gap-10">
                     <div className="w-40 h-40 rounded-full bg-gradient-to-br from-[#00e054] to-[#40bcf4] p-1.5 shadow-2xl">
                        <div className="w-full h-full rounded-full bg-[#14181c] flex items-center justify-center">
                           <User size={64} className="text-[#2c3440]" />
                        </div>
                     </div>
                     <div className="text-center md:text-left">
                        <h1 className="text-5xl font-black text-white italic tracking-tighter uppercase mb-2">SeriesFan_01</h1>
                        <p className="text-[#678] font-bold uppercase tracking-[0.2em] text-xs">Series Enthusiast • Joined 2023</p>
                     </div>
                  </div>
               </header>

               <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                  <div className="md:col-span-2 space-y-12">
                     <section>
                        <h2 className="text-white text-sm font-black uppercase tracking-[0.2em] mb-8 pb-2 border-b border-[#2c3440]">All-Time Favorites</h2>
                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                           {INITIAL_SHOWS.slice(0, 4).map(show => (
                              <div key={show.id} className="aspect-[2/3] rounded-xl overflow-hidden shadow-lg border border-white/5">
                                 <img src={show.poster} className="w-full h-full object-cover" alt="Fav" />
                              </div>
                           ))}
                        </div>
                     </section>
                  </div>

                  <section className="bg-[#1b2228] p-8 rounded-3xl border border-[#2c3440] h-fit">
                     <h3 className="text-white font-black uppercase tracking-widest text-xs mb-8">Quick Stats</h3>
                     <div className="space-y-6">
                        <div>
                           <p className="text-[#678] text-[10px] font-black uppercase mb-1 tracking-widest">Time Watched</p>
                           <p className="text-white text-2xl font-black italic">12d 4h 32m</p>
                        </div>
                        <div>
                           <p className="text-[#678] text-[10px] font-black uppercase mb-1 tracking-widest">Completed</p>
                           <p className="text-white text-2xl font-black italic">42 Series</p>
                        </div>
                        <div>
                           <p className="text-[#678] text-[10px] font-black uppercase mb-1 tracking-widest">Top Genre</p>
                           <p className="text-[#00e054] text-2xl font-black italic">SCIFI / DRAMA</p>
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