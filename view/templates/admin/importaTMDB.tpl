{extends file="main.tpl"}

{block name="content"}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        <h1 class="mt-10 mb-6 text-4xl font-bold text-white">Importa da TMDB</h1>
        <form action="index.php?controller=Admin&action=importaDaTMDB" method="post">
            <input type="text" name="tmdb_id" placeholder="Inserisci l'ID di TMDB"
                class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 text-white">
            <button type="submit"
                class="w-full px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">Importa</button>
        </form>
    </div>
{/block}