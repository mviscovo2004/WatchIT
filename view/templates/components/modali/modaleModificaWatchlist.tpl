<div id="editWatchlistModal" style="z-index: 99999;"
    class="fixed inset-0 hidden bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl relative space-y-6">

        <button onclick="toggleEditWatchlistModal(false)"
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
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifica Watchlist
            </h3>
            <p class="text-slate-400 text-xs">Aggiorna le informazioni e la privacy della tua watchlist.</p>
        </div>
        <form
            action="index.php?controller=Watchlist&action=modifica&id={if isset($watchlist) && !is_array($watchlist)}{$watchlist->getId()}{/if}"
            method="POST" class="space-y-4">
            <input type="hidden" name="redirect_to" id="edit_redirect_to"
                value="{if isset($watchlist) && !is_array($watchlist)}dettaglio{else}lista{/if}">

            <div class="space-y-1">
                <label for="edit_nome" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nome
                    Watchlist</label>
                <input type="text" name="nome" id="edit_nome"
                    value="{if isset($watchlist) && !is_array($watchlist)}{$watchlist->getNome()|escape}{/if}" required
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-purple-500 text-sm transition-colors"
                    placeholder="Es. Film da Vedere d'Estate">
            </div>
            <div class="space-y-1">
                <label for="edit_descrizione"
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider">Descrizione</label>
                <textarea name="descrizione" id="edit_descrizione" rows="3"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white placeholder-slate-600 focus:outline-none focus:border-purple-500 text-sm transition-colors"
                    placeholder="Una breve descrizione della tua lista...">{if isset($watchlist) && !is_array($watchlist)}{$watchlist->getDescrizione()|escape}{/if}</textarea>
            </div>
            <div class="space-y-1">
                <label for="edit_visibilita"
                    class="text-xs font-bold text-slate-400 uppercase tracking-wider">Privacy</label>
                <select name="visibilita" id="edit_visibilita"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500 text-sm transition-colors">
                    <option value="pubblico" class="bg-slate-900"
                        {if isset($watchlist) && !is_array($watchlist) && $watchlist->getVisibilita()->name === 'pubblico'}selected{/if}>
                        Pubblica (Visibile a tutti)</option>
                    <option value="privato" class="bg-slate-900"
                        {if isset($watchlist) && !is_array($watchlist) && $watchlist->getVisibilita()->name === 'privato'}selected{/if}>
                        Privata (Solo per te)</option>
                    <option value="solo_amici" class="bg-slate-900"
                        {if isset($watchlist) && !is_array($watchlist) && $watchlist->getVisibilita()->name === 'solo_amici'}selected{/if}>
                        Solo Amici (Visibile ai tuoi amici)</option>
                </select>
            </div>
            <div class="pt-4 border-t border-slate-800/60 flex justify-end gap-3">
                <button type="button" onclick="toggleEditWatchlistModal(false)"
                    class="px-4 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 rounded-xl text-sm font-semibold transition-colors">
                    Annulla
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/20">
                    Salva Modifiche
                </button>
            </div>
        </form>
    </div>
</div>