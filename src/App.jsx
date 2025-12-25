import React, { useState, useEffect, useMemo } from 'react';
import { 
  Tv, 
  Calendar, 
  Plus, 
  Star, 
  Clock, 
  Search, 
  User, 
  CheckCircle2, 
  TrendingUp, 
  ChevronRight,
  Heart,
  MessageSquare,
  LayoutGrid
} from 'lucide-react';

// --- MOCK DATA ---
const INITIAL_SHOWS = [
  { id: 1, title: "Succession", year: "2018", seasons: 4, episodesPerSeason: 10, poster: "https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1594908900066-3f47337549d8?w=1200&h=400&fit=crop", rating: 4.9, genre: "Drama" },
  { id: 2, title: "The Bear", year: "2022", seasons: 3, episodesPerSeason: 8, poster: "https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&h=400&fit=crop", rating: 4.8, genre: "Comedy/Drama" },
  { id: 3, title: "Severance", year: "2022", seasons: 1, episodesPerSeason: 9, poster: "https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=1200&h=400&fit=crop", rating: 4.7, genre: "Sci-Fi" },
  { id: 4, title: "The White Lotus", year: "2021", seasons: 2, episodesPerSeason: 7, poster: "https://images.unsplash.com/photo-1544161515-4ad6ce6ec896?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&h=400&fit=crop", rating: 4.5, genre: "Satire" },
  { id: 5, title: "Andor", year: "2022", seasons: 1, episodesPerSeason: 12, poster: "https://images.unsplash.com/photo-1534447677768-be436bb09401?w=400&h=600&fit=crop", backdrop: "https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?w=1200&h=400&fit=crop", rating: 4.6, genre: "Sci-Fi" },
];

const App = () => {
  const [view, setView] = useState('home'); // home, profile, search, show-detail
  const [selectedShow, setSelectedShow] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  
  // State for user tracking
  const [watchedData, setWatchedData] = useState({
    watchlist: [3, 5],
    completed: [1],
    favorites: [1, 2, 3, 4],
    logs: [
      { id: 101, showId: 1, date: "2023-10-12", rating: 5, comment: "The finale was perfection." },
      { id: 102, showId: 2, date: "2023-11-05", rating: 4.5, comment: "Cousin is the best character." }
    ]
  });

  const filteredShows = useMemo(() => {
    return INITIAL_SHOWS.filter(s => s.title.toLowerCase().includes(searchQuery.toLowerCase()));
  }, [searchQuery]);

  const toggleWatchlist = (id) => {
    setWatchedData(prev => ({
      ...prev,
      watchlist: prev.watchlist.includes(id) 
        ? prev.watchlist.filter(x => x !== id) 
        : [...prev.watchlist, id]
    }));
  };

  const handleShowClick = (show) => {
    setSelectedShow(show);
    setView('show-detail');
    window.scrollTo(0, 0);
  };

  // --- COMPONENTS ---

  const Navbar = () => (
    <nav className="fixed top-0 w-full bg-[#14181c] border-b border-[#2c3440] z-50">
      <div className="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div 
          className="flex items-center gap-2 cursor-pointer"
          onClick={() => setView('home')}
        >
          <div className="bg-[#00e054] p-1 rounded">
            <Tv size={24} className="text-[#14181c]" />
          </div>
          <span className="text-2xl font-black tracking-tighter text-white uppercase italic">SeriesList</span>
        </div>
        
        <div className="hidden md:flex items-center gap-8 text-[#9ab] font-bold text-sm uppercase tracking-widest">
          <button onClick={() => setView('home')} className={view === 'home' ? 'text-white' : 'hover:text-white transition'}>Home</button>
          <button className="hover:text-white transition">Shows</button>
          <button className="hover:text-white transition">Lists</button>
          <button className="hover:text-white transition">Members</button>
        </div>

        <div className="flex items-center gap-4">
          <div className="relative hidden sm:block">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-[#678]" size={16} />
            <input 
              type="text" 
              placeholder="Search shows..." 
              className="bg-[#2c3440] text-white pl-10 pr-4 py-1.5 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-[#00e054] w-48"
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
            />
          </div>
          <button 
            onClick={() => setView('profile')}
            className={`p-1.5 rounded-full ${view === 'profile' ? 'bg-[#00e054] text-[#14181c]' : 'text-[#9ab] hover:text-white'}`}
          >
            <User size={20} />
          </button>
        </div>
      </div>
    </nav>
  );

  const Poster = ({ show, size = "md" }) => (
    <div 
      onClick={() => handleShowClick(show)}
      className={`relative group cursor-pointer overflow-hidden rounded-md border-2 border-transparent hover:border-[#00e054] transition-all duration-200
        ${size === 'lg' ? 'w-48 h-72' : size === 'sm' ? 'w-24 h-36' : 'w-full aspect-[2/3]'}`}
    >
      <img src={show.poster} alt={show.title} className="w-full h-full object-cover" />
      <div className="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4 text-center">
        <p className="text-white text-xs font-bold leading-tight">{show.title}</p>
      </div>
    </div>
  );

  const Home = () => (
    <div className="space-y-12">
      <section>
        <div className="flex items-center justify-between mb-4 border-b border-[#2c3440] pb-2">
          <h2 className="text-[#9ab] text-sm uppercase tracking-widest font-bold flex items-center gap-2">
            <TrendingUp size={16} /> Popular This Week
          </h2>
          <button className="text-[#678] text-xs font-bold hover:text-white flex items-center uppercase tracking-widest">
            More <ChevronRight size={14} />
          </button>
        </div>
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
          {filteredShows.map(show => (
            <Poster key={show.id} show={show} />
          ))}
        </div>
      </section>

      <div className="grid md:grid-cols-3 gap-8">
        <section className="md:col-span-2">
          <div className="flex items-center justify-between mb-4 border-b border-[#2c3440] pb-2">
            <h2 className="text-[#9ab] text-sm uppercase tracking-widest font-bold">Recent Activity</h2>
          </div>
          <div className="space-y-4">
            {watchedData.logs.map(log => {
              const show = INITIAL_SHOWS.find(s => s.id === log.showId);
              return (
                <div key={log.id} className="flex gap-4 p-4 bg-[#1b2228] rounded-lg border border-[#2c3440]">
                  <Poster show={show} size="sm" />
                  <div className="flex-1">
                    <div className="flex items-center justify-between mb-1">
                      <h3 className="text-white font-bold">{show.title}</h3>
                      <span className="text-[#678] text-xs">{log.date}</span>
                    </div>
                    <div className="flex items-center gap-1 mb-2">
                      {[...Array(5)].map((_, i) => (
                        <Star 
                          key={i} 
                          size={14} 
                          className={i < log.rating ? "text-[#00e054] fill-[#00e054]" : "text-[#2c3440] fill-[#2c3440]"} 
                        />
                      ))}
                    </div>
                    <p className="text-[#9ab] text-sm italic">"{log.comment}"</p>
                  </div>
                </div>
              );
            })}
          </div>
        </section>

        <section>
          <div className="flex items-center justify-between mb-4 border-b border-[#2c3440] pb-2">
            <h2 className="text-[#9ab] text-sm uppercase tracking-widest font-bold">Watchlist</h2>
          </div>
          <div className="grid grid-cols-2 gap-2">
            {watchedData.watchlist.map(id => (
              <Poster key={id} show={INITIAL_SHOWS.find(s => s.id === id)} />
            ))}
          </div>
        </section>
      </div>
    </div>
  );

  const ShowDetail = () => {
    if (!selectedShow) return null;
    const isWatchlisted = watchedData.watchlist.includes(selectedShow.id);
    
    return (
      <div className="animate-in fade-in duration-500">
        <div className="relative h-[400px] -mx-4 -mt-8 mb-8">
          <img src={selectedShow.backdrop} className="w-full h-full object-cover opacity-20 mask-gradient" alt="" />
          <div className="absolute inset-0 bg-gradient-to-t from-[#14181c] to-transparent" />
        </div>

        <div className="flex flex-col md:flex-row gap-8 -mt-32 relative z-10">
          <div className="w-64 mx-auto md:mx-0">
            <Poster show={selectedShow} size="lg" />
            <div className="mt-4 bg-[#2c3440] rounded-lg overflow-hidden divide-y divide-[#14181c]/50">
              <button 
                onClick={() => toggleWatchlist(selectedShow.id)}
                className={`w-full p-3 flex items-center justify-center gap-2 font-bold text-sm uppercase tracking-widest transition
                  ${isWatchlisted ? 'bg-[#40bcf4] text-white' : 'text-[#9ab] hover:bg-[#343d4b] hover:text-white'}`}
              >
                <Clock size={16} /> {isWatchlisted ? 'On Watchlist' : 'Watchlist'}
              </button>
              <button className="w-full p-3 flex items-center justify-center gap-2 text-[#9ab] hover:bg-[#343d4b] hover:text-white font-bold text-sm uppercase tracking-widest transition">
                <CheckCircle2 size={16} /> Mark as Watched
              </button>
              <button className="w-full p-3 flex items-center justify-center gap-2 text-[#9ab] hover:bg-[#343d4b] hover:text-white font-bold text-sm uppercase tracking-widest transition">
                <Star size={16} /> Rate & Review
              </button>
            </div>
          </div>

          <div className="flex-1 text-center md:text-left">
            <div className="flex flex-col md:flex-row md:items-baseline gap-4 mb-4">
              <h1 className="text-4xl font-black text-white leading-none">{selectedShow.title}</h1>
              <span className="text-[#9ab] font-serif italic text-xl">{selectedShow.year}</span>
              <span className="text-xs font-bold px-2 py-1 bg-[#2c3440] text-[#9ab] rounded uppercase tracking-wider self-center md:self-baseline">
                Directed by Multiple
              </span>
            </div>

            <div className="flex items-center justify-center md:justify-start gap-6 text-[#9ab] mb-6">
              <div className="flex items-center gap-1 text-[#00e054]">
                <Star size={20} className="fill-[#00e054]" />
                <span className="text-2xl font-bold">{selectedShow.rating}</span>
                <span className="text-xs text-[#678] mt-1 ml-1">/ 5</span>
              </div>
              <div className="h-4 w-[1px] bg-[#2c3440]" />
              <div className="flex flex-col">
                <span className="text-xs uppercase tracking-widest font-bold">Seasons</span>
                <span className="text-white font-bold">{selectedShow.seasons}</span>
              </div>
              <div className="h-4 w-[1px] bg-[#2c3440]" />
              <div className="flex flex-col">
                <span className="text-xs uppercase tracking-widest font-bold">Genre</span>
                <span className="text-white font-bold">{selectedShow.genre}</span>
              </div>
            </div>

            <p className="text-[#9ab] text-lg leading-relaxed mb-8 max-w-2xl">
              Logline for {selectedShow.title}. In this television landscape, secrets are hard to keep and the stakes have never been higher. A masterclass in pacing, character development, and narrative tension.
            </p>

            <div className="space-y-6">
              <h3 className="text-white font-bold uppercase tracking-widest text-sm border-b border-[#2c3440] pb-2">Seasons</h3>
              <div className="grid sm:grid-cols-2 gap-4">
                {[...Array(selectedShow.seasons)].map((_, i) => (
                  <div key={i} className="bg-[#1b2228] p-4 rounded border border-[#2c3440] hover:border-[#00e054] transition group cursor-pointer">
                    <div className="flex justify-between items-center mb-2">
                      <span className="text-white font-bold">Season {i + 1}</span>
                      <span className="text-[#678] text-xs">{selectedShow.episodesPerSeason} Episodes</span>
                    </div>
                    <div className="w-full bg-[#14181c] h-1.5 rounded-full overflow-hidden">
                      <div className={`h-full bg-[#00e054] ${i === 0 ? 'w-full' : 'w-0'}`} />
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  };

  const Profile = () => (
    <div className="space-y-12">
      <header className="flex flex-col md:flex-row items-center gap-8 py-8 border-b border-[#2c3440]">
        <div className="w-32 h-32 rounded-full bg-gradient-to-br from-[#00e054] to-[#40bcf4] p-1">
          <div className="w-full h-full rounded-full bg-[#14181c] flex items-center justify-center">
            <User size={48} className="text-[#9ab]" />
          </div>
        </div>
        <div className="text-center md:text-left">
          <h1 className="text-3xl font-black text-white mb-2">SeriesFan_01</h1>
          <div className="flex gap-6 text-sm text-[#9ab] uppercase tracking-widest font-bold">
            <div className="flex flex-col items-center md:items-start">
              <span className="text-white text-xl">42</span>
              <span>Shows</span>
            </div>
            <div className="flex flex-col items-center md:items-start">
              <span className="text-white text-xl">1.2k</span>
              <span>Episodes</span>
            </div>
            <div className="flex flex-col items-center md:items-start">
              <span className="text-white text-xl">28</span>
              <span>Lists</span>
            </div>
          </div>
        </div>
      </header>

      <section>
        <h2 className="text-[#9ab] text-sm uppercase tracking-widest font-bold mb-4">Favorite Series</h2>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          {watchedData.favorites.map(id => (
            <Poster key={id} show={INITIAL_SHOWS.find(s => s.id === id)} />
          ))}
        </div>
      </section>

      <section className="bg-[#1b2228] rounded-xl p-8 border border-[#2c3440]">
        <div className="flex items-center gap-4 mb-6">
          <Calendar className="text-[#00e054]" />
          <h2 className="text-white text-xl font-bold">Viewing Stats</h2>
        </div>
        <div className="grid sm:grid-cols-3 gap-8">
          <div className="space-y-2">
            <p className="text-[#678] uppercase tracking-widest text-xs font-bold">Total Time Spent</p>
            <p className="text-2xl text-white font-black">12d 14h 22m</p>
          </div>
          <div className="space-y-2">
            <p className="text-[#678] uppercase tracking-widest text-xs font-bold">Top Genre</p>
            <p className="text-2xl text-[#40bcf4] font-black uppercase italic tracking-tighter">Drama</p>
          </div>
          <div className="space-y-2">
            <p className="text-[#678] uppercase tracking-widest text-xs font-bold">Avg. Episode Rating</p>
            <div className="flex items-center gap-2">
              <Star className="text-[#00e054] fill-[#00e054]" size={20} />
              <p className="text-2xl text-white font-black">4.2</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  );

  return (
    <div className="min-h-screen bg-[#14181c] text-[#9ab] font-sans selection:bg-[#00e054] selection:text-[#14181c]">
      <Navbar />
      
      <main className="max-w-6xl mx-auto px-4 pt-24 pb-20">
        {view === 'home' && <Home />}
        {view === 'profile' && <Profile />}
        {view === 'show-detail' && <ShowDetail />}
      </main>

      <footer className="bg-[#1b2228] border-t border-[#2c3440] py-12">
        <div className="max-w-6xl mx-auto px-4 text-center">
          <p className="text-sm font-bold text-[#678] uppercase tracking-widest mb-4">
            Made for Series Fans
          </p>
          <div className="flex justify-center gap-8 mb-8">
            <Heart size={20} className="text-[#678] hover:text-[#ff3b30] cursor-pointer" />
            <MessageSquare size={20} className="text-[#678] hover:text-[#00e054] cursor-pointer" />
            <LayoutGrid size={20} className="text-[#678] hover:text-[#40bcf4] cursor-pointer" />
          </div>
          <p className="text-xs text-[#2c3440]">© SeriesList. Data powered by community.</p>
        </div>
      </footer>
    </div>
  );
};

export default App;