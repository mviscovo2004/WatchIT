{*
 * Vista Accesso Negato (403 Forbidden)
 * 
 * Pagina mostrata quando un utente non amministratore tenta di accedere
 * a risorse o azioni riservate all'amministratore.
 * 
 * @package View/Templates/Admin
 * @author Marco Viscovo
 *}
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso Negato | WatchIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    <base href="{$baseUrl}/">
    </base>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center relative overflow-hidden">

    <div
        class="absolute w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[120px] -top-40 -left-40 pointer-events-none">
    </div>
    <div
        class="absolute w-[500px] h-[500px] bg-amber-600/10 rounded-full blur-[120px] -bottom-40 -right-40 pointer-events-none">
    </div>
    <div class="max-w-md w-full px-6 text-center z-10">

        <div
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/10 text-amber-500 text-sm font-semibold border border-red-500/20 mb-6 tracking-wide uppercase">
            Errore 403
        </div>

        <h1
            class="text-6xl p-2  font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-amber-500  tracking-tight mb-4">
            Accesso Negato
        </h1>

        <h2 class="text-2xl font-bold text-white mb-3">
            Non hai i permessi per accedere a questa pagina
        </h2>

        <p class="text-slate-400 mb-8  leading-relaxed">
            Non hai i permessi per accedere a questa pagina.
            Se pensi che sia un errore, contatta l'amministratore.
        </p>


        <a href="{$baseUrl}/index.php"
            class="inline-block px-8 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-amber-500 hover:from-purple-500 hover:to-amber-500 text-white font-semibold transition-all duration-300 shadow-lg shadow-purple-600/20 hover:shadow-amber-600/35 transform hover:-translate-y-0.5">
            Torna alla Home
        </a>
    </div>
</body>

</html>