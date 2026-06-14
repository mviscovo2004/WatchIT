{assign var="isSerie" value=$contenuto instanceof ESerie}

<div class="flex flex-wrap gap-3 items-center text-sm pt-2">

    <span
        class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
        Anno: {$contenuto->getAnno()}
    </span>


    <span
        class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
        {if $isSerie}Autore{else}Regista{/if}: {$contenuto->getRegista()}
    </span>

    {if $isSerie}

        <span
            class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
            Stagioni: {$contenuto->getNumeroStagioni()}
        </span>


        <span
            class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            Stato: {$contenuto->getStato()->value|replace: '_' : ' '|capitalize }
        </span>
    {else}

        <span
            class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
            Durata: {$contenuto->getDurata()} min
        </span>
    {/if}


    <span
        class="flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3.5 py-1.5 rounded-xl font-semibold shadow-inner">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-amber-400" viewBox="0 0 20 20" fill="currentColor">
            <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
        {$contenuto->getValutazioneMedia()} / 10
    </span>
</div>