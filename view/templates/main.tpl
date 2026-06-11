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
        {block name="content"} {/block}
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


        <!-- MODALE LOGIN -->
        <div id="loginModal"
            class="fixed inset-0 z-50 {if $showLogin}flex{else}hidden{/if} items-center justify-center bg-black/70 backdrop-blur-sm p-4">
            <div class="bg-slate-950 border border-slate-800/80 p-8 rounded-2xl max-w-md w-full relative shadow-2xl">
                <!-- Tasto di chiusura -->
                <button onclick="toggleModal('loginModal', false)"
                    class="absolute top-4 right-4 text-slate-400 hover:text-white text-2xl font-bold transition focus:outline-none">&times;</button>

                <div class="flex flex-col items-center justify-center">
                    <h4
                        class="text-2xl mb-6 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                        Accedi
                    </h4>

                    <!-- Box Messaggio Errore Login -->
                    {if isset($loginError)}
                        <div
                            class="w-full p-3 mb-4 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl text-center">
                            {$loginError}
                        </div>
                    {/if}

                    <form action="index.php?controller=Utente&action=login" method="post"
                        class="flex flex-col items-center justify-center w-full space-y-4">
                        <input type="text" name="identificativo" placeholder="Username/Email" required
                            value="{$smarty.post.identificativo|default:''|escape}"
                            class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                        <input type="password" name="password" placeholder="Password" required
                            class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">

                        <div class="flex justify-end w-full">
                            <button type="button" onclick="switchModal('loginModal','recuperaPasswordModal')"
                                class="text-slate-400 hover:text-yellow-400 text-xs transition-all">Password
                                dimenticata?</button>
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">
                            Accedi
                        </button>
                    </form>
                    <p class="mt-6 text-sm text-slate-400">
                        Non hai un account?
                        <button onclick="switchModal('loginModal', 'registerModal')"
                            class="text-amber-400 font-semibold hover:text-amber-300 transition focus:outline-none">
                            Registrati
                        </button>
                    </p>
                </div>
            </div>
        </div>

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
                    {if isset($registerError)}
                        <div
                            class="w-full p-3 mb-4 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl text-center">
                            {$registerError}
                        </div>
                    {/if}

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

        <div id="recuperaPasswordModal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
            <div class="bg-slate-950 border border-slate-800/80 p-8 rounded-2xl max-w-md w-full relative shadow-2xl">
                <!-- Tasto di chiusura -->
                <button onclick="toggleModal('recuperaPasswordModal', false)"
                    class="absolute top-4 right-4 text-slate-400 hover:text-white text-2xl font-bold transition focus:outline-none">&times;</button>

                <div class="flex flex-col items-center justify-center">
                    <h4
                        class="text-2xl mb-6 font-black tracking-wider bg-gradient-to-r from-purple-600 to-amber-500 text-transparent bg-clip-text">
                        Recupera password
                    </h4>

                    <form action="index.php?controller=Utente&action=forgotPassword" method="post"
                        class="flex flex-col items-center justify-center w-full space-y-4">
                        <input type="email" name="email" placeholder="Email" required
                            value="{$smarty.post.email|default:''|escape}"
                            class="w-full px-6 py-2.5 rounded-full bg-slate-900 border border-slate-800 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all duration-200 placeholder-slate-500 text-white">
                        <button type="submit"
                            class="w-full py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-purple-600/20">
                            Recupera password
                        </button>
                    </form>
                    <p class="mt-6 text-sm text-slate-400">
                        Hai già un account?
                        <button onclick="switchModal('recuperaPasswordModal', 'loginModal')"
                            class="text-amber-400 font-semibold hover:text-amber-300 transition focus:outline-none">
                            Accedi
                        </button>
                    </p>
                </div>
            </div>
        </div>



        <script>
            function toggleModal(modalId, show) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    if (show) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.classList.add('overflow-hidden'); // Disabilita scroll
                    } else {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden'); // Riabilita scroll

                        // Se l'utente chiude il modale trovandosi su una pagina di errore (/action=login o /action=registrazione), viene reindirizzato in Home
                    const urlParams = new URLSearchParams(window.location.search);
                    const action = urlParams.get('action');
                    if (action === 'login' || action === 'registrazione') {
                        window.location.href = 'index.php';
                    }
                }
            }
        }

        function switchModal(fromModalId, toModalId) {
            toggleModal(fromModalId, false);
            toggleModal(toModalId, true);
        }

        // Chiudi i modali cliccando sullo sfondo oscurato
        window.addEventListener('click', function(e) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            if (e.target === loginModal) {
                toggleModal('loginModal', false);
            }
            if (e.target === registerModal) {
                toggleModal('registerModal', false);
            }
        });
        // Controllo corrispondenza password lato client
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const password = document.getElementById('registerPassword').value;
                const passwordConfirm = document.getElementById('password_confirm').value;

                if (password !== passwordConfirm) {
                    e.preventDefault(); // Blocca l'invio del form al server

                        // Cerca o crea il box per gli errori grafici
                        let errorBox = document.getElementById('jsRegisterErrorBox');
                        if (!errorBox) {
                            errorBox = document.createElement('div');
                            errorBox.id = 'jsRegisterErrorBox';
                            errorBox.className =
                                'w-full p-3 mb-4 text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl text-center';
                            // Inseriamo l'errore prima dei campi del form
                        this.parentNode.insertBefore(errorBox, this);
                    }
                    errorBox.textContent = 'Le password inserite non coincidono.';

                    // Rimuove eventuali vecchi messaggi di errore inviati dal server per non duplicarli
                    const serverErrorBox = document.querySelector('#registerModal .bg-red-500\\/10');
                        if (serverErrorBox && serverErrorBox !== errorBox) {
                            serverErrorBox.remove();
                        }
                    }
                });
            }
        </script>
    {/if}

</html>