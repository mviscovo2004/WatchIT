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
window.addEventListener('click', function (e) {
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
        