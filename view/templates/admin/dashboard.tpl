{extends file="admin/mainAdmin.tpl"}


{if $isLogged && $ruolo == 'ADMIN'}
    {block name="content"}
        <h1 class="text-white font-bold text-2xl mb-4" align="center">Dashboard</h1>

        <!-- Statistiche principali -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Totale utenti -->
            <div class="glass-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Totale Utenti
                        </h3>
                        <p class="text-4xl font-bold text-white">{$stats.utenti}</p>
                    </div>
                    <div class="bg-indigo-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Totale contenuti -->
            <div class="glass-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Totale Contenuti
                        </h3>
                        <p class="text-4xl font-bold text-white">{$stats.contenuti}</p>
                    </div>
                    <div class="bg-purple-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Totale recensioni -->
            <div class="glass-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Totale Recensioni
                        </h3>
                        <p class="text-4xl font-bold text-white">{$stats.recensioni}</p>
                    </div>
                    <div class="bg-yellow-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenuti recenti -->
        <div class="glass-panel p-6 mb-8">
            <h3 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Contenuti aggiunti di recente
            </h3>

            {if $contenutiRecenti}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    {foreach $contenutiRecenti as $contenuto}
                        <div class="relative group">
                            <!-- Copertina con overlay animato -->
                            <a href="?controller=Contenuto&action=mostra&id={$contenuto->getId()}" class="block">
                                <div
                                    class="bg-slate-800 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-indigo-900/30 transition-all duration-300 transform hover:-translate-y-1">
                                    <!-- Locandina del contenuto -->
                                    <img src="{$contenuto->getLocandina()}" alt="{$contenuto->getTitolo()}"
                                        class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                                    <!-- Overlay con titolo -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-4 flex items-end">
                                        <p class="text-white text-sm font-semibold leading-tight">{$contenuto->getTitolo()}</p>
                                    </div>
                                </div>
                            </a>
                            <!-- Informazioni sotto la copertina -->
                            <div class="mt-2">
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">{$contenuto->getAnno()}</p>
                                <p class="text-sm font-bold text-white truncate">{$contenuto->getTitolo()}</p>
                            </div>
                        </div>
                    {/foreach}
                </div>
            {else}
                <p class="text-slate-400 text-sm">Nessun contenuto recente disponibile.</p>
            {/if}
        </div>
    {/block}
{/if}