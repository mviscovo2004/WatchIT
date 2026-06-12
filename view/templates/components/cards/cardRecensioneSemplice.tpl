<div
    class="flex items-start gap-4 p-5 rounded-xl bg-slate-900/50 border border-slate-800/80 hover:border-slate-700/80 transition-all duration-300">

    <!-- Foto profilo dell'utente (tonda a sinistra) -->
    <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-800 border border-slate-700 shrink-0">
        {assign var="fotoUtente" value=$recensione->getUtente()->getFoto()}
        <img src="{if $fotoUtente && $fotoUtente[0] === '/'}https://image.tmdb.org/t/p/w185{$fotoUtente}{else}view/images/{$fotoUtente|default:"default.png"}{/if}"
            alt="{$recensione->getUtente()->getUsername()}" class="w-full h-full object-cover">
    </div>

    <!-- Contenuto della recensione a destra -->
    <div class="flex-1 min-w-0 space-y-2">
        <div class="flex items-center justify-between">
            <h4 class="font-bold text-white text-base flex items-center flex-wrap gap-2">
                {$recensione->getUtente()->getUsername()}
                <!-- Data e Ora -->
                <span
                    class="text-xs text-slate-500 font-normal">{$recensione->getDataPubblicazione()|date_format:"%d/%m/%Y %H:%M"}</span>

                <!-- Badge Stagione ed Episodio (se presente) -->
                {if $recensione->getEpisodio()}
                    <span
                        class="px-2 py-0.5 text-[10px] font-semibold rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 tracking-wider">
                        S{$recensione->getEpisodio()->getNumeroStagione()|string_format:"%02d"}E{$recensione->getEpisodio()->getNumeroEpisodio()|string_format:"%02d"}
                    </span>
                {/if}

                <!-- Bottone di eliminazione rapida per Admin o Autore -->
                {if $ruolo === 'ADMIN' || Session::get('user_id') === $recensione->getUtente()->getId()}
                    <form action="index.php?controller=Recensione&action=eliminaRecensione" method="post"
                        onsubmit="return confirm('Sei sicuro di voler eliminare questa recensione?');" class="inline"
                        onclick="event.stopPropagation();">
                        <input type="hidden" name="recensione_id" value="{$recensione->getId()}">
                        <input type="hidden" name="contenuto_id" value="{$contenutoId}">
                        {if $recensione->getEpisodio()}
                            <input type="hidden" name="episodio_id" value="{$recensione->getEpisodio()->getId()}">
                        {/if}
                        <button type="submit"
                            class="text-red-500 hover:text-red-400 font-semibold text-xs ml-2 cursor-pointer hover:underline"
                            title="Elimina recensione">
                            Elimina
                        </button>
                    </form>
                {/if}
            </h4>

            <div class="flex items-center text-amber-500 font-bold text-sm">
                <span class="mr-1">★</span>
                <span>{$recensione->getVoto()}</span>
                <span class="text-slate-500 font-normal text-xs ml-1">/ 10</span>
            </div>
        </div>

        <!-- Testo del commento -->
        <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line">
            {$recensione->getDescrizione()}
        </p>
    </div>

</div>