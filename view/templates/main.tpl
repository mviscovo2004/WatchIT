<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}WatchIT{/block}</title>
    <link href="{$baseUrl}/output.css" rel="stylesheet">
</head>

<body class="bg-slate-950 text-white flex flex-col min-h-screen">

    {include file="navbar.tpl"}
    <main class="flex-grow">
        {block name="content"}

            {include file="modaleWatchlist.tpl"}

        {/block}
    </main>

    {include file="footer.tpl"}


    {if !$isLogged}
        <!-- Logica Smarty per rilevare errori e determinare quale modale riaprire all'avvio -->
        <!-- Logica Smarty per rilevare errori dalle sessioni e riaprire il modale corretto all'avvio -->
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

</html>