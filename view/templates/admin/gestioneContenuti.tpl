{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    <h1 class="text-white font-bold text-2xl mb-6 text-center">Gestione Contenuti</h1>
    <div class="flex items-center gap-4 mb-4 flex-col md:flex-row">
        <button onclick="window.location.href='?controller=Admin&action=aggiungiContenuto'" id="addBtn"
            class="px-4 py-2 rounded-lg border border-purple-500/30 text-purple-400 hover:bg-purple-500/10 hover:border-purple-500/80 hover:text-purple-300 text-sm font-semibold transition-all duration-200">
            Aggiungi nuovo
        </button>
        <button id="importBtn"
            class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200">
            Importa da TMDB
        </button>
    </div>
    <!-- Barra di Ricerca Premium -->
    <div class="mb-6 bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-4 flex items-center gap-3">
        <div class="relative flex-grow">
            <!-- Icona lente d'ingrandimento -->
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" id="search-input" placeholder="Cerca per titolo, regista, anno o genere..."
                class="w-full pl-10 pr-4 py-2.5 bg-slate-950/80 border border-slate-800/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
        </div>
        <!-- Contatore di risultati -->
        <span class="text-xs text-slate-500 shrink-0 font-medium hidden md:inline" id="search-count">
            Totale contenuti: {$contenuti|count}
        </span>
    </div>

    <!-- Lista Verticale (Stack Layout) -->
    <div class="flex flex-col gap-4">
        {foreach $contenuti as $c}
            <!-- Aggiunta classe 'content-item' per il filtro JS -->
            <div
                class="content-item bg-slate-900/50 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-slate-700 transition-all duration-300">

                <!-- Sinistra: Informazioni sul Contenuto -->
                <div class="flex-grow space-y-2">
                    <h2 class="font-bold text-white text-lg">{$c->getTitolo()}</h2>

                    <!-- Dettagli in riga -->
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-slate-400 text-xs">
                        <span><strong class="text-slate-500">Anno:</strong> {$c->getAnno()}</span>
                        <span><strong class="text-slate-500">Regista:</strong> {$c->getRegista()}</span>
                        <span><strong class="text-slate-500">Voto:</strong> {$c->getValutazioneMedia()}/10</span>
                        <span>
                            <strong class="text-slate-500">Genere:</strong>
                            {foreach $c->getGeneri() as $g}{$g}
                                {if !$g@last},
                                {/if}
                            {/foreach}
                        </span>
                    </div>

                    <p class="text-slate-400 text-xs mt-2 line-clamp-2 max-w-4xl">{$c->getTrama()}</p>
                </div>

                <!-- Destra: Pulsanti d'Azione -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="?controller=Admin&action=modificaContenuto&id={$c->getId()}"
                        class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 hover:border-purple-500 hover:text-purple-400 text-slate-300 text-sm font-semibold transition-all duration-200 flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Modifica
                    </a>

                    <button onclick="eliminaContenuto('{$c->getId()}')"
                        class="px-4 py-2 rounded-xl bg-red-500/10 border border-red-500/20 hover:border-red-500 hover:bg-red-500/20 text-red-500 text-sm font-semibold transition-all duration-200 flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Elimina
                    </button>
                </div>
            </div>
        {/foreach}
    </div>

    <!-- Script JS di Filtro Istantaneo (Protetto da tag  per Smarty) -->
    {literal}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-input');
                const contentItems = document.querySelectorAll('.content-item');
                const searchCount = document.getElementById('search-count');
                const totalCount = contentItems.length;

                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase().trim();
                        let visibleCount = 0;

                        contentItems.forEach(item => {
                            // Cerca in tutto il testo dell'elemento (Titolo, Regista, Anno, Trama, ecc.)
                    const itemText = item.textContent.toLowerCase();

                    if (itemText.includes(query)) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Aggiorna il contatore dei risultati
                if (searchCount) {
                    if (query === '') {
                                searchCount.textContent = `Totale contenuti: ${totalCount}`;
                            } else {
                                searchCount.textContent = `Trovati: ${visibleCount} di ${totalCount}`;
                            }
                        }
                    });
                }
            });
        </script>
    {/literal}
{/block}