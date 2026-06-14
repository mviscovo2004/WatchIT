document.addEventListener('DOMContentLoaded', function() {
    const triggers = document.querySelectorAll('.menu-trigger');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const targetMenu = document.getElementById(targetId);
            const chevron = this.querySelector('.chevron');

            if (targetMenu.classList.contains('hidden')) {
                targetMenu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            } else {
                targetMenu.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');

    if (action) {
        let activeMenuId = null;

        const contenutiActions = [
            'listaContenuti', 'aggiungiContenuto', 'inserisciContenutoDaTMDB',
            'listaFilm', 'listaSerie', 'listaAttori', 'listaRegisti'
        ];
        const utentiActions = ['listaUtenti', 'listaUtentiBannati'];
        const recensioniActions = ['listaRecensioni'];

        if (contenutiActions.includes(action)) {
            activeMenuId = 'submenu-contenuti';
        } else if (utentiActions.includes(action)) {
            activeMenuId = 'submenu-utenti';
        } else if (recensioniActions.includes(action)) {
            activeMenuId = 'submenu-recensioni';
        }

        if (activeMenuId) {
            const activeMenu = document.getElementById(activeMenuId);
            if (activeMenu) {
                activeMenu.classList.remove('hidden');
                const trigger = document.querySelector(`.menu-trigger[data-target="${activeMenuId}"]`);
                if (trigger) {
                    const chevron = trigger.querySelector('.chevron');
                    if (chevron) {
                        chevron.classList.add('rotate-180');
                    }
                }
            }
        }
    }
});
