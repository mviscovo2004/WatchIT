<div class="mt-12 space-y-6">
    <h2 class="text-2xl font-bold text-white border-b border-slate-800 pb-3">Cast</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        {foreach $partecipazioni as $p}
            {include file="components/cards/cardCast.tpl" partecipazione=$p}
        {/foreach}
    </div>
</div>