import React, { useState } from 'react';
import { 
  Tv, Star, Search, User, 
  TrendingUp, ChevronRight, Play, Plus, LayoutGrid, List, Clock
} from 'lucide-react';

const INITIAL_SHOWS = [
  { id: 1, title: "Succession", year: "2018", seasons: 4, rating: 4.9, genre: "Drama", poster: "https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=500&q=80" },
  { id: 2, title: "The Bear", year: "2022", seasons: 3, rating: 4.8, genre: "Comedy", poster: "https://images.unsplash.com/photo-1559339352-11d035aa65de?w=500&q=80" },
  { id: 3, title: "Severance", year: "2022", seasons: 1, rating: 4.7, genre: "Sci-Fi", poster: "https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=500&q=80" },
  { id: 4, title: "The White Lotus", year: "2021", seasons: 2, rating: 4.5, genre: "Satire", poster: "https://images.unsplash.com/photo-1544161515-4ad6ce6ec896?w=500&q=80" },
  { id: 5, title: "Andor", year: "2022", seasons: 1, rating: 4.6, genre: "Sci-Fi", poster: "https://images.unsplash.com/photo-1534447677768-be436bb09401?w=500&q=80" },
];

export default function App() {
  const [view, setView] = useState('home');
  const [selectedShow, setSelectedShow] = useState(null);
  const [search, setSearch] = useState('');

  const filteredShows = INITIAL_SHOWS.filter(show => 
    show.title.toLowerCase().includes(search.toLowerCase())
  );

  const NavItem = ({ icon: Icon, label, active, onClick }) => (
    <button 
      onClick={onClick}
      className={`flex items-center gap-3 px-4 py-3 w-full rounded-xl transition-all duration-200 ${
        active ? 'bg-[#00e054] text-[#14181c]' : 'text-[#9ab] hover:bg-[#2c3440] hover:text-white'
      }`}
    >
      <Icon size={20} />
      <span className="font-bold tracking-tight">{label}</span>
    </button>
  );

  return (
    <div className="flex min-h-screen bg-[#14181c] text-[#9ab] font-sans selection:bg-[#00e054] selection:text-[#14181c]">
      <aside className="w-64 border-r border-[#2c3440] p-6 hidden lg:flex flex-col gap-8 fixed h-full bg-[#14181c]">
        <div className="flex items-center gap-2 mb-4 px-2 cursor-pointer" onClick={() => setView('home')}>
          <div className="bg-[#00e054] p-1.5 rounded-lg">
            <Tv size={24} className="text-[#14181c]" />
          </div>
          <span className="text-2xl font-black text-white italic tracking-tighter uppercase">SeriesList</span>
        </div>

        <nav className="space-y-2">
          <NavItem icon={LayoutGrid} label="Discover" active={view === 'home'} onClick={() => setView('home')} />
          <NavItem icon={TrendingUp} label="Trending" />
          <NavItem icon={List} label="My Lists" />
          <NavItem icon={Clock} label="Watchlist" />
        </nav>

        <div className="mt-auto">
          <NavItem icon={User} label="My Profile" active={view === 'profile'} onClick={() => setView('profile')} />
        </div>
      </aside>

      <main className="flex-1 lg:ml-64 p-8">
        <header className="flex justify-between items-center mb-12">
          <div className="relative w-96">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-[#678]" size={18} />
            <input 
              type="text"
              placeholder="Search series..."
              className="w-full bg-[#1b2228] border border-[#2c3440] rounded-2xl py-3 pl-12 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-[#00e054] transition-all"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
            />
          </div>
          <button className="bg-[#00e054] text-[#14181c] px-6 py-3 rounded-2xl font-black uppercase text-sm flex items-center gap-2 hover:scale-105 transition-transform active:scale-95">
            <Plus size={18} strokeWidth={3} /> Log Episode
          </button>
        </header>

        {view === 'home' && (
          <div className="space-y-12">
            <section>
              <div className="flex items-center justify-between mb-6">
                <h2 className="text-white text-2xl font-black tracking-tight uppercase italic">New & Noteworthy</h2>
              </div>
              <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {filteredShows.map(show => (
                  <div 
                    key={show.id}
                    onClick={() => { setSelectedShow(show); setView('detail'); }}
                    className="group cursor-pointer relative"
                  >
                    <div className="aspect-[2/3] rounded-2xl overflow-hidden border-2 border-transparent group-hover:border-[#00e054] transition-all duration-300 shadow-lg bg-[#1b2228]">
                      <img src={show.poster} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt={show.title} />
                      <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                        <p className="text-white font-black text-sm uppercase italic">{show.title}</p>
                        <div className="flex items-center gap-1 text-[#00e054] mt-1">
                          <Star size={12} className="fill-[#00e054]" />
                          <span className="text-xs font-bold">{show.rating}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </section>
          </div>
        )}

        {view === 'detail' && selectedShow && (
          <div className="max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-300">
            <button onClick={() => setView('home')} className="text-[#678] hover:text-white font-bold uppercase tracking-widest text-xs mb-8 flex items-center gap-2">
              ← Back to Discovery
            </button>
            <div className="flex flex-col md:flex-row gap-12">
              <img src={selectedShow.poster} className="w-72 rounded-3xl shadow-2xl border-4 border-[#2c3440] bg-[#1b2228]" />
              <div>
                <h1 className="text-6xl font-black text-white italic tracking-tighter uppercase mb-2">{selectedShow.title}</h1>
                <p className="text-2xl text-[#678] font-serif italic mb-6">{selectedShow.year}</p>
                <div className="flex gap-8 mb-8">
                   <div>
                      <p className="text-xs font-bold uppercase text-[#678]">Rating</p>
                      <p className="text-2xl text-white font-black">{selectedShow.rating}</p>
                   </div>
                   <div>
                      <p className="text-xs font-bold uppercase text-[#678]">Seasons</p>
                      <p className="text-2xl text-white font-black">{selectedShow.seasons}</p>
                   </div>
                </div>
                <button className="bg-[#00e054] text-[#14181c] px-8 py-4 rounded-2xl font-black uppercase text-sm hover:scale-105 transition-transform active:scale-95">
                  Add to Watchlist
                </button>
              </div>
            </div>
          </div>
        )}
      </main>
    </div>
  );
}