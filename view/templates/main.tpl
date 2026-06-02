<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}WatchIT{/block}</title>
    <link href="/WatchIT/output.css" rel="stylesheet">
</head>

<body class="bg-slate-950 text-white flex flex-col min-h-screen">

    {include file="navbar.tpl"}
    <main class="flex-grow">
        {block name="content"} {/block}
    </main>
    {include file="footer.tpl"}
</body>

</html>