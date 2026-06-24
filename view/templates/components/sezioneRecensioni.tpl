{*
 * Componente Sezione Recensioni
 * 
 * Mostra il modulo per scrivere una nuova recensione (se l'utente è loggato)
 * e l'elenco di tutte le recensioni già lasciate per il contenuto.
 * 
 * @package View/Templates/Components
 * @author Marco Viscovo
 * 
 * @param ERecensione[] $recensioni Array delle recensioni lasciate per questa risorsa.
 * @param bool $isLogged Indica se l'utente corrente è autenticato.
 *}
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