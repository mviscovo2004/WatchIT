{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

        <!-- Intestazione Pagina -->
        <div class="p-8  flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3">
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight flex items-center gap-3">
                    <span class="w-2 h-8 bg-purple-500 rounded-full"></span>
                    Le mie Watchlist
                </h1>
                <p class="text-slate-400 text-sm sm:text-base max-w-2xl leading-relaxed">
                    Gestisci e organizza i tuoi film e serie TV preferiti. Qui trovi tutte le liste che hai creato, sia
                    pubbliche che private.
                </p>
            </div>

            <!-- Bottone per creare una watchlist -->
            <button onclick="toggleCreateWatchlistModal(true)"
                class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Nuova Watchlist
            </button>
        </div>

        <!-- Sezione Watchlists -->
        <div>
            {if $watchlist && count($watchlist) > 0}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {foreach $watchlist as $lista}
                        {assign var="contenuti" value=$lista->getContenutiSalvati()}
                        {assign var="primoContenuto" value=null}
                        {if count($contenuti) > 0}
                            {assign var="primoContenuto" value=$contenuti[0]}
                        {/if}

                        <div onclick="window.location.href='index.php?controller=Watchlist&action=mostra&id={$lista->getId()}'"
                            class="group rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-purple-500/40 hover:bg-slate-900 transition-all duration-300 cursor-pointer shadow-xl overflow-hidden flex flex-col justify-between h-full">

                            <!-- Immagine di Copertina / Gradiente -->
                            <div
                                class="relative aspect-video w-full overflow-hidden bg-slate-950 border-b border-slate-800 flex items-center justify-center">
                                {if $primoContenuto}
                                    <img src="{$primoContenuto->getLocandina()}" alt="{$lista->getNome()}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 blur-sm opacity-30 absolute inset-0">
                                    <img src="{$primoContenuto->getLocandina()}" alt="{$lista->getNome()}"
                                        class="h-full object-contain relative z-10 py-2 group-hover:scale-105 transition-all duration-500">
                                {else}
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 via-slate-950 to-slate-900"></div>
                                    <div class="relative z-10 flex flex-col items-center justify-center text-slate-500 space-y-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 text-slate-700 group-hover:text-purple-500/50 transition-colors duration-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wider text-slate-600 group-hover:text-slate-500 transition-colors">Lista
                                            Vuota</span>
                                    </div>
                                {/if}

                                <!-- Badge Visibilità -->
                                <div class="absolute top-4 right-4 z-20">
                                    {if $lista->getVisibilita()->name === 'pubblico'}
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Pubblica
                                        </span>
                                    {elseif $lista->getVisibilita()->name === 'privato'}
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-full bg-slate-800 text-slate-400 border border-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Privata
                                        </span>
                                    {else}
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            Amici
                                        </span>
                                    {/if}
                                </div>
                            </div>

                            <!-- Contenuto Testuale -->
                            <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <h3
                                        class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors duration-250 line-clamp-1">
                                        {$lista->getNome()}
                                    </h3>
                                    <p class="text-slate-400 text-sm leading-relaxed line-clamp-2">
                                        {$lista->getDescrizione()|default:"Nessuna descrizione fornita per questa watchlist."}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-800/60 text-xs">
                                    <span class="text-slate-500 font-semibold">
                                        Elementi: <span class="text-purple-400 font-black">{count($contenuti)}</span>
                                    </span>
                                    <span class="text-slate-500">
                                        Da: <span class="text-slate-350 font-bold">{$lista->getUtente()->getUsername()}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Bottone d'azione -->
                            <div class="px-6 pb-6 pt-0">
                                <div
                                    class="w-full py-2.5 bg-slate-800 group-hover:bg-purple-600 text-white rounded-xl text-center text-xs font-bold transition-all duration-300 group-hover:shadow-lg group-hover:shadow-purple-600/10">
                                    Visualizza Watchlist
                                </div>
                            </div>

                        </div>
                    {/foreach}
                </div>
            {else}
                <!-- Stato Vuoto -->
                <div
                    class="text-center py-16 bg-slate-900/40 border border-dashed border-slate-850 rounded-2xl space-y-4 max-w-xl mx-auto">
                    <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-white">Non hai ancora creato nessuna watchlist</h3>
                        <p class="text-slate-500 text-xs sm:text-sm max-w-sm mx-auto leading-relaxed">
                            Crea una watchlist per tenere traccia dei film e delle serie TV che desideri vedere.
                        </p>
                    </div>
                    <div class="pt-4">
                        <a href="index.php"
                            class="inline-flex px-5 py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-bold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/15">
                            Inizia a Esplorare
                        </a>
                    </div>
                </div>
            {/if}
        </div>

    </div>
    <!-- Modale per Creazione Watchlist -->
    <div id="createWatchlistModal"
        class="fixed inset-0 z-[9999] hidden bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl relative space-y-6">
            <!-- Pulsante Chiusura -->
            <button onclick="toggleCreateWatchlistModal(false)"
                class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m-9 1V4a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Nuova Watchlist
                </h3>
                <p class="text-slate-400 text-xs">Crea una nuova raccolta personalizzata per organizzare i tuoi film e
                    serie TV.</p>
            </div>
            <form action="index.php?controller=Watchlist&action=crea" method="POST" class="space-y-4">
                <div class="space-y-1">
                    <label for="nome" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nome
                        Watchlist</label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-purple-500 text-sm transition-colors"
                        placeholder="Es. Film da Vedere d'Estate">
                </div>
                <div class="space-y-1">
                    <label for="descrizione"
                        class="text-xs font-bold text-slate-400 uppercase tracking-wider">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="3"
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-purple-500 text-sm transition-colors"
                        placeholder="Una breve descrizione della tua lista..."></textarea>
                </div>
                <div class="space-y-1">
                    <label for="visibilita"
                        class="text-xs font-bold text-slate-400 uppercase tracking-wider">Privacy</label>
                    <select name="visibilita" id="visibilita"
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500 text-sm transition-colors">
                        <option value="pubblico" class="bg-slate-900">Pubblica (Visibile a tutti)</option>
                        <option value="privato" class="bg-slate-900" selected>Privata (Solo per te)</option>
                        <option value="solo_amici" class="bg-slate-900">Solo Amici (Visibile ai tuoi amici)</option>
                    </select>
                </div>
                <div class="pt-4 border-t border-slate-800/60 flex justify-end gap-3">
                    <button type="button" onclick="toggleCreateWatchlistModal(false)"
                        class="px-4 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 rounded-xl text-sm font-semibold transition-colors">
                        Annulla
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/20">
                        Crea Lista
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        {literal}
            function toggleCreateWatchlistModal(show) {
                const modal = document.getElementById('createWatchlistModal');
                if (show) {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        {/literal}
    </script>
{/block}