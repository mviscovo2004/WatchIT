{extends file="admin/mainAdmin.tpl"}

{block name="content"}

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 pb-5 border-b border-slate-800/60">
        <div class="space-y-1">
            <h1 class="text-white font-black text-3xl tracking-tight">Aggiungi Nuovo Contenuto</h1>
            <p class="text-slate-400 text-xs sm:text-sm">Inserisci un nuovo film o una serie TV nel database del portale.
            </p>
        </div>
        <a href="?controller=Admin&action=listaContenuti"
            class="px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-purple-500/50 hover:bg-slate-850 hover:text-purple-400 text-slate-350 text-xs font-bold transition-all duration-250 flex items-center gap-2 w-fit shadow-lg shadow-black/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Torna alla Lista
        </a>
    </div>


    <div
        class="bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-8 max-w-4xl mx-auto shadow-2xl space-y-8">
        <form action="index.php?controller=Admin&action=aggiungiContenuto" method="post" class="space-y-8">


            <div class="space-y-5">
                <h3 class="text-white font-extrabold text-base flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    Informazioni Principali
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="add-tipo"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Tipo
                            Contenuto</label>
                        <select id="add-tipo" name="tipo" onchange="toggleTipoCampi('add')"
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all cursor-pointer">
                            <option value="film">Film</option>
                            <option value="serie">Serie TV</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="add-titolo"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Titolo</label>
                        <input type="text" id="add-titolo" name="titolo" placeholder="Es: Il Cavaliere Oscuro" required
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>
                </div>
            </div>

            <hr class="border-slate-800/50" />


            <div class="space-y-5">
                <h3 class="text-white font-extrabold text-base flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </span>
                    Dettagli Tecnici
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="add-anno"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Anno di
                            Uscita</label>
                        <input type="text" id="add-anno" name="anno" placeholder="Es: 2008" required
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>
                    <div>
                        <label for="add-valutazione"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Valutazione
                            Iniziale (0-10)</label>
                        <input type="number" id="add-valutazione" name="valutazioneMedia" min="0" max="10" step="0.1"
                            placeholder="Es: 8.5" required
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>
                </div>


                <div id="add-campi-film" class="mt-6 transition-all duration-300">
                    <div>
                        <label for="add-durata"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Durata (in
                            minuti)</label>
                        <input type="number" id="add-durata" name="durataMinuti" placeholder="Es: 152" min="1" required
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>
                </div>


                <div id="add-campi-serie"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 hidden transition-all duration-300">
                    <div>
                        <label for="add-stagioni"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Numero
                            Stagioni</label>
                        <input type="number" id="add-stagioni" name="numeroStagioni" placeholder="Es: 5" min="1"
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>
                    <div>
                        <label for="add-stato"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Stato</label>
                        <select id="add-stato" name="stato"
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all cursor-pointer">
                            <option value="in_corso">In Corso</option>
                            <option value="conclusa">Conclusa</option>
                            <option value="cancellata">Cancellata</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="border-slate-800/50" />


            <div class="space-y-5">
                <h3 class="text-white font-extrabold text-base flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    Media, Regia e Cast
                </h3>

                <div class="space-y-6">
                    <div>
                        <label for="add-locandina"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Locandina (URL
                            Immagine o Path relativo)</label>
                        <input type="text" id="add-locandina" name="locandina"
                            placeholder="Es: /locandina.jpg o url esterno"
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="add-regista"
                                class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Regista</label>
                            <input type="text" id="add-regista" name="regista" placeholder="Es: Christopher Nolan"
                                class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                        </div>
                        <div>
                            <label for="add-attori"
                                class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Cast
                                (Attori separati da virgola)</label>
                            <input type="text" id="add-attori" name="attori" placeholder="Es: Christian Bale, Heath Ledger"
                                class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-800/50" />


            <div class="space-y-5">
                <h3 class="text-white font-extrabold text-base flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    Descrizione e Generi
                </h3>

                <div class="space-y-6">
                    <div>
                        <label for="add-trama"
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Trama</label>
                        <textarea id="add-trama" name="trama" rows="4" required
                            placeholder="Inserisci una breve trama o sinossi..."
                            class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800/80 rounded-xl text-white placeholder-slate-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"></textarea>
                    </div>

                    <div>
                        <label
                            class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-2">Generi</label>
                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-slate-950 border border-slate-850/60 rounded-xl p-4 max-h-52 overflow-y-auto">
                            {assign var="listaGeneri" value=['azione', 'commedia', 'drammatico', 'horror', 'fantascienza', 'fantasy', 'thriller', 'giallo', 'romantico', 'storico', 'biografico', 'musicale', 'animazione', 'documentario', 'cortometraggio']}
                            {foreach $listaGeneri as $g}
                                <label
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-900 border border-slate-800/60 cursor-pointer hover:bg-slate-850 hover:border-purple-500/30 transition-all duration-200 select-none">
                                    <input type="checkbox" name="generi[]" value="{$g}"
                                        class="w-4 h-4 rounded text-purple-650 bg-slate-950 border-slate-800 focus:ring-purple-500 focus:ring-offset-slate-950 focus:ring-2 accent-purple-500 cursor-pointer">
                                    <span class="text-xs text-slate-300 capitalize font-semibold">{$g}</span>
                                </label>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex justify-end gap-4 border-t border-slate-800/80 pt-6">
                <a href="?controller=Admin&action=listaContenuti"
                    class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-350 text-xs font-bold transition-all hover:scale-102 active:scale-98">
                    Annulla
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-purple-600/20">
                    Salva Contenuto
                </button>
            </div>
        </form>
    </div>


    <script src="{$baseUrl}/view/js/modaleAggiungi.js"></script>
{/block}