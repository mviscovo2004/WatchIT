{extends file="main.tpl"}
{block name="content"}


    {if $filmPopolari && count($filmPopolari) > 0}
        {assign var="hero" value=$filmPopolari[0]}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div
                class="relative rounded-2xl overflow-hidden aspect-[21/9] bg-slate-900 border border-slate-800/80 shadow-2xl flex items-end">
                <div class="absolute inset-0 bg-cover bg-center opacity-40 transition-transform duration-[10s] hover:scale-105"
                    style="background-image: url('{$hero->getLocandina()}');">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

                <div class="relative p-6 sm:p-10 md:p-12 max-w-xl z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-2.5 py-1 text-xs font-bold bg-purple-600 text-white rounded uppercase tracking-wider">In
                            Evidenza</span>
                        <span class="text-sm font-medium text-slate-300">Il film più votato della community</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4">
                        {$hero->getTitolo()}
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base mb-6 line-clamp-3 leading-relaxed">
                        {$hero->getTrama()}
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="index.php?controller=Contenuto&action=mostraFilm&id={$hero->getId()}"
                            class="px-6 py-3 rounded-xl bg-white text-slate-950 font-bold hover:bg-slate-200 transition-all duration-200 shadow-lg transform hover:-translate-y-0.5">
                            Guarda Ora
                        </a>
                        {if $isLogged}
                            <a href="#" onclick="event.preventDefault(); openAddToWatchlistModal({$hero->getId()})"
                                data-watchlist-content-id="{$hero->getId()}"
                                class="watchlist-btn-text px-6 py-3 rounded-xl bg-slate-800/80 border border-slate-700 font-bold text-white hover:bg-slate-700 transition-all duration-200 backdrop-blur-sm"
                                title="{if $watchlistIds && in_array($hero->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                                {if $watchlistIds && in_array($hero->getId(), $watchlistIds)}
                                    ✓ In Watchlist
                                {else}
                                    + Watchlist
                                {/if}
                            </a>

                        {else}
                            <a href="index.php?controller=Utente&action=login"
                                class="px-6 py-3 rounded-xl bg-slate-800/80 border border-slate-700 font-bold text-white hover:bg-slate-700 transition-all duration-200 backdrop-blur-sm">
                                Accedi...
                            </a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {/if}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">


        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                Film Popolari
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {foreach from=$filmPopolari item=film name=film_loop}
                    {include file="components/cards/cardContenuto.tpl" contenuto=$film}
                {foreachelse}
                    <p class="text-slate-400 text-sm col-span-full">Nessun film disponibile nel database.</p>
                {/foreach}
            </div>
        </div>


        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                Serie TV Popolari
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {foreach from=$seriePopolari item=serie name=serie_loop}
                    {include file="components/cards/cardContenuto.tpl" contenuto=$serie}
                {foreachelse}
                    <p class="text-slate-400 text-sm col-span-full">Nessuna serie TV disponibile nel database.</p>
                {/foreach}
            </div>

        </div>

        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                Ultime Recensioni della Community
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {foreach from=$recensioni item=recensione}
                    {include file="components/cards/cardRecensioneGlobale.tpl" recensione=$recensione colorTheme="purple"}
                {foreachelse}
                    <p class="text-slate-400 text-sm col-span-full">Nessuna recensione disponibile nel database.</p>
                {/foreach}
            </div>
        </div>

    </div>

{/block}