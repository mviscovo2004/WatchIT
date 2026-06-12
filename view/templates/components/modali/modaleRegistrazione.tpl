<!-- MODALE REGISTRAZIONE -->
<div id="registerModal"
    class="fixed inset-0 z-50 {if $showRegister}flex{else}hidden{/if} items-center justify-center bg-black/70 backdrop-blur-sm p-4">
    <div class="bg-slate-950 border border-slate-800/80 p-8 rounded-2xl max-w-md w-full relative shadow-2xl">
        <!-- Tasto di chiusura -->
        <button onclick="toggleModal('registerModal', false)"
            class="absolute top-4 right-4 text-slate-400 hover:text-white text-2xl font-bold transition focus:outline-none">&times;</button>

        <div class="flex flex-col items-center justify-center">
            <h4
                class="text-2xl mb-6 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                Registrati
            </h4>

            <!-- Box Messaggio Errore Registrazione -->
            {include file="components/alert.tpl" message=$registerError type="error"}

            <form action="index.php?controller=Utente&action=registrazione" method="post"
                class="flex flex-col items-center justify-center w-full space-y-4">
                <input type="text" name="username" placeholder="Username" required
                    value="{$smarty.post.username|default:''|escape}"
                    class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                <input type="email" name="email" placeholder="Email" required
                    value="{$smarty.post.email|default:''|escape}"
                    class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">

                <div class="grid grid-cols-2 gap-4 w-full">
                    <input type="text" name="nome" placeholder="Nome" required
                        value="{$smarty.post.nome|default:''|escape}"
                        class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                    <input type="text" name="cognome" placeholder="Cognome" required
                        value="{$smarty.post.cognome|default:''|escape}"
                        class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                </div>

                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                <input type="password" name="password_confirm" placeholder="Conferma password" required
                    class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">

                <button type="submit"
                    class="w-full py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">
                    Registrati
                </button>
            </form>
            <p class="mt-6 text-sm text-slate-400">
                Hai già un account?
                <button onclick="switchModal('registerModal', 'loginModal')"
                    class="text-amber-400 font-semibold hover:text-amber-300 transition focus:outline-none">
                    Accedi
                </button>
            </p>
        </div>
    </div>
</div>

<script src="{$baseUrl}/view/js/modaleAutenticazione.js"></script>