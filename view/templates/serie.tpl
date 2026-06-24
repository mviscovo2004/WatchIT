{*
 * Template Dettaglio Serie TV
 * 
 * Visualizza la scheda informativa di una serie TV, con locandina, anno, trama,
 * valutazione media, creatori, cast principale, trailer, stato della serie (in corso/conclusa),
 * elenco degli episodi suddivisi per stagioni e sezione recensioni.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param ESerie $serie La serie TV da visualizzare.
 * @param array $watchlistIds Elenco degli ID dei contenuti già inseriti nelle watchlist dell'utente.
 * @param ERecensione[] $recensioni Le recensioni lasciate dagli utenti per questa serie.
 *}
{extends file="main.tpl"}
{block name="title"}{$serie->getTitolo()} - WatchIT{/block}

{block name="content"}
    <div class="min-h-screen bg-slate-950 text-slate-100 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-6xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {include file="components/cards/locandinaDettagli.tpl" contenuto=$serie isLogged=$isLogged watchlistIds=$watchlistIds}


                <div class="md:col-span-3 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">


                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h1
                                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-amber-500 tracking-tight leading-tight pb-2">
                                {$serie->getTitolo()}
                            </h1>



                            {if $isLogged}
                                <a onclick="toggleReviewModal(true)"
                                    class="shrink-0 inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/20 text-sm hover:scale-105 active:scale-95 self-start sm:self-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Valuta
                                </a>
                            {/if}
                        </div>

                        {include file="components/chipsDettagli.tpl" contenuto=$serie}
                    </div>

                    <hr class="border-slate-800/80" />


                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Trama</h2>
                        <p class="text-slate-300 leading-relaxed text-base font-light">
                            {$serie->getTrama()}
                        </p>
                    </div>


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



            <div class="mt-12 space-y-6">

                <div class="border-b border-slate-800 pb-3 mb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-white">Lista Episodi</h2>
                </div>

                {if $serie->getEpisodi()|count > 0}

                    <div class="flex items-center justify-start gap-2  rounded-2xl max-w-xs mb-6">

                        <button id="prevSeasonBtn"
                            class="p-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-850 hover:border-slate-700 disabled:opacity-30 disabled:hover:bg-slate-950 disabled:hover:text-slate-400 transition-all duration-200 shadow-sm"
                            title="Stagione precedente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>


                        <div class="relative flex-1">
                            <select id="seasonSelect"
                                class="w-full appearance-none bg-slate-950 border border-slate-800 text-slate-105 text-sm font-semibold rounded-xl pl-3 pr-8 py-2 hover:border-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 cursor-pointer transition-all duration-200">
                                {for $i=1 to $serie->getNumeroStagioni()}
                                    <option value="{$i}">Stagione {$i}</option>
                                {/for}
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>


                        <button id="nextSeasonBtn"
                            class="p-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-850 hover:border-slate-700 disabled:opacity-30 disabled:hover:bg-slate-950 disabled:hover:text-slate-400 transition-all duration-200 shadow-sm"
                            title="Stagione successiva">
                            <svg xmlns="http://www.w3.org/2050/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>


                    <div class="space-y-3">

                        {foreach $serie->getEpisodi() as $episodio}
                            <div onclick="window.location.href='index.php?controller=Contenuto&action=mostraEpisodio&serie={$serie->getId()}&id={$episodio->getId()}'"
                                class="episode-card p-4 rounded-xl bg-slate-900/40 border border-slate-800  hover:border-slate-600 transition-all duration-300 shadow-sm cursor-pointer"
                                data-season="{$episodio->getNumeroStagione()}">

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">

                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-md bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 tracking-wider">
                                            S{$episodio->getNumeroStagione()|string_format:"%02d"}E{$episodio->getNumeroEpisodio()|string_format:"%02d"}
                                        </span>
                                        <h3 class="text-base font-bold text-white">{$episodio->getTitolo()}</h3>
                                    </div>


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


            {if $serie->getVideo()|count > 0}
                {include file="components/caroselloVideo.tpl" videos=$serie->getVideo()}*
            {/if}

            {include file="components/sezioneCast.tpl" partecipazioni=$serie->getPartecipazioni()}


            {include file="components/sezioneRecensioni.tpl" recensioni=$recensioni contenutoId=$serie->getId()}
        </div>



        {include file="components/modali/modaleRecensione.tpl" contenuto=$serie->getId()}

        <script src="{$baseUrl}/view/js/modaleRecensione.js"></script>
        <script src="{$baseUrl}/view/js/gestioneStagioni.js"></script>

{/block}