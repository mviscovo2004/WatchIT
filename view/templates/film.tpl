{*
 * Template Dettaglio Film
 * 
 * Visualizza la scheda informativa completa di un singolo film, comprensiva di locandina,
 * anno, trama, valutazione, regista, attori principali, trailer YouTube e sezione recensioni.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param EFilm $film Il film da visualizzare.
 * @param array $watchlistIds Elenco degli ID dei contenuti già inseriti nelle watchlist dell'utente.
 * @param ERecensione[] $recensioni Le recensioni lasciate dagli utenti per questo film.
 *}
{extends file="main.tpl"}
{block name="title"}{$film->getTitolo()} - WatchIT{/block}

{block name="content"}
    <div class="min-h-screen bg-slate-950 text-slate-100 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">


                {include file="components/cards/locandinaDettagli.tpl" contenuto=$film isLogged=$isLogged watchlistIds=$watchlistIds}



                <div class="md:col-span-3 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">


                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h1
                                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-amber-500 tracking-tight leading-tight pb-2">
                                {$film->getTitolo()}
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

                        {include file="components/chipsDettagli.tpl" contenuto=$film}
                    </div>

                    <hr class="border-slate-800/80" />


                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Trama</h2>
                        <p class="text-slate-300 leading-relaxed text-base font-light">
                            {$film->getTrama()}
                        </p>
                    </div>


                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Generi</h2>
                        <div class="flex flex-wrap gap-2">
                            {foreach $film->getGeneri() as $genere}
                                <span
                                    class="bg-indigo-950/40 text-indigo-300 border border-indigo-900/50 px-3.5 py-1 rounded-lg text-sm font-medium">
                                    {$genere}
                                </span>
                            {/foreach}
                        </div>
                    </div>

                </div>

            </div>


            {if $film->getVideo()|count > 0}
                {include file="components/caroselloVideo.tpl" videos=$film->getVideo()}
            {/if}

            {include file="components/sezioneCast.tpl" partecipazioni=$film->getPartecipazioni()}

            {include file="components/sezioneRecensioni.tpl" recensioni=$recensioni contenutoId=$film->getId()}

            {include file="components/modali/modaleRecensione.tpl" contenuto=$film->getId()}
        </div>

        <script src="{$baseUrl}/view/js/modaleRecensione.js"></script>


{/block}