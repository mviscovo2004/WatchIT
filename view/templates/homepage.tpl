<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WatchIT - Il tuo Cinema Personale</title>
    <!-- Importazione di Tailwind CSS e Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen relative overflow-x-hidden">
    <!-- Sfondi sfumati decorativi (Aura Premium) -->
    <div class="absolute w-[600px] h-[600px] bg-red-600/5 rounded-full blur-[150px] -top-80 -left-60 pointer-events-none"></div>
    <div class="absolute w-[600px] h-[600px] bg-indigo-600/5 rounded-full blur-[150px] top-[40%] -right-60 pointer-events-none"></div>

    <!-- 1. BARRA DI NAVIGAZIONE -->
    <nav class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="index.php" class="text-2xl font-black tracking-wider bg-gradient-to-r from-red-500 to-indigo-500 text-transparent bg-clip-text">
                    WatchIT
                </a>
                
                <!-- Voci Navigazione -->
                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-300">
                    <a href="#" class="hover:text-white transition-colors duration-200">Film</a>
                    <a href="#" class="hover:text-white transition-colors duration-200">Serie TV</a>
                    <a href="#" class="hover:text-white transition-colors duration-200">La mia Watchlist</a>
                    <a href="#" class="hover:text-white transition-colors duration-200">Recensioni</a>
                </div>
            </div>

            <!-- Ricerca & Bottone Login -->
            <div class="flex items-center gap-4">
                <div class="relative hidden sm:block">
                    <input type="text" placeholder="Cerca un film o una serie..." 
                           class="w-64 px-4 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                </div>
                <a href="index.php?controller=Utente&action=login" 
                   class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition-all duration-200">
                    Accedi
                </a>
            </div>
        </div>
    </nav>

    <!-- 2. SEZIONE HERO (FILM IN EVIDENZA) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="relative rounded-2xl overflow-hidden aspect-[21/9] bg-slate-900 border border-slate-800/80 shadow-2xl flex items-end">
            <!-- Immagine di sfondo con overlay sfumato -->
            <div class="absolute inset-0 bg-cover bg-center opacity-40 transition-transform duration-[10s] hover:scale-105" 
                 style="background-image: url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?auto=format&fit=crop&w=1200&q=80');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

            <!-- Dettagli Film -->
            <div class="relative p-6 sm:p-10 md:p-12 max-w-xl z-10">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 text-xs font-bold bg-red-600 text-white rounded uppercase tracking-wider">Top 1</span>
                    <span class="text-sm font-medium text-slate-300">Film del Momento</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                    L'Inizio dell'Avventura
                </h2>
                <p class="text-slate-300 text-sm sm:text-base mb-6 line-clamp-3 leading-relaxed">
                    Un viaggio incredibile oltre i confini del tempo e dello spazio. Accompagna i protagonisti alla scoperta di mondi inesplorati in un'opera di fantascienza visivamente sbalorditiva.
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="px-6 py-3 rounded-xl bg-white text-slate-950 font-bold hover:bg-slate-200 transition-all duration-200 shadow-lg transform hover:-translate-y-0.5">
                        Guarda Ora
                    </a>
                    <a href="#" class="px-6 py-3 rounded-xl bg-slate-800/80 border border-slate-700 font-bold text-white hover:bg-slate-700 transition-all duration-200 backdrop-blur-sm">
                        + Watchlist
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GRIGLIA CONTENUTI POPOLARI -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h3 class="text-2xl font-extrabold text-white mb-6 tracking-tight flex items-center gap-2">
            <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
            Titoli più popolari
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <!-- Card 1 -->
            <div class="group cursor-pointer">
                <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                    <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=400&q=80" 
                         alt="Cover" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                        <span class="text-xs font-bold text-indigo-400">Genere: Fantascienza</span>
                    </div>
                </div>
                <h4 class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1">Interstellar Void</h4>
                <p class="text-xs text-slate-500 font-semibold">Anno: 2025</p>
            </div>

            <!-- Card 2 -->
            <div class="group cursor-pointer">
                <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                    <img src="https://images.unsplash.com/photo-1509198397868-475647b2a1e5?auto=format&fit=crop&w=400&q=80" 
                         alt="Cover" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                        <span class="text-xs font-bold text-indigo-400">Genere: Thriller</span>
                    </div>
                </div>
                <h4 class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1">Midnight Shadow</h4>
                <p class="text-xs text-slate-500 font-semibold">Anno: 2024</p>
            </div>

            <!-- Card 3 -->
            <div class="group cursor-pointer">
                <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                    <img src="https://images.unsplash.com/photo-1440404653325-ab127d49abc1?auto=format&fit=crop&w=400&q=80" 
                         alt="Cover" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                        <span class="text-xs font-bold text-indigo-400">Genere: Noir</span>
                    </div>
                </div>
                <h4 class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1">Classic Memories</h4>
                <p class="text-xs text-slate-500 font-semibold">Anno: 2023</p>
            </div>

            <!-- Card 4 -->
            <div class="group cursor-pointer">
                <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                    <img src="https://images.unsplash.com/photo-1505686994434-e3cc5abf1330?auto=format&fit=crop&w=400&q=80" 
                         alt="Cover" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                        <span class="text-xs font-bold text-indigo-400">Genere: Commedia</span>
                    </div>
                </div>
                <h4 class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1">Laugh Out Loud</h4>
                <p class="text-xs text-slate-500 font-semibold">Anno: 2026</p>
            </div>

            <!-- Card 5 -->
            <div class="group cursor-pointer">
                <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                    <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=400&q=80" 
                         alt="Cover" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                        <span class="text-xs font-bold text-indigo-400">Genere: Fantasy</span>
                    </div>
                </div>
                <h4 class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1">Magic Woods</h4>
                <p class="text-xs text-slate-500 font-semibold">Anno: 2025</p>
            </div>
        </div>
    </div>
</body>
</html>
