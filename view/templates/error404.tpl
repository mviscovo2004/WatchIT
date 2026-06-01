<!DOCTYPE html>
    <html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Pagina non trovata | WatchIT</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>

    <body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Effetti sfumati premium nello sfondo -->
        <div class="absolute w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[120px] -top-40 -left-40 pointer-events-none"></div>
        <div class="absolute w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px] -bottom-40 -right-40 pointer-events-none"></div>
        <div class="max-w-md w-full px-6 text-center z-10">
            <!-- Badge 404 -->
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-500/10 text-red-500 text-sm font-semibold border border-red-500/20 mb-6 tracking-wide uppercase">
                Errore 404
            </div>

            <h1 class="text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-indigo-500 tracking-tight mb-4">
                Oops!
            </h1>

            <h2 class="text-2xl font-bold text-white mb-3">
                Pagina non trovata
            </h2>

            <p class="text-slate-400 mb-8 leading-relaxed">
                La risorsa che stai cercando potrebbe essere stata rimossa, aver cambiato nome o essere temporaneamente non disponibile.
            </p>

            <!-- Bottone di ritorno alla home -->
            <a href="/WatchIT/index.php"
                class="inline-block px-8 py-3.5 rounded-xl bg-gradient-to-r from-red-600 to-indigo-600 hover:from-red-500 hover:to-indigo-500 text-white font-semibold transition-all duration-300 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/35 transform hover:-translate-y-0.5">
                Torna alla Home
            </a>
        </div>
    </body>
</html>