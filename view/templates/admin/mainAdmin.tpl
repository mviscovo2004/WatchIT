{*
 * Vista Layout Base Amministrazione
 * 
 * Fornisce la struttura e lo stile base comune del pannello di controllo admin.
 * Integra la sidebar amministrativa e il pannello principale di navigazione.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 * 
 * @param bool $isLogged Stato di autenticazione dell'utente.
 * @param string $ruolo Ruolo dell'utente loggato (deve essere ADMIN).
 *}
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}WatchIT{/block}</title>
    <link href="{$baseUrl}/output.css" rel="stylesheet">
    <base href="{$baseUrl}/">
    </base>
</head>

<body class="bg-slate-950 text-white flex flex-row min-h-screen">

    {if $isLogged && $ruolo == 'ADMIN'}
        <aside class="w-64 min-h-screen h-screen sticky top-0 flex-shrink-0">
            {include file="components/sidebar.tpl"}
        </aside>

        <main class="flex-grow p-8 overflow-y-auto min-h-screen">
            {block name="content"} {/block}
        </main>
    {else}
        {include file="admin/accessoNegato.tpl"}
    {/if}


</html>