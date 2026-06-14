{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Gestione Utenti</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {foreach $utenti as $utente}
            <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 flex flex-col justify-between h-full">
                <div>
                    <h3 class="font-semibold text-lg text-white">{$utente->getNome()} {$utente->getCognome()}</h3>
                    <p class="text-slate-400 text-sm">{$utente->getEmail()}</p>
                    <p class="text-slate-400 text-sm mb-3">
                        {if $utente instanceof EAmministratore}Amministratore{else}Utente{/if}
                    </p>


                    {$userBans=FBan::findByUtente($utente)}
                    {if !empty($userBans)}
                        {$ban=$userBans[0]}
                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 my-2 text-xs">
                            <p class="text-red-400 font-semibold mb-1">Stato: Bannato</p>
                            <p class="text-slate-300"><span class="font-semibold">Motivo:</span> {$ban->getMotivo()}</p>
                            <p class="text-slate-300"><span class="font-semibold">Fino al:</span>
                                {$ban->getDataFine()->format('d/m/Y')}</p>
                        </div>
                    {/if}
                </div>

                <div class="flex justify-end items-center mt-4 pt-3 border-t border-slate-700/50 gap-2">
                    <button
                        onclick="if(confirm('Sei sicuro di voler eliminare permanentemente l\'utente {$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}? Questa operazione è irreversibile.')) window.location.href='?controller=Admin&action=eliminaUtente&id={$utente->getId()}'"
                        class="text-slate-400 hover:text-red-500 text-sm font-bold transition-all duration-200 mr-auto">
                        Elimina
                    </button>


                    {if $utente instanceof EAmministratore}

                        {if Session::get('user_id') !== $utente->getId()}
                            <button
                                onclick="window.location.href='index.php?controller=Admin&action=retrocediAdUtente&idUtente={$utente->getId()}'"
                                class="px-3 py-1.5 bg-amber-600/20 hover:bg-amber-600 text-amber-400 hover:text-white rounded-lg text-sm font-bold transition-all duration-200">
                                Retrocedi
                            </button>
                        {/if}
                    {else}
                        {if empty($userBans)}
                            <button
                                onclick="window.location.href='index.php?controller=Admin&action=promuoviAdAdmin&idUtente={$utente->getId()}'"
                                class="px-3 py-1.5 bg-purple-600/20 hover:bg-purple-600 text-purple-400 hover:text-white rounded-lg text-sm font-bold transition-all duration-200">
                                Promuovi ad Admin
                            </button>
                        {/if}
                        {if !empty($userBans)}
                            <button
                                onclick="openUnbanModal('{$utente->getId()}', '{$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}')"
                                class="px-3 py-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white rounded-lg text-sm font-bold transition-all duration-200">
                                Sblocca
                            </button>
                        {else}
                            <button
                                onclick="openBanModal('{$utente->getId()}', '{$utente->getNome()|escape:'javascript'} {$utente->getCognome()|escape:'javascript'}')"
                                class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white rounded-lg text-sm font-bold transition-all duration-200">
                                Banna
                            </button>
                        {/if}
                    {/if}
                </div>

            </div>
        {/foreach}
    </div>

    {include file="components/modali/modaleBan.tpl"}
    {include file="components/modali/modaleUnban.tpl"}
    <script src="{$baseUrl}/view/js/modaleModerazione.js"></script>
{/block}