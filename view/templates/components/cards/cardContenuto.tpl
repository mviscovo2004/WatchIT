{assign var="isSerie" value=$contenuto instanceof ESerie}
{assign var="actionToShow" value="mostraFilm"}
{if $isSerie}
    {assign var="actionToShow" value="mostraSerie"}
{/if}

<div onclick="window.location.href='index.php?controller=Contenuto&action={$actionToShow}&id={$contenuto->getId()}'"
    class="group cursor-pointer">
    <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
        <img src="{$contenuto->getLocandina()}" alt="{$contenuto->getTitolo()}"
            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">

        {if $isLogged}
            <a href="#"
                onclick="event.preventDefault(); event.stopPropagation(); openAddToWatchlistModal({$contenuto->getId()})"
                data-watchlist-content-id="{$contenuto->getId()}"
                class="absolute top-3 right-3 p-2 rounded-full bg-slate-950/80 border border-slate-700 font-bold text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-200 backdrop-blur-sm opacity-100 md:opacity-0 md:group-hover:opacity-100 z-20 shadow-md transform hover:scale-110"
                title="{if $watchlistIds && in_array($contenuto->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                {if $watchlistIds && in_array($contenuto->getId(), $watchlistIds)}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                {else}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                {/if}
            </a>
        {/if}

        <div
            class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
            <span class="text-xs font-bold text-purple-500">
                {if $contenuto->getGeneri() && count($contenuto->getGeneri()) > 0}
                    Genere: {$contenuto->getGeneri()|join:", "}
                {else}
                    Genere: Non specificato
                {/if}
            </span>
        </div>
    </div>

    <h4 class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
        {$contenuto->getTitolo()}
    </h4>

    <div class="flex items-center justify-between mt-1">
        <p class="text-xs text-slate-500 font-semibold">Anno: {$contenuto->getAnno()}</p>
    </div>
    <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-amber-500">★ {$contenuto->getValutazioneMedia()|string_format:"%.1f"}</span>
    </div>
</div>