{extends file="main.tpl"}
{block name="content"}

    <!-- 1. HERO: IL FILM PIÙ POPOLARE IN ASSOLUTO -->
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
                            <a href="index.php?controller=Watchlist&action=aggiungi&id={$hero->getId()}"
                                class="px-6 py-3 rounded-xl bg-slate-800/80 border border-slate-700 font-bold text-white hover:bg-slate-700 transition-all duration-200 backdrop-blur-sm">
                                + Watchlist
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

        <!-- 2. SEZIONE FILM POPOLARI (TOP 5) -->
        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                Film Popolari
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {foreach from=$filmPopolari item=film name=film_loop}
                    <div onclick="window.location.href='index.php?controller=Contenuto&action=mostraFilm&id={$film->getId()}'"
                        class="group cursor-pointer">
                        <div
                            class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                            <img src="{$film->getLocandina()}" alt="{$film->getTitolo()}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                            {if $isLogged}
                                <a href="index.php?controller=Watchlist&action=aggiungi&id={$film->getId()}"
                                    class="absolute top-3 right-3 p-2 rounded-full bg-slate-950/80 border border-slate-700 font-bold text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100 z-20 shadow-md transform hover:scale-110"
                                    title="{if $watchlistIds && in_array($film->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                                    {if $watchlistIds && in_array($film->getId(), $watchlistIds)}
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
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                                <span class="text-xs font-bold text-purple-500">
                                    {if $film->getGeneri() && count($film->getGeneri()) > 0}
                                        Genere: {$film->getGeneri()|join:", "}
                                    {else}
                                        Genere: Non specificato
                                    {/if}
                                </span>

                            </div>
                        </div>
                        <h4
                            class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
                            {$film->getTitolo()}
                        </h4>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs text-slate-500 font-semibold">Anno: {$film->getAnno()}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-500">★
                                {$film->getValutazioneMedia()|string_format:"%.1f"}</span>
                        </div>
                    </div>
                {foreachelse}
                    <p class="text-slate-400 text-sm col-span-full">Nessun film disponibile nel database.</p>
                {/foreach}
            </div>
        </div>

        <!-- 3. SEZIONE SERIE TV POPOLARI (TOP 5) -->
        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">
                <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                Serie TV Popolari
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {foreach from=$seriePopolari item=serie name=serie_loop}
                    <div onclick="window.location.href='index.php?controller=Contenuto&action=mostraSerie&id={$serie->getId()}'"
                        class="group cursor-pointer">
                        <div
                            class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                            <img src="{$serie->getLocandina()}" alt="{$serie->getTitolo()}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                            {if $isLogged}
                                <a href="index.php?controller=Watchlist&action=aggiungi&id={$serie->getId()}"
                                    class="absolute top-3 right-3 p-2 rounded-full bg-slate-950/80 border border-slate-700 font-bold text-white hover:bg-purple-600 hover:border-indigo-500 transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100 z-20 shadow-md transform hover:scale-110"
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
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                                <span class="text-xs font-bold text-purple-500">
                                    {if $serie->getGeneri() && count($serie->getGeneri()) > 0}
                                        Genere: {$serie->getGeneri()|join:", "}
                                    {else}
                                        Genere: Non specificato
                                    {/if}
                                </span>

                            </div>
                        </div>
                        <h4
                            class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
                            {$serie->getTitolo()}
                        </h4>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs text-slate-500 font-semibold">Anno: {$serie->getAnno()}</p>

                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-amber-500">★
                                {$serie->getValutazioneMedia()|string_format:"%.1f"}</span>
                        </div>
                    </div>
                {foreachelse}
                    <p class="text-slate-400 text-sm col-span-full">Nessuna serie TV disponibile nel database.</p>
                {/foreach}
            </div>

        </div>
        <div>
            <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2 tracking-tight">Ultime recensioni
            </h3>
            {foreach from=$ultimeRecensioni item=recensione}
                <div class="group cursor-pointer">
                    <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                        <img src="{$recensione->getContenuto()->getLocandina()}"
                            alt="{$recensione->getContenuto()->getTitolo()}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                    </div>
                    <h4 class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
                        {$recensione->getContenuto()->getTitolo()}
                    </h4>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xs text-slate-500 font-semibold">Anno: {$recensione->getContenuto()->getAnno()}</p>

                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-500">★
                            {$recensione->getContenuto()->getValutazioneMedia()|string_format:"%.1f"}</span>
                    </div>
                </div>
            {foreachelse}
                <p class="text-slate-400 text-sm col-span-full">Nessuna recensione disponibile nel database.</p>
            {/foreach}
        </div>
    </div>

{/block}