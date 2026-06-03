{extends file="main.tpl"}

{block name="content"}
    <div class="min-h-screen bg-slate-950 text-slate-100 py-10 px-4 sm:px-6 lg:px-8">
        <!-- Rimosso lo sfondo, il bordo e l'effetto glassmorphism per eliminare la card -->
        <div class="max-w-6xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- Colonna Locandina (1/4 della larghezza su schermi grandi) -->
                <div class="md:col-span-1 flex flex-col items-center md:items-start">
                    <div
                        class="group relative w-64 h-96 sm:w-72 sm:h-[26rem] md:w-full md:h-[28rem] rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 shadow-xl transition-all duration-300 hover:shadow-indigo-500/10">
                        <img src="{$serie->getLocandina()}" alt="{$serie->getTitolo()}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-550 ease-out">

                        {if $isLogged}
                            <a href="index.php?controller=Watchlist&action=aggiungi&id={$serie->getId()}"
                                class="absolute top-4 right-4 p-3 rounded-full bg-slate-950/80 border border-slate-800 font-bold text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-350 backdrop-blur-md opacity-0 group-hover:opacity-100 z-20 shadow-lg transform hover:scale-110"
                                title="{if $watchlistIds && in_array($serie->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                                {if $watchlistIds && in_array($serie->getId(), $watchlistIds)}
                                    <!-- Spunta verde se già in watchlist -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                {else}
                                    <!-- Icona Più (+) se da aggiungere -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                {/if}
                            </a>
                        {/if}
                    </div>
                </div>

                <!-- Colonna Dettagli (3/4 della larghezza su schermi grandi) -->
                <div class="md:col-span-3 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">

                        <!-- Contenitore Flex per Titolo (Sinistra) e Pulsante Valuta (Destra) -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h1
                                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-amber-500 tracking-tight leading-tight pb-2">
                                {$serie->getTitolo()}
                            </h1>


                            <!-- Pulsante Valuta posizionato tutto a destra -->
                            {if $isLogged}
                                <a href="index.php?controller=Recensione&action=aggiungiRecensione&id={$serie->getId()}"
                                    class="shrink-0 inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/20 text-sm hover:scale-105 active:scale-95 self-start sm:self-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Valuta
                                </a>
                            {/if}
                        </div>

                        <!-- Chips Informative (Anno, Stato, Valutazione) -->
                        <div class="flex flex-wrap gap-3 items-center text-sm pt-2">
                            <span
                                class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                                Anno: {$serie->getAnno()}
                            </span>

                            <span
                                class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                                Autore: {$serie->getRegista()}
                            </span>

                            <span
                                class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                                Stagioni: {$serie->getNumeroStagioni()}
                            </span>

                            <span
                                class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Stato:
                                {$serie->getStato()->value|replace: '_' : ' '|capitalize }
                            </span>

                            <span
                                class="flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3.5 py-1.5 rounded-xl font-semibold shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-amber-400" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {$serie->getValutazioneMedia()} / 10
                            </span>
                        </div>
                    </div>

                    <hr class="border-slate-800/80" />

                    <!-- Sezione Trama -->
                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Trama</h2>
                        <p class="text-slate-300 leading-relaxed text-base font-light">
                            {$serie->getTrama()}
                        </p>
                    </div>

                    <!-- Sezione Generi -->
                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Generi</h2>
                        <div class="flex flex-wrap gap-2">
                            {foreach $serie->getGeneri() as $genere}
                                <span
                                    class="bg-indigo-950/40 text-indigo-300 border border-indigo-900/50 px-3.5 py-1 rounded-lg text-sm font-medium">
                                    {$genere}
                                </span>
                            {/foreach}
                        </div>
                    </div>

                </div>

            </div>
            <hr class="border-slate-800/80 my-10" />
            <!-- NUOVA SEZIONE EPISODI -->

            <div class="space-y-6">
                <!-- Intestazione con Selettore Stagioni -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-white">Lista Episodi</h2>
                        <p class="text-sm text-slate-400">Filtra gli episodi per stagione</p>
                    </div>

                    {if $serie->getEpisodi()|count > 0}
                        <!-- Controlli Filtro Stagioni -->
                        <div class="flex items-center gap-2 self-end md:self-auto">
                            <!-- Pulsante Stagione Precedente -->
                            <button id="prevSeasonBtn"
                                class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-750 disabled:opacity-30 disabled:hover:bg-slate-900 disabled:hover:text-slate-400 transition-all duration-200 shadow-md"
                                title="Stagione precedente">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Selettore -->
                            <div class="relative">
                                <select id="seasonSelect"
                                    class="appearance-none bg-slate-900 p-2 border border-slate-800 text-slate-100 text-sm font-semibold rounded-xl pl-4 pr-10 py-2.5 hover:border-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 cursor-pointer transition-all duration-200 shadow-lg">
                                    {for $i=1 to $serie->getNumeroStagioni()}
                                        <option value="{$i}">Stagione {$i}</option>
                                    {/for}
                                </select>

                            </div>

                            <!-- Pulsante Stagione Successiva -->
                            <button id="nextSeasonBtn"
                                class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-750 disabled:opacity-30 disabled:hover:bg-slate-900 disabled:hover:text-slate-400 transition-all duration-200 shadow-md"
                                title="Stagione successiva">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    {/if}


                    {if $serie->getEpisodi()|count > 0}
                        <div class="space-y-3">
                            {foreach $serie->getEpisodi() as $episodio}
                                <div class="episode-card p-4 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-700/60 transition-all duration-300 shadow-sm"
                                    data-season="{$episodio->getNumeroStagione()}">

                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <!-- Badge compatto del codice dell'episodio (es. S01E04) -->
                                            <span
                                                class="px-2.5 py-1 text-xs font-semibold rounded-md bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 tracking-wider">
                                                S{$episodio->getNumeroStagione()|string_format:"%02d"}E{$episodio->getNumeroEpisodio()|string_format:"%02d"}
                                            </span>
                                            <h3 class="text-base font-bold text-white">{$episodio->getTitolo()}</h3>
                                        </div>

                                        <!-- Durata e Voto a destra -->
                                        <div class="flex items-center gap-4 text-sm text-slate-450">
                                            <span class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {$episodio->getDurata()} min
                                            </span>

                                            <span class="flex items-center gap-1 text-amber-500 font-medium">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                {$episodio->getValutazioneMedia()}
                                            </span>
                                        </div>
                                    </div>
                                    {if $episodio->getTrama() !== ""}
                                        <p class="mt-3 text-sm text-slate-400 font-light leading-relaxed">
                                            {$episodio->getTrama()}
                                        </p>
                                    {/if}
                                </div>
                            {/foreach}
                        </div>
                    {else}
                        <div class="p-6 rounded-xl border border-dashed border-slate-800 bg-slate-900/10 text-center">
                            <p class="text-slate-400 text-sm italic">Nessun episodio registrato per questa serie.</p>
                        </div>
                    {/if}
                </div>
                <!-- FINE SEZIONE EPISODI -->


            </div>
        </div>

        {literal}
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const seasonSelect = document.getElementById('seasonSelect');
                    const prevBtn = document.getElementById('prevSeasonBtn');
                    const nextBtn = document.getElementById('nextSeasonBtn');
                    const episodes = document.querySelectorAll('.episode-card');

                    if (!seasonSelect || !prevBtn || !nextBtn) return;

                    function updateView() {
                        const selectedValue = seasonSelect.value;

                        // Mostra o nasconde gli episodi
                        episodes.forEach(episode => {
                            const season = episode.getAttribute('data-season');
                            if (season === selectedValue) {
                                episode.classList.remove('hidden');
                                // Piccola transizione di entrata
                                setTimeout(() => {
                                    episode.classList.remove('opacity-0', 'scale-95');
                                    episode.classList.add('opacity-100', 'scale-100');
                                }, 50);
                            } else {
                                episode.classList.add('hidden', 'opacity-0', 'scale-95');
                                episode.classList.remove('opacity-100', 'scale-100');
                            }
                        });

                        // Ottieni gli indici correnti del dropdown
                        const currentIndex = seasonSelect.selectedIndex;
                        const totalOptions = seasonSelect.options.length;

                        // Disabilita "precedente" se siamo sulla prima stagione
                        prevBtn.disabled = (currentIndex === 0);

                        // Disabilita "successiva" se siamo all'ultima stagione
                nextBtn.disabled = (currentIndex === totalOptions - 1);
            }

            // Gestione del cambio opzione tramite dropdown
            seasonSelect.addEventListener('change', updateView);

            // Gestione click su pulsante precedente
            prevBtn.addEventListener('click', () => {
                if (seasonSelect.selectedIndex > 0) {
                    seasonSelect.selectedIndex--;
                    updateView();
                }
            });

            // Gestione click su pulsante successivo
            nextBtn.addEventListener('click', () => {
                        if (seasonSelect.selectedIndex < seasonSelect.options.length - 1) {
                            seasonSelect.selectedIndex++;
                            updateView();
                        }
                    });

                    // Inizializzazione della vista al caricamento
                    updateView();
                });
            </script>
        {/literal}

{/block}