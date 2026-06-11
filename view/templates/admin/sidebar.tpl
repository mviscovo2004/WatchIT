<div class="h-full flex flex-col bg-slate-900/60 backdrop-blur-md border-r border-slate-800/80 text-slate-300">
    <!-- Brand / Header -->
    <div class="p-6 border-b border-slate-800/80 flex items-center gap-3">
        <div
            class="bg-gradient-to-r from-purple-600 to-amber-500 p-2 rounded-lg text-white font-bold text-lg tracking-wider shadow-md shadow-purple-600/20">
            W
        </div>
        <div>
            <h2 class="text-white font-bold tracking-tight">WatchIT</h2>
            <span class="text-[10px] text-amber-500 font-semibold uppercase tracking-wider block">Admin Panel</span>
        </div>
    </div>

    <!-- Lista di Navigazione -->
    <div class="flex-grow overflow-y-auto px-4 py-6 space-y-7">

        <!-- Gruppo Principale -->
        <div>
            <span class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Principale</span>
            <ul class="mt-2 space-y-1">
                <li>
                    <a href="?controller=Admin&action=dashboard"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium hover:text-white hover:bg-slate-800/60 transition-all duration-300 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-500 transition-colors" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <!-- Gruppo Gestione -->
        <div>
            <span class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Gestione</span>
            <ul class="mt-2 space-y-2">

                <!-- Gestione Contenuti -->
                <li>
                    <div class="space-y-1">
                        <button type="button"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium hover:text-white hover:bg-slate-800/60 transition-all duration-300 group menu-trigger"
                            data-target="submenu-contenuti">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-500 transition-colors"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                                Contenuti
                            </span>
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-slate-300 transition-transform duration-300 transform chevron"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sottomenu Contenuti (nascosto di default con 'hidden') -->
                        <ul id="submenu-contenuti"
                            class="pl-9 space-y-1 text-xs text-slate-400 border-l border-slate-800 ml-5 hidden">
                            <li>
                                <a href="?controller=Admin&action=listaContenuti"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Lista contenuti
                                </a>
                            </li>
                            <li>
                                <a href="?controller=Admin&action=aggiungiContenuto"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Aggiungi Nuovo
                                </a>
                            </li>
                            <li>
                                <a href="?controller=Admin&action=inserisciContenutoDaTMDB"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Inserisci da TMDB
                                </a>
                            </li>
                            <li>
                                <a href="?controller=Admin&action=listaFilm"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Lista film
                                </a>
                            </li>
                            <li>
                                <a href="?controller=Admin&action=listaSerie"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Lista serie tv
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <!-- Gestione Utenti -->
                <li>
                    <div class="space-y-1">
                        <button type="button"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium hover:text-white hover:bg-slate-800/60 transition-all duration-300 group menu-trigger"
                            data-target="submenu-utenti">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-500 transition-colors"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Utenti
                            </span>
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-slate-300 transition-transform duration-300 transform chevron"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sottomenu Utenti (nascosto di default con 'hidden') -->
                        <ul id="submenu-utenti"
                            class="pl-9 space-y-1 text-xs text-slate-400 border-l border-slate-800 ml-5 hidden">
                            <li>
                                <a href="?controller=Admin&action=listaUtenti"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Lista Utenti
                                </a>
                            </li>
                            <li>
                                <a href="?controller=Admin&action=listaBannati"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Utenti Bannati
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Gestione Recensioni -->
                <li>
                    <div class="space-y-1">
                        <button type="button"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium hover:text-white hover:bg-slate-800/60 transition-all duration-300 group menu-trigger"
                            data-target="submenu-recensioni">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-pink-500 transition-colors"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Recensioni
                            </span>
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-slate-300 transition-transform duration-300 transform chevron"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Sottomenu Recensioni (nascosto di default con 'hidden') -->
                        <ul id="submenu-recensioni"
                            class="pl-9 space-y-1 text-xs text-slate-400 border-l border-slate-800 ml-5 hidden">
                            <li>
                                <a href="?controller=Admin&action=listaRecensioni"
                                    class="py-1.5 hover:text-white transition-colors flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    Lista Recensioni
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Azioni in fondo -->
    <div class="p-4 border-t border-slate-800/80">
        <a href="index.php"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-850 transition-all duration-300 group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-500 transition-colors" fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Torna al Sito
        </a>
    </div>
</div>

<!-- Script per la gestione dinamica del dropdown -->
{literal}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const triggers = document.querySelectorAll('.menu-trigger');

            triggers.forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const targetMenu = document.getElementById(targetId);
                    const chevron = this.querySelector('.chevron');

                    if (targetMenu.classList.contains('hidden')) {
                        // Mostra il sottomenu e ruota il chevron
                        targetMenu.classList.remove('hidden');
                        chevron.classList.add('rotate-180');
                    } else {
                        // Nascondi il sottomenu e ripristina il chevron
                        targetMenu.classList.add('hidden');
                        chevron.classList.remove('rotate-180');
                    }
                });
            });

            // Auto-espansione automatica basata sull'azione nell'URL
            const urlParams = new URLSearchParams(window.location.search);
            const action = urlParams.get('action');

            if (action) {
                let activeMenuId = null;

                // Mappa le azioni al rispettivo menu
                const contenutiActions = ['listaContenuti', 'aggiungiContenuto', 'inserisciContenutoDaTMDB',
                    'listaFilm', 'listaSerie', 'listaAttori', 'listaRegisti'
                ];
                const utentiActions = ['listaUtenti', 'listaUtentiBannati'];
                const recensioniActions = ['listaRecensioni'];

                if (contenutiActions.includes(action)) {
                    activeMenuId = 'submenu-contenuti';
                } else if (utentiActions.includes(action)) {
                    activeMenuId = 'submenu-utenti';
                } else if (recensioniActions.includes(action)) {
                    activeMenuId = 'submenu-recensioni';
                }

                // Se c'è una corrispondenza, espande il sottomenu all'avvio
                if (activeMenuId) {
                    const activeMenu = document.getElementById(activeMenuId);
                    if (activeMenu) {
                        activeMenu.classList.remove('hidden');
                        const trigger = document.querySelector(`.menu-trigger[data-target="${activeMenuId}"]`);
                        if (trigger) {
                            const chevron = trigger.querySelector('.chevron');
                            if (chevron) {
                                chevron.classList.add('rotate-180');
                            }
                        }
                    }
                }
            }
        });
</script>{/literal}