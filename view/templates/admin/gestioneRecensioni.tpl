{extends file="admin/mainAdmin.tpl"}


{block name="content"}
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Gestione Recensioni</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {foreach $recensioni as $recensione}
            <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                <h3 class="font-semibold">{$recensione->getTitolo()}</h3>
                <p class="text-slate-400">{$recensione->getContenuto()}</p>
                <div class="flex justify-end">
                    <button
                        onclick="eliminaRecensione('{$recensione->getId()}','{$recensione->getTitolo()}','{$recensione->getContenuto()}','{$recensione->getIdUtente()}','{$recensione->getData()}','{$recensione->getVoto()}')"
                        class="text-red-500 hover:text-red-400 text-sm font-semibold transition-all duration-200">Elimina</button>
                </div>
            </div>
        {/foreach}
    </div>




{/block}