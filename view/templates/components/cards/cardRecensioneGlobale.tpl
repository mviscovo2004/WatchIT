{*
 * Componente Card Recensione Globale
 * 
 * Mostra una recensione dettagliata con il titolo del contenuto recensito, l'utente autore,
 * il voto, il testo e la data di pubblicazione, con link diretti alla risorsa.
 * 
 * @package View/Templates/Components/Cards
 * @author Marco Viscovo
 * 
 * @param ERecensione $recensione La recensione da mostrare.
 * @param string $colorTheme Tema colore della card (es. 'purple' o 'amber').
 *}
{assign var="isSerie" value=$recensione->getContenuto() instanceof ESerie}
{assign var="actionToShow" value="mostraFilm"}
{if $isSerie}
    {assign var="actionToShow" value="mostraSerie"}
{/if}

<div onclick="window.location.href='index.php?controller=Contenuto&action={$actionToShow}&id={$recensione->getContenuto()->getId()}'"
    class="flex gap-4 p-5 rounded-2xl bg-slate-900/40 border border-slate-800/80 hover:bg-slate-900/60 transition-all duration-300 cursor-pointer group {if $colorTheme === 'amber'}hover:border-amber-500/50{else}hover:border-purple-500/50{/if}">


    <div class="w-20 h-28 rounded-lg overflow-hidden shrink-0 bg-slate-850 border border-slate-800">
        <img src="{$recensione->getContenuto()->getLocandina()}" alt="{$recensione->getContenuto()->getTitolo()}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>


    <div class="flex-1 min-w-0 flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between gap-2">
                <h4
                    class="font-bold text-white text-base truncate transition-colors {if $colorTheme === 'amber'}group-hover:text-amber-400{else}group-hover:text-purple-400{/if}">
                    {$recensione->getContenuto()->getTitolo()}
                </h4>
                <span class="text-amber-500 font-bold text-sm shrink-0">
                    ★ {$recensione->getVoto()}/10
                </span>
            </div>

            <p class="text-slate-400 text-xs mt-1">
                Recensione di <span
                    class="font-semibold text-slate-300">{$recensione->getUtente()->getUsername()|escape}</span>


                {if $recensione->getEpisodio()}
                    per l'episodio <span
                    class="px-1.5 py-0.5 text-[9px] font-semibold rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 tracking-wider">
                    S{$recensione->getEpisodio()->getNumeroStagione()|string_format:"%02d"}E{$recensione->getEpisodio()->getNumeroEpisodio()|string_format:"%02d"}
                </span>
                {/if}
            </p>

            <p class="text-slate-300 text-sm mt-3 line-clamp-2 italic leading-relaxed">
                "{$recensione->getDescrizione()|escape}"
            </p>
        </div>

        <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-800/40">
            <p class="text-[10px] text-slate-500 font-medium">
                {$recensione->getDataPubblicazione()|date_format:"%d/%m/%Y %H:%M"}
            </p>

            {if $ruolo === 'ADMIN' || Session::get('user_id') === $recensione->getUtente()->getId()}
            <form action="index.php?controller=Recensione&action=eliminaRecensione" method="post"
                onsubmit="return confirm('Sei sicuro di voler eliminare questa recensione?');" class="inline-block"
                onclick="event.stopPropagation();">
                <input type="hidden" name="recensione_id" value="{$recensione->getId()}">
                <input type="hidden" name="contenuto_id" value="{$recensione->getContenuto()->getId()}">
                {if $redirectContext}
                <input type="hidden" name="redirect_to" value="{$redirectContext}">
                {/if}
                {if $profileId}
                <input type="hidden" name="profile_id" value="{$profileId}">
                {/if}
                {if $recensione->getEpisodio()}
                <input type="hidden" name="episodio_id" value="{$recensione->getEpisodio()->getId()}">
                {/if}
                <button type="submit"
                    class="text-red-500 hover:text-red-400 font-bold text-xs cursor-pointer hover:underline"
                    title="Elimina recensione">
                        Elimina
                    </button>
                </form>
            {/if}
        </div>
    </div>
</div>