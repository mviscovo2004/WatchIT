{extends file="admin/mainAdmin.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-3xl font-black text-white mb-8 border-b border-slate-800 pb-4 flex items-center gap-2">
            <span class="w-1.5 h-8 bg-purple-500 rounded-full"></span>
            Gestione Recensioni
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {foreach $recensioni as $recensione}
                <div
                    class="bg-slate-900 border border-slate-800/80 p-6 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition-all duration-300 shadow-xl">
                    <div class="space-y-4">

                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h3 class="font-bold text-white text-lg line-clamp-1">
                                    {$recensione->getContenuto()->getTitolo()}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1">
                                    Recensione di <span
                                        class="font-semibold text-slate-300">{$recensione->getUtente()->getUsername()}</span>
                                    {if $recensione->getEpisodio()}
                                        <span
                                            class="px-1.5 py-0.5 ml-1 text-[9px] font-semibold rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 tracking-wider">
                                            S{$recensione->getEpisodio()->getNumeroStagione()|string_format:"%02d"}E{$recensione->getEpisodio()->getNumeroEpisodio()|string_format:"%02d"}
                                        </span>
                                    {/if}
                                </p>
                            </div>
                            <span class="text-amber-500 font-bold text-sm shrink-0">
                                ★ {$recensione->getVoto()}/10
                            </span>
                        </div>


                        <p
                            class="text-slate-350 text-sm italic leading-relaxed line-clamp-4 bg-slate-950/40 p-3 rounded-xl border border-slate-800/40">
                            "{$recensione->getDescrizione()}"
                        </p>
                    </div>


                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-800/60">
                        <p class="text-[10px] text-slate-500 font-medium">
                            {$recensione->getDataPubblicazione()|date_format:"%d/%m/%Y %H:%M"}
                        </p>


                        <form action="index.php?controller=Recensione&action=eliminaRecensione" method="post"
                            onsubmit="return confirm('Sei sicuro di voler eliminare questa recensione?');" class="inline">
                            <input type="hidden" name="recensione_id" value="{$recensione->getId()}">
                            <input type="hidden" name="contenuto_id" value="{$recensione->getContenuto()->getId()}">
                            <input type="hidden" name="redirect_to" value="admin">
                            {if $recensione->getEpisodio()}
                                <input type="hidden" name="episodio_id" value="{$recensione->getEpisodio()->getId()}">
                            {/if}
                            <button type="submit"
                                class="text-red-500 hover:text-red-400 font-bold text-xs cursor-pointer hover:underline">
                                Elimina
                            </button>
                        </form>
                    </div>
                </div>
            {foreachelse}
                <div class="col-span-full text-center py-12 bg-slate-900/50 border border-slate-800 rounded-2xl">
                    <p class="text-slate-400 text-sm">Nessuna recensione presente nel database.</p>
                </div>
            {/foreach}
        </div>
    </div>
{/block}