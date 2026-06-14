<div class="mt-12 space-y-6">
    <h2 class="text-2xl font-bold text-white border-b border-slate-800 pb-3">Recensioni</h2>

    {if count($recensioni) == 0}
        <p class="text-slate-400 text-sm">Nessuna recensione per questo contenuto. Sii il primo a scriverne una!</p>
    {else}
        <div class="grid grid-cols-1 gap-4">
            {foreach $recensioni as $recensione}
                {include file="components/cards/cardRecensioneSemplice.tpl" recensione=$recensione contenuto=$contenutoId}
            {/foreach}
        </div>
    {/if}
</div>