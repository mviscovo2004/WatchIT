
<div id="modalModificaContenuto"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-all duration-300">
    <div
        class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300">

        <button onclick="closeModal('modalModificaContenuto')"
            class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>


        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifica Contenuto
        </h2>


        <div id="editLoader" class="flex items-center justify-center gap-3 text-purple-400 text-sm py-8">
            <svg class="animate-spin h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>Caricamento dettagli contenuto in corso...</span>
        </div>


        <form id="formModificaContenuto" action="index.php?controller=Admin&action=modificaContenuto" method="post"
            class="space-y-4 hidden">

            <input type="hidden" id="edit-id" name="id" value="" />
            <input type="hidden" id="edit-tipo-hidden" name="tipo" value="" />


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-tipo"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Tipo
                        Contenuto</label>
                    <select id="edit-tipo" disabled
                        class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-slate-400 text-sm cursor-not-allowed">
                        <option value="film">Film</option>
                        <option value="serie">Serie TV</option>
                    </select>
                </div>
                <div>
                    <label for="edit-titolo"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Titolo</label>
                    <input type="text" id="edit-titolo" name="titolo" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-anno"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Anno</label>
                    <input type="text" id="edit-anno" name="anno" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="edit-valutazione"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Valutazione
                        (0-10)</label>
                    <input type="number" id="edit-valutazione" name="valutazioneMedia" min="0" max="10" step="0.1"
                        required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div id="edit-campi-film" class="grid grid-cols-1 gap-4">
                <div>
                    <label for="edit-durata"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Durata (in
                        minuti)</label>
                    <input type="number" id="edit-durata" name="durataMinuti" min="1"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div id="edit-campi-serie" class="grid grid-cols-2 gap-4 hidden">
                <div>
                    <label for="edit-stagioni"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Numero
                        Stagioni</label>
                    <input type="number" id="edit-stagioni" name="numeroStagioni" min="1"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="edit-stato"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Stato</label>
                    <select id="edit-stato" name="stato"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 transition-colors">
                        <option value="in_corso">In Corso</option>
                        <option value="conclusa">Conclusa</option>
                        <option value="cancellata">Cancellata</option>
                    </select>
                </div>
            </div>


            <div>
                <label for="edit-locandina"
                    class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Locandina (URL
                    Immagine o Path relativo)</label>
                <input type="text" id="edit-locandina" name="locandina"
                    class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="edit-regista"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Regista</label>
                    <input type="text" id="edit-regista" name="regista"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="edit-attori"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Cast (Attori
                        separati da virgola)</label>
                    <input type="text" id="edit-attori" name="attori"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div>
                <label for="edit-trama"
                    class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Trama</label>
                <textarea id="edit-trama" name="trama" rows="3" required
                    class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors"></textarea>
            </div>


            <div>
                <label class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Generi</label>
                <div
                    class="grid grid-cols-3 gap-2 bg-slate-950 border border-slate-805 rounded-xl p-3 max-h-40 overflow-y-auto">
                    {assign var="listaGeneriModifica" value=['azione', 'commedia', 'drammatico', 'horror', 'fantascienza', 'fantasy', 'thriller', 'giallo', 'romantico', 'storico', 'biografico', 'musicale', 'animazione', 'documentario', 'cortometraggio']}
                    {foreach $listaGeneriModifica as $g}
                        <label
                            class="flex items-center gap-2 p-1.5 rounded-lg cursor-pointer hover:bg-slate-900 transition-all select-none">
                            <input type="checkbox" name="generi[]" value="{$g}" id="edit-genere-{$g}"
                                class="w-4 h-4 rounded text-purple-600 bg-slate-900 border-slate-800 focus:ring-purple-500 focus:ring-offset-slate-950 focus:ring-2 accent-purple-500">
                            <span class="text-xs text-slate-300 capitalize">{$g}</span>
                        </label>
                    {/foreach}
                </div>
            </div>


            <div class="flex justify-end gap-3 border-t border-slate-850 pt-4">
                <button type="button" onclick="closeModal('modalModificaContenuto')"
                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Annulla
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all shadow-md shadow-purple-900/20">
                    Salva Modifiche
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleModifica.js"></script>