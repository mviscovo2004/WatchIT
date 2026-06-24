{*
 * Vista Importazione TMDB
 * 
 * Mostra il form per la ricerca e l'importazione automatica di Film e Serie TV tramite le API esterne di TMDB,
 * ed elenca gli ultimi contenuti importati con successo.
 * Estende il layout `admin/mainAdmin.tpl`.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 * 
 * @param EFilm[] $ultimiFilm Elenco degli ultimi film importati.
 * @param ESerie[] $ultimeSerie Elenco delle ultime serie TV importate.
 * @param string|null $importError Messaggio di errore in caso di fallimento della chiamata API.
 * @param string|null $importSuccess Messaggio di successo a importazione avvenuta.
 *}
{extends file="admin/mainAdmin.tpl"}

{block name="content"}

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <a href="?controller=Admin&action=listaContenuti"
            class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 hover:border-purple-500 hover:text-purple-400 text-slate-300 text-sm font-semibold transition-all duration-200 flex items-center gap-1.5 w-fit shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Torna alla Lista
        </a>
        <h1 class="text-white font-bold text-2xl md:mr-auto md:ml-4">Importazione da TMDB</h1>
    </div>


    <div class="mb-6">
        {if isset($importError) && $importError}
            {include file="components/alert.tpl" message=$importError type="error"}
        {/if}
        {if isset($importSuccess) && $importSuccess}
            {include file="components/alert.tpl" message=$importSuccess type="success"}
        {/if}
    </div>


    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 mb-8">
        <h2 class="text-white font-semibold text-lg mb-3">Cerca Film o Serie TV</h2>
        <p class="text-slate-400 text-sm mb-4">Inserisci il titolo del contenuto che desideri importare. Verrà eseguita una
            ricerca su TMDB e il primo risultato corrispondente sarà aggiunto automaticamente al catalogo comprensivo di
            dettagli, generi, trailer, cast e (per le serie TV) di tutti gli episodi.</p>

        <form action="index.php?controller=Admin&action=importaDaTMDB" method="post"
            class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="titolo" placeholder="Inserisci il titolo da cercare..." required
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-950/85 border border-slate-800/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" />
            </div>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-md shadow-purple-900/20 whitespace-nowrap">
                Importa Contenuto
            </button>
        </form>
    </div>


    {if count($ultimiFilm) > 0 || count($ultimeSerie) > 0}
        <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 p-6">
            <h2 class="text-xl font-bold text-white mb-4">Ultimi Contenuti Inseriti</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <h3 class="text-sm font-semibold text-purple-400 mb-3 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        Film Recenti
                    </h3>
                    {if count($ultimiFilm) > 0}
                        <div class="space-y-2.5">
                            {foreach $ultimiFilm as $film}
                                <div
                                    class="flex items-center justify-between text-sm p-3.5 bg-slate-950/60 rounded-xl border border-slate-800/60 hover:border-slate-700 transition-colors">
                                    <a href="index.php?controller=Contenuto&action=mostraFilm&id={$film->getId()}"
                                        class="text-slate-300 hover:text-purple-400 font-medium transition-colors">{$film->getTitolo()}</a>
                                    <span
                                        class="text-slate-500 text-xs font-semibold bg-slate-900 px-2 py-1 rounded-lg">{$film->getAnno()}</span>
                                </div>
                            {/foreach}
                        </div>
                    {else}
                        <p class="text-xs text-slate-500 italic">Nessun film caricato di recente.</p>
                    {/if}
                </div>


                <div>
                    <h3 class="text-sm font-semibold text-amber-400 mb-3 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Serie TV Recenti
                    </h3>
                    {if count($ultimeSerie) > 0}
                        <div class="space-y-2.5">
                            {foreach $ultimeSerie as $serie}
                                <div
                                    class="flex items-center justify-between text-sm p-3.5 bg-slate-950/60 rounded-xl border border-slate-800/60 hover:border-slate-700 transition-colors">
                                    <a href="index.php?controller=Contenuto&action=mostraSerie&id={$serie->getId()}"
                                        class="text-slate-300 hover:text-amber-400 font-medium transition-colors">{$serie->getTitolo()}</a>
                                    <span
                                        class="text-slate-500 text-xs font-semibold bg-slate-900 px-2 py-1 rounded-lg">{$serie->getAnno()}</span>
                                </div>
                            {/foreach}
                        </div>
                    {else}
                        <p class="text-xs text-slate-500 italic">Nessuna serie TV caricata di recente.</p>
                    {/if}
                </div>
            </div>
        </div>
    {/if}
{/block}