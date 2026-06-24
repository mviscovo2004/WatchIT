{*
 * Componente Locandina Dettagli
 * 
 * Mostra l'immagine di locandina all'interno della pagina di dettaglio del contenuto (Film/Serie),
 * con il pulsante in overlay per aggiungere o rimuovere il contenuto dalle watchlist in modo asincrono.
 * 
 * @package View/Templates/Components/Cards
 * @author Marco Viscovo
 * 
 * @param EContenuto $contenuto Il film o la serie TV corrente.
 * @param bool $isLogged Indica se l'utente è autenticato.
 * @param array|null $watchlistIds Array degli ID dei contenuti già salvati nelle watchlist dell'utente.
 *}
<div class="md:col-span-1 flex flex-col items-center md:items-start">
    <div
        class="group relative w-64 h-96 sm:w-72 sm:h-[26rem] md:w-full md:h-[28rem] rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 shadow-xl transition-all duration-300 hover:shadow-indigo-500/10">
        <img src="{$contenuto->getLocandina()}" alt="{$contenuto->getTitolo()}"
            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-550 ease-out">

        {if $isLogged}
            <a href="#" onclick="event.preventDefault(); openAddToWatchlistModal({$contenuto->getId()})"
                data-watchlist-content-id="{$contenuto->getId()}"
                class="absolute top-4 right-4 p-3 rounded-full bg-slate-950/80 border border-slate-800 font-bold text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-350 backdrop-blur-md opacity-100 md:opacity-0 md:group-hover:opacity-100 z-20 shadow-lg transform hover:scale-110"
                title="{if $watchlistIds && in_array($contenuto->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                {if $watchlistIds && in_array($contenuto->getId(), $watchlistIds)}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                {else}

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                {/if}
            </a>
        {/if}
    </div>
</div>