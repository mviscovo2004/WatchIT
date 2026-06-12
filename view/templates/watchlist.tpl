{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

        <!-- Intestazione Watchlist -->
        <div class="p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3 flex-1">
                <div class="flex items-center gap-3">
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded bg-purple-500/10 text-purple-400 border border-purple-500/20 tracking-wider uppercase">
                        Watchlist {if $watchlist->getVisibilita()->name === 'pubblico'}Pubblica{else}Privata{/if}
                    </span>
                    <span class="text-xs text-slate-500">
                        Creata da <a
                            href="index.php?controller=Utente&action=mostraProfilo&id={$watchlist->getUtente()->getId()}"
                            class="font-semibold text-slate-450 hover:text-purple-400 hover:underline">{$watchlist->getUtente()->getUsername()}</a>
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    {$watchlist->getNome()}
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    {$watchlist->getDescrizione()}
                </p>
            </div>
            <div class="shrink-0 bg-slate-950/50 border border-slate-850 p-4 rounded-xl text-center min-w-[120px]">
                <span class="text-sm font-semibold text-slate-400 block mb-1">Contenuti Salvati</span>
                <span class="text-3xl font-black text-purple-400">{count($contenuti)}</span>
            </div>
        </div>

        <!-- Griglia dei Contenuti (Film/Serie) all'interno della Watchlist -->
        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                Contenuti in questa Watchlist
            </h3>

            {if $contenuti && count($contenuti) > 0}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {foreach from=$contenuti item=c}
                        {include file="components/cards/cardContenuto.tpl" contenuto=$c}

                        <!-- Bottone "Rimuovi" visibile solo al proprietario della watchlist o all'admin -->
                        {if $isLogged && (Session::get('user_id') === $watchlist->getUtente()->getId() || $ruolo === 'ADMIN')}
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
{/block}