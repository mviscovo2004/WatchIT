{*
 * Template Reset Password
 * 
 * Fornisce l'interfaccia utente per inserire e confermare una nuova password 
 * dopo aver seguito il link di ripristino ricevuto via email.
 * Estende il layout base `main.tpl`.
 * 
 * @package View/Templates
 * @author Marco Viscovo
 * 
 * @param string $token Il token di sicurezza associato alla richiesta di ripristino.
 * @param string|null $error Messaggio di errore riscontrato o di successo ad operazione completata.
 *}
{extends file="main.tpl"}
{block name="content"}
    <div class="my-16 flex flex-col items-center justify-center">
        <div class="bg-slate-950 border border-slate-800/80 p-8 rounded-2xl max-w-md w-full relative shadow-2xl">
            <div class="flex flex-col items-center justify-center">
                <h4
                    class="text-2xl mb-6 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                    Nuova Password
                </h4>


                {include file="components/alert.tpl" message=$error type={if $error === "Password reimpostata con successo."}"success"
            {else}"error"
            {/if}}


            {if !isset($error) || $error !== "Password reimpostata con successo."}
                <form action="index.php?controller=Utente&action=resetPassword&token={$token}" method="post"
                    class="flex flex-col items-center justify-center w-full space-y-4">
                    <input type="password" name="password" placeholder="Nuova Password" required
                        class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">

                    <input type="password" name="password_confirm" placeholder="Conferma nuova password" required
                        class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">

                    <button type="submit"
                        class="w-full py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">
                        Reimposta Password
                    </button>
                </form>
            {else}

                <button onclick="toggleModal('loginModal', true)"
                    class="w-full py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">
                    Accedi Ora
                </button>
            {/if}
        </div>
    </div>
</div>
{/block}