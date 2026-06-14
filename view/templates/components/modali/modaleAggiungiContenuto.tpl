
<div id="modalAggiungiContenuto"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-all duration-300">
    <div
        class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300">

        <button onclick="closeModal('modalAggiungiContenuto')"
            class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>


        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Aggiungi Contenuto Manuale
        </h2>


        <form action="index.php?controller=Admin&action=aggiungiContenuto" method="post" class="space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-tipo"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Tipo
                        Contenuto</label>
                    <select id="add-tipo" name="tipo" onchange="toggleTipoCampi('add')"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 transition-colors">
                        <option value="film">Film</option>
                        <option value="serie">Serie TV</option>
                    </select>
                </div>
                <div>
                    <label for="add-titolo"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Titolo</label>
                    <input type="text" id="add-titolo" name="titolo" placeholder="Es: Il Cavaliere Oscuro" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-anno"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Anno</label>
                    <input type="text" id="add-anno" name="anno" placeholder="Es: 2008" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="add-valutazione"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Valutazione
                        Iniziale (0-10)</label>
                    <input type="number" id="add-valutazione" name="valutazioneMedia" min="0" max="10" step="0.1"
                        placeholder="Es: 8.5" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div id="add-campi-film" class="grid grid-cols-1 gap-4">
                <div>
                    <label for="add-durata"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Durata (in
                        minuti)</label>
                    <input type="number" id="add-durata" name="durataMinuti" placeholder="Es: 152" min="1" required
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div id="add-campi-serie" class="grid grid-cols-2 gap-4 hidden">
                <div>
                    <label for="add-stagioni"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Numero
                        Stagioni</label>
                    <input type="number" id="add-stagioni" name="numeroStagioni" placeholder="Es: 5" min="1"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="add-stato"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Stato</label>
                    <select id="add-stato" name="stato"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 transition-colors">
                        <option value="in_corso">In Corso</option>
                        <option value="conclusa">Conclusa</option>
                        <option value="cancellata">Cancellata</option>
                    </select>
                </div>
            </div>


            <div>
                <label for="add-locandina"
                    class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Locandina (URL
                    Immagine o Path relativo)</label>
                <input type="text" id="add-locandina" name="locandina"
                    placeholder="Es: /nomelocandina.jpg o url esterno"
                    class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="add-regista"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Regista</label>
                    <input type="text" id="add-regista" name="regista" placeholder="Es: Christopher Nolan"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
                <div>
                    <label for="add-attori"
                        class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Cast (Attori
                        separati da virgola)</label>
                    <input type="text" id="add-attori" name="attori" placeholder="Es: Christian Bale, Heath Ledger"
                        class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors" />
                </div>
            </div>


            <div>
                <label for="add-trama"
                    class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Trama</label>
                <textarea id="add-trama" name="trama" rows="3" required
                    placeholder="Inserisci una breve trama o sinossi..."
                    class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 transition-colors"></textarea>
            </div>


            <div>
                <label class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Generi</label>
                <div
                    class="grid grid-cols-3 gap-2 bg-slate-950 border border-slate-800 rounded-xl p-3 max-h-40 overflow-y-auto">
                    {assign var="listaGeneri" value=['azione', 'commedia', 'drammatico', 'horror', 'fantascienza', 'fantasy', 'thriller', 'giallo', 'romantico', 'storico', 'biografico', 'musicale', 'animazione', 'documentario', 'cortometraggio']}
                    {foreach $listaGeneri as $g}
                        <label
                            class="flex items-center gap-2 p-1.5 rounded-lg cursor-pointer hover:bg-slate-900 transition-all select-none">
                            <input type="checkbox" name="generi[]" value="{$g}"
                                class="w-4 h-4 rounded text-purple-600 bg-slate-900 border-slate-800 focus:ring-purple-500 focus:ring-offset-slate-950 focus:ring-2 accent-purple-500">
                            <span class="text-xs text-slate-300 capitalize">{$g}</span>
                        </label>
                    {/foreach}
                </div>
            </div>


            <div class="flex justify-end gap-3 border-t border-slate-850 pt-4">
                <button type="button" onclick="closeModal('modalAggiungiContenuto')"
                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Annulla
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all shadow-md shadow-purple-900/20">
                    Salva Contenuto
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleAggiungi.js"></script>