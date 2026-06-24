{*
 * Template Main (Layout Base)
 * 
 * Definisce l'ossatura HTML5 comune a tutte le pagine dell'applicazione.
 * Gestisce l'importazione dei CSS di Tailwind, la navbar globale, il footer
 * e l'inclusione dinamica dei modali di login, registrazione e gestione watchlist.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param string $baseUrl URL di base del sito per i percorsi relativi.
 * @param bool $isLogged Stato di autenticazione dell'utente corrente.
 * @param bool|null $showLogin Flag per forzare l'apertura del modale di login.
 * @param bool|null $showRegister Flag per forzare l'apertura del modale di registrazione.
 * @param string|null $loginError Eventuale messaggio di errore di login da visualizzare.
 * @param string|null $registerError Eventuale messaggio di errore di registrazione da visualizzare.
 * 
 * @block title Titolo dinamico della pagina (default: WatchIT).
 * @block content Contenuto principale specifico di ogni pagina.
 *}
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}WatchIT{/block}</title>
    <link href="{$baseUrl}/output.css" rel="stylesheet">
    <base href="{$baseUrl}/">
</head>

<body class="bg-slate-950 text-white flex flex-col min-h-screen">

    {include file="components/navbar.tpl"}
    <main class="flex-grow">
        {block name="content"}



        {/block}
    </main>

    {include file="components/footer.tpl"}


    {if !$isLogged}


        {assign var="showLogin" value=$showLogin|default:false}
        {assign var="showRegister" value=$showRegister|default:false}
        {if isset($loginError)}
            {assign var="showLogin" value=true}
        {/if}
        {if isset($registerError)}
            {assign var="showRegister" value=true}
        {/if}

        {include file="components/modali/modaleLogin.tpl"}
        {include file="components/modali/modaleRegistrazione.tpl"}
        {include file="components/modali/modaleRecuperaPassword.tpl"}


    {/if}
    {if $isLogged}
        {include file="components/modali/modaleWatchlist.tpl"}
    {/if}

</html>