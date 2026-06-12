 <nav class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
         <div class="flex items-center gap-8">
             <!-- Logo -->
             <a href="index.php"
                 class="text-2xl font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                 WatchIT
             </a>
         </div>

         <div class="flex items-center">
             <form action="index.php?controller=Contenuto&action=cerca" method="GET" class="relative hidden sm:block">
                 <input type="text" name="query" placeholder="Cerca un film o una serie..."
                     class="w-[500px] px-4 py-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500">
                 <input type="hidden" name="controller" value="Contenuto">
                 <input type="hidden" name="action" value="cerca">
             </form>
         </div>

         <div class="flex items-center gap-4">
             {if $isLogged}
                 <div class="relative group">
                     <!-- Pulsante con il nome utente e una freccetta indicatrice -->
                     <button
                         class="flex items-center gap-2 text-sm font-semibold text-purple-400 hover:text-purple-300 focus:outline-none transition-colors duration-200 py-2">
                         Ciao, {$currentUser->getUsername()}
                         <!-- Icona freccia (ruota di 180 gradi all'hover) -->
                         <svg class="w-4 h-4 transform transition-transform duration-200 group-hover:rotate-180" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                             </path>
                         </svg>
                     </button>
                     <!-- Menu a tendina (nascosto di default, mostrato all'hover con effetto fade-in) -->
                     <div
                         class="absolute right-0 mt-1 w-52 rounded-xl bg-slate-900 border border-slate-800 p-2 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 flex flex-col gap-1">

                         <a href="index.php?controller=Utente&action=mostraProfilo&id={$currentUser->getId()}"
                             class="px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white text-sm font-semibold transition-all duration-200">
                             Profilo
                         </a>



                         <a href="index.php?controller=Watchlist&action=mostraTutteWatchlist"
                             class="px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white text-sm font-semibold transition-all duration-200">
                             Le mie watchlist
                         </a>

                         {if $ruolo == 'ADMIN'}
                             <a href="index.php?controller=Admin&action=dashboard"
                                 class="px-4 py-2.5 rounded-lg text-amber-400 hover:bg-slate-800 hover:text-amber-300 text-sm font-semibold transition-all duration-200">
                                 Pannello Admin
                             </a>
                         {/if}

                         <!-- Divisore estetico -->
                         <div class="border-t border-slate-800 my-1"></div>

                         <a href="index.php?controller=Utente&action=logout"
                             class="px-4 py-2.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-600 hover:text-white text-sm font-semibold transition-all duration-200">
                             Esci
                         </a>
                     </div>
                 </div>
             {else}
                 <!-- Mostra tasto Accedi se non loggato (apertura modali tramite JS) -->
                 <button onclick="toggleModal('registerModal', true)" id="registerBtn"
                     class="px-4 py-2 rounded-lg border border-purple-500/30 text-purple-400 hover:bg-purple-500/10 hover:border-purple-500/80 hover:text-purple-300 text-sm font-semibold transition-all duration-200">
                     Registrati
                 </button>
                 <button onclick="toggleModal('loginModal', true)" id="loginBtn"
                     class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200">
                     Accedi
                 </button>

             {/if}
         </div>

     </div>
</nav>