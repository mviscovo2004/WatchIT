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
                        <div onclick="window.location.href='index.php?controller=Contenuto&action=mostraFilm&id={$f->getId()}'"
                            class="group cursor-pointer">
                            <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                                <img src="{$f->getLocandina()}" alt="{$f->getTitolo()}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                                {if $isLogged}
                                    <a href="index.php?controller=Watchlist&action=aggiungi&id={$f->getId()}"
                                        class="absolute top-3 right-3 p-2 rounded-full bg-slate-950/80 border border-slate-700 font-bold text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100 z-20 shadow-md transform hover:scale-110"
                                        title="{if $watchlistIds && in_array($f->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                                        {if $watchlistIds && in_array($f->getId(), $watchlistIds)}
                                            <!-- Spunta verde se già in watchlist -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        {else}
                                            <!-- Icona Più (+) se da aggiungere -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                        {/if}
                                    </a>
                                {/if}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                                    <span class="text-xs font-bold text-purple-500">
                                        {if $f->getGeneri() && count($f->getGeneri()) > 0}
                                            Genere: {$f->getGeneri()|join:", "}
                                        {else}
                                            Genere: Non specificato
                                        {/if}
                                    </span>

                                </div>
                            </div>
                            <h4 class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
                                {$f->getTitolo()}
                            </h4>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-slate-500 font-semibold">Anno: {$f->getAnno()}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-500">★
                                    {$f->getValutazioneMedia()|string_format:"%.1f"}</span>
                            </div>
                        </div>
                    {foreachelse}
                        <p class="text-slate-400 text-sm col-span-full">Nessun film disponibile nel database.</p>
                    {/foreach}
                </div>
            {/if}
            {if count($serie) > 0}
                <h2 class="mt-10 mb-6 text-2xl font-bold text-white">Serie TV:</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {foreach from=$serie item=s name=serie_loop}
                        <div onclick="window.location.href='index.php?controller=Contenuto&action=mostraSerie&id={$s->getId()}'"
                            class="group cursor-pointer">
                            <div class="aspect-[2/3] rounded-xl overflow-hidden bg-slate-900 border border-slate-800/80 relative mb-3">
                                <img src="{$s->getLocandina()}" alt="{$s->getTitolo()}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                                {if $isLogged}
                                    <a href="index.php?controller=Watchlist&action=aggiungi&id={$s->getId()}"
                                        class="absolute top-3 right-3 p-2 rounded-full bg-slate-950/80 border border-slate-700 font-bold text-white hover:bg-indigo-600 hover:border-indigo-500 transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100 z-20 shadow-md transform hover:scale-110"
                                        title="{if $watchlistIds && in_array($s->getId(), $watchlistIds)}Rimuovi dalla Watchlist{else}Aggiungi alla Watchlist{/if}">
                                        {if $watchlistIds && in_array($s->getId(), $watchlistIds)}
                                            <!-- Spunta verde se già in watchlist -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        {else}
                                            <!-- Icona Più (+) se da aggiungere -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                        {/if}
                                    </a>
                                {/if}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                                    <span class="text-xs font-bold text-purple-500">
                                        {if $s->getGeneri() && count($s->getGeneri()) > 0}
                                            Genere: {$s->getGeneri()|join:", "}
                                        {else}
                                            Genere: Non specificato
                                        {/if}
                                    </span>

                                </div>
                            </div>
                            <h4 class="font-bold text-white group-hover:text-purple-500 transition-colors duration-200 line-clamp-1">
                                {$s->getTitolo()}
                            </h4>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-slate-500 font-semibold">Anno: {$s->getAnno()}</p>

                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-500">★
                                    {$s->getValutazioneMedia()|string_format:"%.1f"}</span>
                            </div>
                        </div>
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
                                <img src="{$u->getFoto()|default:"../images/default.png"}" alt="{$u->getUsername()}"
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