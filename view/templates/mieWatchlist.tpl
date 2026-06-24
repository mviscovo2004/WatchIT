{*
 * Template Lista Watchlist Personali
 * 
 * Visualizza tutte le watchlist create dall'utente loggato, organizzate in una griglia.
 * Permette anche di aprire il form di creazione per una nuova watchlist e mostra la visibilità (privacy) di ciascuna.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param EWatchlist[] $watchlist Elenco di tutte le watchlist dell'utente.
 *}

{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">


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


                            <div
                                class="relative aspect-video w-full overflow-hidden bg-slate-950 border-b border-slate-800 flex items-center justify-center">
                                {$numContenuti = count($contenuti)}
                                {if $numContenuti == 0}

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
                                {elseif $numContenuti == 1}

                                    <img src="{$contenuti[0]->getLocandina()}" alt="{$lista->getNome()}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 blur-sm opacity-30 absolute inset-0">
                                    <img src="{$contenuti[0]->getLocandina()}" alt="{$lista->getNome()}"
                                        class="h-full object-contain relative z-10 py-2 group-hover:scale-105 transition-all duration-500">
                                {elseif $numContenuti == 2}

                                    <div
                                        class="grid grid-cols-2 w-full h-full absolute inset-0 group-hover:scale-102 transition-all duration-500">
                                        <img src="{$contenuti[0]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover">
                                        <img src="{$contenuti[1]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover border-l border-slate-950">
                                    </div>
                                {elseif $numContenuti == 3}

                                    <div
                                        class="grid grid-cols-2 w-full h-full absolute inset-0 group-hover:scale-102 transition-all duration-500">
                                        <img src="{$contenuti[0]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover">
                                        <div class="grid grid-rows-2 h-full border-l border-slate-950">
                                            <img src="{$contenuti[1]->getLocandina()}" alt="{$lista->getNome()}"
                                                class="w-full h-full object-cover">
                                            <img src="{$contenuti[2]->getLocandina()}" alt="{$lista->getNome()}"
                                                class="w-full h-full object-cover border-t border-slate-950">
                                        </div>
                                    </div>
                                {else}

                                    <div
                                        class="grid grid-cols-2 grid-rows-2 w-full h-full absolute inset-0 group-hover:scale-102 transition-all duration-500">
                                        <img src="{$contenuti[0]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover">
                                        <img src="{$contenuti[1]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover border-l border-slate-950">
                                        <img src="{$contenuti[2]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover border-t border-slate-950">
                                        <img src="{$contenuti[3]->getLocandina()}" alt="{$lista->getNome()}"
                                            class="w-full h-full object-cover border-t border-l border-slate-950">
                                    </div>
                                {/if}


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



                            <div class="px-6 pb-6 pt-0 flex gap-2" onclick="event.stopPropagation();">
                                <a href="index.php?controller=Watchlist&action=mostra&id={$lista->getId()}"
                                    class="flex-1 py-2.5 bg-slate-850 hover:bg-purple-600 text-white rounded-xl text-center text-xs font-bold transition-all duration-300 hover:shadow-lg hover:shadow-purple-650/15">
                                    Visualizza
                                </a>
                                <button type="button"
                                    onclick="openEditModalFromList(event, {$lista->getId()}, '{$lista->getNome()|escape:'javascript'}', '{$lista->getDescrizione()|escape:'javascript'}', '{$lista->getVisibilita()->name}')"
                                    class="px-3.5 py-2.5 bg-slate-900 border border-slate-800 hover:border-purple-500/40 hover:text-purple-400 text-slate-350 rounded-xl text-xs font-bold transition-all cursor-pointer"
                                    title="Modifica Watchlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <a href="index.php?controller=Watchlist&action=elimina&id={$lista->getId()}"
                                    onclick="event.stopPropagation(); return confirm('Vuoi davvero eliminare questa watchlist? Questa azione non può essere annullata.');"
                                    class="px-3.5 py-2.5 bg-red-950/20 border border-red-950/30 hover:bg-red-950/40 hover:border-red-900/50 text-red-400 rounded-xl text-xs font-bold transition-all cursor-pointer"
                                    title="Elimina Watchlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>


                        </div>
                    {/foreach}
                </div>
            {else}

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

    {include file='components/modali/modaleCreaWatchlist.tpl'}

    {include file='components/modali/modaleModificaWatchlist.tpl'}
    <script src="{$baseUrl}/view/js/modaleModificaWatchlist.js"></script>

    <script src="{$baseUrl}/view/js/modaleWatchlist.js"></script>

{/block}