{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Gestione Utenti Bannati</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {if count($bannati) > 0}
            {foreach $bannati as $ban}
                {assign var="utente" value=$ban->getUtente()}
                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="font-semibold text-lg text-white">{$utente->getNome()} {$utente->getCognome()}</h3>
                        <p class="text-slate-400 text-sm">{$utente->getEmail()}</p>
                        <p class="text-slate-400 text-sm mb-3">
                            {if $utente instanceof EAmministratore}Amministratore{else}Utente{/if}
                        </p>


                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 my-2 text-xs">
                            <p class="text-red-400 font-semibold mb-1">Stato: Bannato</p>
                            <p class="text-slate-300"><span class="font-semibold">Motivo:</span> {$ban->getMotivo()}</p>
                            <p class="text-slate-300"><span class="font-semibold">Fino al:</span>
                                {$ban->getDataFine()->format('d/m/Y')}</p>
                        </div>
                    </div>

                    <div class="flex justify-end items-center mt-4 pt-3 border-t border-slate-700/50">
                        <button
                            onclick="if(confirm('Sei sicuro di voler eliminare permanentemente l\'utente {$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}? Questa operazione è irreversibile.')) window.location.href='index.php?controller=Admin&action=eliminaUtente&id={$utente->getId()}'"
                            class="text-slate-400 hover:text-red-500 text-sm font-semibold transition-all duration-200 mr-auto">
                            Elimina
                        </button>


                        <button
                            onclick="openUnbanModal('{$utente->getId()}', '{$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}')"
                            class="px-3 py-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white rounded-lg text-sm font-bold transition-all duration-200">
                            Sblocca
                        </button>
                    </div>
                </div>
            {/foreach}
        {else}

            <div class="col-span-full flex flex-col items-center justify-center text-center p-12 my-4">
                <div class="p-4 bg-emerald-500/10 rounded-full text-emerald-500 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-1">Nessun utente bannato</h3>
                <p class="text-slate-400 text-sm max-w-sm">Tutti gli iscritti alla piattaforma hanno attualmente accesso
                    completo e non sono presenti restrizioni attive.</p>
            </div>
        {/if}


    </div>

    {include file="components/modali/modaleUnban.tpl"}
    <script src="{$baseUrl}/view/js/modaleModerazione.js"></script>
{/block}