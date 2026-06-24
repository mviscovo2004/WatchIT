{*
 * Template Dettaglio Watchlist
 * 
 * Mostra i dettagli di una singola watchlist, inclusi il titolo, la descrizione,
 * il livello di privacy, il proprietario e la griglia con tutti i contenuti (film/serie)
 * che l'utente ha salvato al suo interno.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param EWatchlist $watchlist La watchlist da visualizzare.
 * @param EContenuto[] $contenuti I contenuti multimediali salvati nella watchlist.
 *}
{extends file="main.tpl"}
{block name="title"}{$watchlist->getNome()|escape} - WatchIT{/block}

{block name="content"}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">


        <div class="p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3 flex-1">
                <div class="flex items-center gap-3">
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded bg-purple-500/10 text-purple-400 border border-purple-500/20 tracking-wider uppercase">
                        Watchlist
                        {if $watchlist->getVisibilita()->name === 'pubblico'}Pubblica
                        {else if $watchlist->getVisibilita()->name === 'solo_amici'}Solo
                        Amici{else}Privata
                        {/if}
                    </span>
                    <span class="text-xs text-slate-500">
                        Creata da <a
                            href="index.php?controller=Utente&action=mostraProfilo&id={$watchlist->getUtente()->getId()}"
                            class="font-semibold text-slate-450 hover:text-purple-400 hover:underline">{$watchlist->getUtente()->getUsername()}</a>
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    {$watchlist->getNome()|escape}
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    {$watchlist->getDescrizione()|escape}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 shrink-0 w-full md:w-auto">
                <div
                    class="bg-slate-950/50 border border-slate-850 p-4 rounded-xl text-center min-w-[120px] w-full sm:w-auto">
                    <span class="text-sm font-semibold text-slate-400 block mb-1">Contenuti Salvati</span>
                    <span class="text-3xl font-black text-purple-400">{count($contenuti)}</span>
                </div>

                {if $isLogged && ($currentUser->getId() === $watchlist->getUtente()->getId())}
                    <div class="flex flex-row sm:flex-col gap-2 w-full sm:w-auto">


                        <button
                            onclick="openEditModalFromList(event, {$watchlist->getId()}, '{$watchlist->getNome()|escape:'javascript'}', '{$watchlist->getDescrizione()|escape:'javascript'}', '{$watchlist->getVisibilita()->name}')"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-850 hover:bg-slate-800 text-slate-200 border border-slate-750 hover:border-slate-700 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifica
                        </button>

                        <a href="index.php?controller=Watchlist&action=elimina&id={$watchlist->getId()}"
                            onclick="return confirm('Vuoi davvero eliminare questa watchlist? Questa azione non può essere annullata.');"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-950/20 hover:bg-red-950/40 text-red-400 border border-red-900/30 hover:border-red-900/50 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Elimina
                        </a>
                    </div>
                {/if}
            </div>
        </div>



        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                Contenuti in questa Watchlist
            </h3>

            {if $contenuti && count($contenuti) > 0}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {foreach from=$contenuti item=c}
                        <div class="flex flex-col h-full justify-between">
                            {include file="components/cards/cardContenuto.tpl" contenuto=$c}


                            {if $isLogged && (Session::get('user_id') === $watchlist->getUtente()->getId() )}
                                <div class="mt-3">
                                    <a href="index.php?controller=Watchlist&action=rimuovi&id={$c->getId()}&idWatchlist={$watchlist->getId()}"
                                        onclick="return confirm('Vuoi davvero rimuovere questo contenuto dalla watchlist?');"
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-red-500/30 text-red-500 hover:bg-red-500/10 hover:border-red-500/50 text-xs font-bold transition-all duration-200 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Rimuovi
                                    </a>
                                </div>
                            {/if}
                        </div>
                    {/foreach}
                </div>
            {else}
                <div class="text-center py-12 bg-slate-900/40 border border-dashed border-slate-800 rounded-2xl col-span-full">
                    <p class="text-slate-500 text-sm italic">Questa watchlist è vuota. Inizia ad aggiungere film o serie TV!</p>
                </div>
            {/if}
        </div>
    </div>

    {if $isLogged && ($currentUser->getId() === $watchlist->getUtente()->getId())}
        {include file="components/modali/modaleModificaWatchlist.tpl"}
        <script src="{$baseUrl}/view/js/modaleModificaWatchlist.js"></script>
    {/if}
{/block}