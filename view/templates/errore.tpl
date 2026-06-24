{*
 * Template Errore Generico
 * 
 * Visualizza una schermata di avviso per un errore generico dell'applicazione (es. ID non valido, risorsa mancante).
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param string $errore Il messaggio di errore dettagliato da mostrare.
 *}
{extends file="main.tpl"}

{block name="content"}
    <div
        class="max-w-md mx-auto my-12 p-8 rounded-2xl bg-slate-900 border border-slate-800 text-center shadow-2xl space-y-6">

        <div
            class="w-16 h-16 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>


        <div class="space-y-2">
            <h3 class="text-xl font-bold text-white">Si è verificato un errore</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                {$errore|default:"Si è verificato un errore imprevisto durante l'operazione."}
            </p>
        </div>


        <div class="pt-4 border-t border-slate-800/60 flex justify-center">
            <a href="index.php"
                class="px-6 py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20 hover:scale-105 active:scale-95">
                Torna alla Home
            </a>
        </div>
    </div>
{/block}