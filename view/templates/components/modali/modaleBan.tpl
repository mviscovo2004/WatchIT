<div id="banModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-95 opacity-0"
        id="banModalContainer">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Banna Utente
            </h3>
            <button onclick="closeBanModal()" class="text-slate-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="text-slate-400 mb-6 text-sm">Stai per sospendere l'accesso dell'utente <span id="banTargetName"
                class="font-semibold text-white"></span> alla piattaforma.</p>
        <form id="banForm" method="POST" onsubmit="submitBanForm(event)">
            <input type="hidden" id="banUserId" name="idUtente">
            <div class="mb-4">
                <label for="banMotivo"
                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Motivo del
                    Ban</label>
                <textarea id="banMotivo" name="motivo" required rows="3"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl p-3 text-white placeholder-slate-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all text-sm"
                    placeholder="Inserisci la motivazione formale..."></textarea>
            </div>
            <div class="mb-6">
                <label for="banDurata"
                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Durata della
                    Sospensione</label>
                <select id="banDurata" name="durata"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl p-3 text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all text-sm">
                    <option value="1">1 Giorno</option>
                    <option value="3">3 Giorni</option>
                    <option value="7">7 Giorni</option>
                    <option value="30">30 Giorni</option>
                    <option value="365">1 Anno</option>
                    <option value="3650">Permanente (10 Anni)</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 border-t border-slate-800 pt-4">
                <button type="button" onclick="closeBanModal()"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-sm font-semibold transition-colors">
                    Annulla
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-xl text-sm font-semibold transition-colors shadow-lg shadow-red-900/20">
                    Conferma Ban
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleModerazione.js"></script>