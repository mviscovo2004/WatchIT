{extends file="main.tpl"}
{block name="content"}
    <div class="my-16">
        <div class="flex flex-col items-center justify-center">
            <h4
                class="text-2xl mb-2 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                Accedi</h4>
            <form action="" method="post" class="flex flex-col items-center justify-center">
                <input type="text" name="identificativo" placeholder="Username/Email"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <input type="password" name="password" placeholder="Password"
                    class="w-[500px] px-6 py-2.5 my-2 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 placeholder-slate-500">
                <div class="flex justify my-2">
                    <a href="#" class="text-slate-400 hover:text-red-500 text-sm transition-all">Password
                        dimenticata?</a>
                </div>
                <button type="submit"
                    class="px-4 py-2 mt-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200">Accedi</button>
            </form>
            <p class="mt-4 text-slate-400">Non hai un account? <a href="index.php?controller=Utente&action=registrazione"
                    class="text-amber-400 font-semibold hover:text-amber-300 transition">Registrati</a>
            </p>
        </div>
    </div>
{/block}