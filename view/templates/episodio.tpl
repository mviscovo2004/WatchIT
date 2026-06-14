{extends file="main.tpl"}

{block name="content"}
    <div class="min-h-screen bg-slate-950 text-slate-100 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-6xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">


                <div class="md:col-span-1 flex flex-col items-center md:items-start">
                    <div
                        class="group relative w-64 h-96 sm:w-72 sm:h-[26rem] md:w-full md:h-[28rem] rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 shadow-xl transition-all duration-300 hover:shadow-indigo-500/10">
                        <img src="{$episodio->getLocandina()}" alt="{$episodio->getTitolo()}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-all duration-550 ease-out">

                    </div>
                </div>


                <div class="md:col-span-3 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">


                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h1
                                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-amber-500 tracking-tight leading-tight pb-2">
                                {if isset($serie)}
                                    S {$episodio->getNumeroStagione()} E
                                    {$episodio->getNumeroEpisodio()} - {$episodio->getTitolo()}
                                {else}
                                    {$episodio->getTitolo()}
                                {/if}

                            </h1>





                            {if $isLogged}
                                <a onclick="toggleReviewModal(true)"
                                    class="shrink-0 inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/20 text-sm hover:scale-105 active:scale-95 self-start sm:self-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Valuta
                                </a>
                            {/if}
                        </div>


                        <div class="flex flex-wrap gap-3 items-center text-sm pt-2">
                            <span
                                class="flex items-center gap-1.5 bg-slate-900 border border-slate-800 px-3.5 py-1.5 rounded-xl text-slate-300 font-medium shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                                Serie: {$serie->getTitolo()}
                            </span>
                            <span
                                class="flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3.5 py-1.5 rounded-xl font-semibold shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-amber-400" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {$episodio->getValutazioneMedia()} / 10
                            </span>
                        </div>
                    </div>

                    <hr class="border-slate-800/80" />


                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Trama</h2>
                        <p class="text-slate-300 leading-relaxed text-base font-light">
                            {$episodio->getTrama()}
                        </p>
                    </div>


                    <div class="space-y-2">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Generi</h2>
                        <div class="flex flex-wrap gap-2">
                            {foreach $episodio->getGeneri() as $genere}
                                <span
                                    class="bg-indigo-950/40 text-indigo-300 border border-indigo-900/50 px-3.5 py-1 rounded-lg text-sm font-medium">
                                    {$genere}
                                </span>
                            {/foreach}
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-12 space-y-6">
                <h2 class="text-2xl font-bold text-white border-b border-slate-800 pb-3">Cast</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    {foreach $serie->getPartecipazioni() as $p}
                        {if $p->getRuolo() === 'Attore'}
                            <div
                                class="flex flex-col items-center text-center p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 hover:border-purple-500 transition-all duration-300 group">

                                <div
                                    class="w-20 h-20 rounded-full overflow-hidden bg-slate-800 border border-slate-700 mb-3 shrink-0">
                                    {assign var="fotoAttore" value=$p->getPersona()->getFoto()}
                                    <img src="{if $fotoAttore && $fotoAttore[0] === '/'}https://image.tmdb.org/t/p/w185{$fotoAttore}{else}view/images/{$fotoAttore|default:"default.png"}{/if}"
                                        alt="{$p->getPersona()->getNome()}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                                </div>

                                <h4
                                    class="font-bold text-white text-sm truncate w-full group-hover:text-purple-400 transition-colors duration-200">
                                    {$p->getPersona()->getNome()} {$p->getPersona()->getCognome()}
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">{$p->getRuolo()}</p>
                            </div>
                        {/if}
                    {/foreach}
                </div>
            </div>
            {include file="components/sezioneRecensioni.tpl" recensioni=$recensioni contenutoId=$serie->getId()}

            {include file="components/modali/modaleRecensione.tpl" contenutoId=$serie->getId() episodioId=$episodio->getId()}
        </div>
    </div>
    <script src="{$baseUrl}/view/js/modaleRecensione.js"></script>

{/block}