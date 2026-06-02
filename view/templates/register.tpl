{extends file="main.tpl"}
{block name="content"}
    <div class="my-16">
        <div class="flex flex-col items-center justify-center">
            <h4
                class="text-2xl mb-2 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                Registrati</h4>
            <form action="" method="post" class="flex flex-col items-center justify-center">

                <input type="text" name="username" placeholder="Username"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <input type="email" name="email" placeholder="Email"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nome" placeholder="Nome"
                        class="w-[242px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                    <input type="text" name="cognome" placeholder="Cognome"
                        class="w-[242px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                </div>
                <input type="password" name="password" placeholder="Password"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <input type="password" name="password_confirm" placeholder="Conferma password"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <button type="submit"
                    class="px-4 py-2 mt-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200">Registrati</button>
            </form>
            <p class="mt-4 text-slate-400">Hai già un account? <a href="index.php?controller=Utente&action=login"
                    class="text-amber-400 font-semibold hover:text-amber-300 transition">Accedi</a></p>
        </div>
    </div>
{/block}