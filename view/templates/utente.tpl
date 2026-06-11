{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        <h1>Profilo Utente</h1>
        {if $utente}
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="relative w-40 h-40">
                    <img src="{$utente->getImmagineProfilo()|default:"../images/default.png"}" alt="{$utente->getUsername()}"
                        class="w-full h-full object-cover rounded-full border-4 border-slate-800">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-4xl font-bold text-white mb-2">{$utente->getUsername()}</h2>
                    <p class="text-xl text-purple-400 font-medium mb-4">{$utente->getNome()} {$utente->getCognome()}</p>
                    <p class="text-slate-300">{$utente->getEmail()}</p>
                </div>
            </div>


        {else}
            <p class="text-red-400">Utente non trovato.</p>
        {/if}
    </div>
{/block}