{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Gestione Utenti Bannati</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {foreach $utentiBannati as $utente}
            <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 flex flex-col justify-between h-full">
                <div>
                    <h3 class="font-semibold text-lg text-white">{$utente->getNome()} {$utente->getCognome()}</h3>
                    <p class="text-slate-400 text-sm">{$utente->getEmail()}</p>
                    <p class="text-slate-400 text-sm mb-3">
                        {if $utente instanceof EAmministratore}Amministratore{else}Utente{/if}
                    </p>
                </div>

                <div class="flex justify-end items-center mt-4 pt-3 border-t border-slate-700/50">
                    <button
                        onclick="window.location.href='index.php?controller=Utente&action=eliminaUtente&id={$utente->getId()}'"
                        class="text-slate-400 hover:text-red-500 text-sm font-semibold transition-all duration-200 mr-auto">
                        Elimina
                    </button>

                    <button
                        onclick="openUnbanModal('{$utente->getId()}', '{$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}')"
                        class="px-3 py-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white rounded-lg text-xs font-bold transition-all duration-200">
                        Sblocca
                    </button>
                </div>
            </div>
        {/foreach}
    </div>

    <!-- ================= MODALE DI UNBAN (SBLOCCO) ================= -->
    <div id="unbanModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-all duration-300">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-95 opacity-0"
            id="unbanModalContainer">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Sblocca Utente
                </h3>
                <button onclick="closeUnbanModal()" class="text-slate-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-slate-400 mb-6 text-sm">Sei sicuro di voler sbloccare l'utente <span id="unbanTargetName"
                class="font-semibold text-white"></span>? L'utente riacquisirà immediatamente l'accesso completo al
            portale.</p>

        <div class="flex justify-end gap-3 border-t border-slate-800 pt-4">
            <button type="button" onclick="closeUnbanModal()"
                class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-sm font-semibold transition-colors">
                Annulla
            </button>
            <a id="unbanConfirmBtn" href="#"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-semibold transition-colors flex items-center justify-center shadow-lg shadow-emerald-900/20">
                Conferma Sblocco
            </a>
        </div>
    </div>
</div>

<!-- ================= JAVASCRIPT GESTIONE INTERATTIVA ================= -->
{literal}
<script>
    // Gestione Unban Modal
    function openUnbanModal(userId, userFullName) {
        document.getElementById('unbanTargetName').textContent = userFullName;
        document.getElementById('unbanConfirmBtn').href = 'index.php?controller=Admin&action=unbanUtente&idUtente=' +
            userId;

        const modal = document.getElementById('unbanModal');
        const container = document.getElementById('unbanModalContainer');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(function() {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeUnbanModal() {
        const modal = document.getElementById('unbanModal');
        const container = document.getElementById('unbanModalContainer');

        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');

        setTimeout(function() {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    // Chiudi il modale al click sullo sfondo
    window.addEventListener('click', function(e) {
        const unbanModal = document.getElementById('unbanModal');
                if (e.target === unbanModal) {
                    closeUnbanModal();
                }
            });
        </script>
    {/literal}
{/block}