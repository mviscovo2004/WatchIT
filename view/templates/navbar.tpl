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
             <div class="relative hidden sm:block">
                 <input type="text" placeholder="Cerca un film o una serie..."
                     class="w-[500px] px-4 py-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500">
             </div>
         </div>

         <div class="flex items-center gap-4">
             {if $isLogged}
                 <!-- Mostra nome utente e tasto Esci se loggato -->
                 <span class="text-sm font-semibold text-indigo-400">Ciao, {$currentUser->getUsername()}</span>
                 <a href="index.php?controller=Utente&action=logout"
                     class="px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-500 text-white text-sm font-semibold transition-all duration-200">
                     Esci
                 </a>
             {else}
                 <!-- Mostra tasto Accedi se non loggato -->
                 <a href="index.php?controller=Utente&action=registrazione" id="registerBtn"
                     class="px-4 py-2 rounded-lg border border-purple-500/30 text-purple-400 hover:bg-purple-500/10 hover:border-purple-500/80 hover:text-purple-300 text-sm font-semibold transition-all duration-200">
                     Registrati
                 </a>
                 <a href="index.php?controller=Utente&action=login" id="loginBtn"
                     class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200">
                     Accedi
                 </a>
             {/if}
         </div>

     </div>
</nav>