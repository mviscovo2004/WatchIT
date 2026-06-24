{*
 * Componente Card Cast
 * 
 * Visualizza la card del singolo membro del cast o regista, con l'immagine di profilo,
 * il nome reale e, se presente, il nome del personaggio interpretato.
 * 
 * @package View/Templates/Components/Cards
 * @author Marco Viscovo
 * 
 * @param EPartecipazione $partecipazione La partecipazione dell'attore o regista nel contenuto.
 *}
<div
    class="flex flex-col items-center text-center p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 hover:border-purple-500 transition-all duration-300 group">

    <div class="w-20 h-20 rounded-full overflow-hidden bg-slate-800 border border-slate-700 mb-3 shrink-0">
        {assign var="fotoPersona" value=$partecipazione->getPersona()->getFoto()}
        <img src="{if $fotoPersona && $fotoPersona[0] === '/'}https://image.tmdb.org/t/p/w185{$fotoPersona}{else}view/images/{$fotoPersona|default:"default.png"}{/if}"
            alt="{$partecipazione->getPersona()->getNome()}"
            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
    </div>

    <h4 class="font-bold text-white text-sm truncate w-full group-hover:text-purple-400 transition-colors duration-200">
        {$partecipazione->getPersona()->getNome()} {$partecipazione->getPersona()->getCognome()}
    </h4>

    <p class="text-xs text-slate-500 truncate w-full mt-1">
        {if $partecipazione->getRuolo() === 'Attore'}
            {$partecipazione->getPersonaggio()}
        {else}
            {$partecipazione->getRuolo()}
        {/if}
    </p>
</div>