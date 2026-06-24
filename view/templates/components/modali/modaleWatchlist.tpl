{*
 * Modale Watchlist (Asincrono)
 * 
 * Visualizza l'overlay popup che elenca le watchlist dell'utente loggato,
 * consentendogli di salvare o rimuovere il contenuto tramite chiamate AJAX.
 * Include anche lo script JavaScript di gestione del modale.
 * 
 * @package View/Templates/Components/Modali
 * @author Marco Viscovo
 * 
 * @param bool $isLogged Indica se l'utente è autenticato.
 * @param string $baseUrl L'URL di base dell'applicazione per caricare il file JS.
 *}
{if $isLogged}

    <div id="addToWatchlistModal" style="z-index: 99999;"
        class="fixed inset-0 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">

        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl max-w-md w-full relative shadow-2xl space-y-4">

            <button onclick="toggleWatchlistModal(false)"
                class="absolute top-4 right-4 text-slate-400 hover:text-white text-2xl font-bold transition focus:outline-none">&times;</button>

            <div class="space-y-1">
                <h4 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m-9 1V4a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Aggiungi a...
                </h4>
                <p class="text-slate-400 text-xs">Seleziona le watchlist in cui salvare questo contenuto.</p>
            </div>


            <div id="watchlistOptionsContainer" class="space-y-2 max-h-60 overflow-y-auto pr-1 py-1">

            </div>


            <div class="pt-4 border-t border-slate-800/80 flex justify-between items-center gap-2">
                <a href="index.php?controller=Watchlist&action=mostraTutteWatchlist"
                    class="text-xs text-purple-400 hover:text-purple-300 font-semibold hover:underline">
                    Gestisci le tue watchlist
                </a>
                <button onclick="toggleWatchlistModal(false)"
                    class="px-5 py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-bold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/10">
                    Chiudi
                </button>
            </div>
        </div>
    </div>

    <script src="{$baseUrl}/view/js/modaleWatchlist.js"></script>
{/if}