{*
 * Componente Carosello Video
 * 
 * Visualizza un player carosello interattivo contenente clip e trailer ufficiali da YouTube
 * associati al film o alla serie TV correnti.
 * 
 * @package View/Templates/Components
 * @author Marco Viscovo
 * 
 * @param array $video L'array contenente i dettagli dei video (ID YouTube, nome, ecc.).
 *}
{if isset($videos) && count($videos) > 0}
    <div class="mt-12 space-y-6">
        <h2 class="text-2xl font-bold text-white border-b border-slate-800 pb-3">Video</h2>

        <div class="relative group/carousel max-w-full">
            <button id="slideLeftBtn"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-30 p-3 rounded-full bg-slate-950/80 border border-slate-800 text-white hover:bg-purple-600 hover:border-purple-500 backdrop-blur-md shadow-lg transition-all duration-300 opacity-0 group-hover/carousel:opacity-100 focus:outline-none hover:scale-105 active:scale-95 disabled:opacity-0 cursor-pointer"
                title="Scorri a sinistra">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div id="videoContainer"
                class="flex w-full overflow-x-auto gap-6 pb-4 scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                {foreach $videos as $v}
                    <div
                        class="aspect-video w-[300px] sm:w-[400px] md:w-[480px] shrink-0 rounded-xl overflow-hidden border border-slate-800 shadow-md">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{$v.key}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                {/foreach}
            </div>

            <button id="slideRightBtn"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-30 p-3 rounded-full bg-slate-950/80 border border-slate-800 text-white hover:bg-purple-600 hover:border-purple-500 backdrop-blur-md shadow-lg transition-all duration-300 opacity-0 group-hover/carousel:opacity-100 focus:outline-none hover:scale-105 active:scale-95 disabled:opacity-0 cursor-pointer"
                title="Scorri a destra">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <script src="view/js/caroselloVideo.js"></script>
{/if}