{extends file="main.tpl"}
{block name="title"}Profilo di {$utente->getUsername()|escape} - WatchIT{/block}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        {if $utente}
            <div class="flex flex-col md:flex-row items-center gap-8 border-b border-slate-800 pb-8">
                <div class="relative w-40 h-40">
                    <img src="view/images/{$utente->getFoto()|default:"default.png"}" alt="{$utente->getUsername()}"
                        class="w-full h-full object-cover rounded-full border-4 border-slate-800">
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2
                        class="text-4xl font-bold text-white mb-2 flex flex-wrap items-center gap-4 justify-center md:justify-start">
                        {$utente->getUsername()}

                        {if $isLogged && $currentUser->getId() !== $utente->getId()}
                            {if $isFollowing}
                                <a href="index.php?controller=Utente&action=unfollow&id={$utente->getId()}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-350 hover:text-white rounded-xl text-xs font-semibold border border-slate-700 transition-all hover:scale-102 active:scale-98">
                                    Segui già (Rimuovi)
                                </a>
                            {else}
                                <a href="index.php?controller=Utente&action=follow&id={$utente->getId()}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-purple-650 hover:bg-purple-600 text-white rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95">
                                    Segui
                                </a>
                            {/if}

                            {if $isAmico}
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    Amici
                                </span>
                            {/if}
                        {/if}
                    </h2>
                    <p class="text-xl text-purple-400 font-medium mb-4">{$utente->getNome()} {$utente->getCognome()}</p>
                </div>


            </div>


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-12">



                <div class="space-y-6">
                    <h3 class="text-2xl font-black text-white flex items-center gap-2 tracking-tight">
                        <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                        Watchlist
                    </h3>

                    {if $watchlists && count($watchlists) > 0}
                        <div class="grid grid-cols-1 gap-4">
                            {foreach $watchlists as $watchlist}
                                <div onclick="window.location.href='index.php?controller=Watchlist&action=mostra&id={$watchlist->getId()}'"
                                    class="p-5 rounded-2xl bg-slate-900 border border-slate-850 hover:border-purple-500/50 hover:bg-slate-900/60 transition-all duration-300 cursor-pointer flex flex-col justify-between group">
                                    <div>
                                        <div class="flex items-start justify-between gap-4">
                                            <h4 class="font-bold text-white text-lg group-hover:text-purple-400 transition-colors">
                                                {$watchlist->getNome()}
                                            </h4>

                                            <div class="shrink-0">
                                                {if $watchlist->getVisibilita()->name === 'pubblico'}
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Pubblica</span>
                                                {elseif $watchlist->getVisibilita()->name === 'solo_amici'}
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">Solo
                                                        Amici</span>
                                                {else}
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold rounded bg-slate-800 text-slate-400 border border-slate-700">Privata</span>
                                                {/if}
                                            </div>
                                        </div>
                                        <p class="text-slate-400 text-sm mt-2 line-clamp-2 leading-relaxed">
                                            {$watchlist->getDescrizione()}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-800/40">
                                        <span class="text-xs font-semibold text-slate-500">
                                            Contenuti salvati: {count($watchlist->getContenutiSalvati())}
                                        </span>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    {else}
                        <div class="text-center py-8 bg-slate-900/40 border border-dashed border-slate-800 rounded-2xl">
                            <p class="text-slate-500 text-sm italic">Nessuna watchlist pubblica creata da questo utente.</p>
                        </div>
                    {/if}
                </div>


                <div class="space-y-6">
                    <h3 class="text-2xl font-black text-white flex items-center gap-2 tracking-tight">
                        <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                        Recensioni Scritte
                    </h3>

                    {if $recensioni && count($recensioni) > 0}
                        <div class="grid grid-cols-1 gap-4">
                            {foreach $recensioni as $recensione}
                                {include file="components/cards/cardRecensioneGlobale.tpl" recensione=$recensione colorTheme="amber" redirectContext="profilo" profileId=$utente->getId()}
                            {/foreach}
                        </div>
                    {else}
                        <div class="text-center py-8 bg-slate-900/40 border border-dashed border-slate-800 rounded-2xl">
                            <p class="text-slate-500 text-sm italic">Nessuna recensione scritta da questo utente.</p>
                        </div>
                    {/if}
                </div>

            </div>
        {else}

            <div
                class="max-w-md mx-auto my-12 p-8 rounded-2xl bg-slate-900 border border-slate-800 text-center shadow-2xl space-y-6">

                <div
                    class="w-16 h-16 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>


                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white">Utente non trovato</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Non è stato possibile trovare l'utente richiesto. L'utente potrebbe essere stato rimosso o l'URL
                        potrebbe contenere un identificativo non corretto.
                    </p>
                </div>


                <div class="pt-4 border-t border-slate-800/60 flex justify-center">
                    <a href="index.php"
                        class="px-6 py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20 hover:scale-105 active:scale-95">
                        Torna alla Home
                    </a>
                </div>
            </div>
        {/if}

    </div>
{/block}