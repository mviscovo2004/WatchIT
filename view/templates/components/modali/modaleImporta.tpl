
<div id="modalImporta"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-all duration-300">
    <div
        class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg shadow-2xl p-6 relative transform scale-95 opacity-0 transition-all duration-300">

        <button onclick="closeModal('modalImporta')"
            class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>


        <h2 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Importa da TMDB
        </h2>

        <p class="text-slate-400 text-sm mb-5">
            Inserisci il titolo del contenuto da cercare su TMDB. Il primo risultato corrispondente (film o serie TV)
            verrà aggiunto automaticamente, includendo dettagli, generi, trailer, cast e (per le serie) tutti gli
            episodi.
        </p>


        <form id="formImportaTMDB" action="index.php?controller=Admin&action=importaDaTMDB" method="post"
            onsubmit="showImportLoading()">
            <div class="mb-5">
                <label for="import-titolo"
                    class="block text-slate-300 text-xs font-semibold uppercase tracking-wider mb-2">Titolo
                    Contenuto</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="import-titolo" name="titolo"
                        placeholder="Esempio: Inception, Breaking Bad..." required
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" />
                </div>
            </div>


            <div id="importLoading" class="hidden mb-4 items-center justify-center gap-3 text-purple-400 text-sm py-2">
                <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Importazione in corso dal database TMDB...</span>
            </div>


            <div class="flex justify-end gap-3 border-t border-slate-800 pt-4">
                <button type="button" onclick="closeModal('modalImporta')"
                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Annulla
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all shadow-md shadow-purple-900/20">
                    Importa
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleImporta.js"></script>