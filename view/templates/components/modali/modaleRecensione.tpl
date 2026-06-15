<div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
    <div class="bg-slate-950 border border-slate-800/80 p-8 rounded-2xl max-w-md w-full relative shadow-2xl">

        <button onclick="toggleReviewModal(false)"
            class="absolute top-4 right-4 text-slate-400 hover:text-white text-2xl font-bold transition focus:outline-none">&times;</button>

        <div class="flex flex-col items-center justify-center">
            <h4
                class="text-2xl mb-6 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                Lascia una Valutazione
            </h4>

            <form action="index.php?controller=Recensione&action=aggiungiRecensione" method="post"
                class="flex flex-col items-center justify-center w-full space-y-4">


                <input type="hidden" name="contenuto_id" value="{$contenuto}">



                <div class="w-full space-y-2 text-center">
                    <label
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider block text-left">Voto</label>


                    <input type="hidden" name="voto" id="votoInput" required>


                    <div class="flex items-center justify-center gap-1 py-2">
                        {for $v=1 to 10}
                            <button type="button" data-value="{$v}" style="color: #475569;"
                                class="star-btn hover:scale-120 active:scale-95 transition-all duration-150 focus:outline-none cursor-pointer"
                                title="Vota {$v}/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        {/for}
                    </div>




                    <div id="votoVisualizzato" class="text-sm font-semibold text-amber-500 h-5 mt-1">
                        Nessun voto selezionato
                    </div>
                </div>



                <div class="w-full space-y-1 text-left">
                    <label for="testo" class="text-xs font-semibold text-slate-450 uppercase tracking-wider">Recensione
                        (opzionale)</label>
                    <textarea name="testo" id="testo" rows="5" placeholder="Scrivi qui il tuo commento..."
                        class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white resize-none"></textarea>
                </div>


                <button type="submit"
                    class="w-full text-center py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20 cursor-pointer">
                    Invia Valutazione
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleRecensione.js"></script>