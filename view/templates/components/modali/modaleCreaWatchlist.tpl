{*
 * Modale Creazione Watchlist
 * 
 * Visualizza il modulo popup per consentire a un utente loggato di creare
 * una nuova watchlist definendone nome, descrizione e livello di privacy.
 * 
 * @package View/Templates/Components/Modali
 * @author Marco Viscovo
 *}
<div id="createWatchlistModal"
    class="fixed inset-0 z-[9999] hidden bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl relative space-y-6">

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