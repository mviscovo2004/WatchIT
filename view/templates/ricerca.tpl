{*
 * Template Risultati della Ricerca
 * 
 * Mostra i risultati di una ricerca testuale globale eseguita dall'utente.
 * I risultati sono divisi in tre schede: Film, Serie TV e Utenti trovati.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param EFilm[] $film Elenco dei film corrispondenti alla ricerca.
 * @param ESerie[] $serie Elenco delle serie TV corrispondenti alla ricerca.
 * @param EUtente[] $utenti Elenco degli utenti corrispondenti alla ricerca.
 *}
{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        <h1 class="mt-10 mb-6 text-4xl font-bold text-white">Risultati Ricerca</h1>
        {if count($film) == 0 && count($serie) == 0 && count($utenti) == 0}
            <p>Nessun risultato trovato.</p>
        {else}
            {if count($film) > 0}
                <h2 class="mt-10 mb-6 text-2xl font-bold text-white">Film:</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {foreach from=$film item=f name=film_loop}
                        {include file="components/cards/cardContenuto.tpl" contenuto=$f}
                    {foreachelse}
                        <p class="text-slate-400 text-sm col-span-full">Nessun film disponibile nel database.</p>
                    {/foreach}
                </div>
            {/if}
            {if count($serie) > 0}
                <h2 class="mt-10 mb-6 text-2xl font-bold text-white">Serie TV:</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {foreach from=$serie item=s name=serie_loop}
                        {include file="components/cards/cardContenuto.tpl" contenuto=$s}
                    {foreachelse}
                        <p class="text-slate-400 text-sm col-span-full">Nessuna serie TV disponibile nel database.</p>
                    {/foreach}
                </div>
            {/if}
            {if count($utenti) > 0}
                <h2 class="mt-10 mb-6 text-2xl font-bold text-white">Utenti:</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {foreach $utenti as $u}
                        <div onclick="window.location.href='index.php?controller=Utente&action=mostraProfilo&id={$u->getId()}'"
                            class="flex items-center gap-4 p-4 rounded-xl bg-slate-900 border border-slate-800/80 hover:border-purple-500 transition-all duration-300 cursor-pointer group">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-800 border border-slate-700 shrink-0">
                                <img src="view/images/{$u->getFoto()|default:"default.png"}" alt="{$u->getUsername()}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 truncate">
                                    {$u->getUsername()}
                                </h4>
                                <p class="text-xs text-slate-500 font-medium">Vedi profilo</p>
                            </div>
                        </div>
                    {/foreach}
                </div>
            {/if}
        {/if}
    </div>
{/block}