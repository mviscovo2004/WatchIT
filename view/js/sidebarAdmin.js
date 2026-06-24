/**
 * File JavaScript per gestire la sidebar del pannello di amministrazione.
 * @author Marco Viscovo
 */
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Array di azioni che appartengono al menu dei contenuti.
     * @type {string[]} Array di azioni del menu dei contenuti.
     */
    const contenutiActions = [
        'listaContenuti', 'aggiungiContenuto', 'inserisciContenutoDaTMDB',
        'listaFilm', 'listaSerie', 'listaAttori', 'listaRegisti'
    ];
    
    /**
     * Array di azioni che appartengono al menu degli utenti.
     * @type {string[]} Array di azioni del menu degli utenti.
     */
    const utentiActions = ['listaUtenti', 'listaUtentiBannati'];
    
    /**
     * Array di azioni che appartengono al menu delle recensioni.
     * @type {string[]} Array di azioni del menu delle recensioni.
     */
    const recensioniActions = ['listaRecensioni'];

    /**
     * Seleziona tutti i trigger del menu.
     * @type {NodeListOf<Element>} I trigger del menu.
     */
    const triggers = document.querySelectorAll('.menu-trigger');

    /**
     * Attiva i trigger del menu.
     * 
     * @param {NodeListOf<Element>} triggers I trigger del menu.
     */
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

    /**
     * Gestisce l'attivazione del menu appropriato in base all'azione corrente.
     * 
     * @param {string} action L'azione corrente.
     * @returns {void}
     */
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');

    /**
     * Seleziona l'azione corrente.
     * @type {string|null} L'azione corrente.
     */
    if (action) {
        /**
         * ID del menu attivo.
         * @type {string|null} L'ID del menu attivo.
         */
        let activeMenuId = null;

        /**
         * Array di azioni che appartengono al menu dei contenuti.
         * @type {string[]} Array di azioni del menu dei contenuti.
         */
        const contenutiActions = [
            'listaContenuti', 'aggiungiContenuto', 'inserisciContenutoDaTMDB',
            'listaFilm', 'listaSerie', 'listaAttori', 'listaRegisti'
        ];

        /**
         * Array di azioni che appartengono al menu degli utenti.
         * @type {string[]} Array di azioni del menu degli utenti.
         */
        const utentiActions = ['listaUtenti', 'listaUtentiBannati'];

        /**
         * Array di azioni che appartengono al menu delle recensioni.
         * @type {string[]} Array di azioni del menu delle recensioni.
         */
        const recensioniActions = ['listaRecensioni'];

        /**
         * Seleziona l'ID del menu attivo in base all'azione corrente.
         * 
         * @param {string} action L'azione corrente.
         * @returns {string|null} L'ID del menu attivo.
         */
        if (contenutiActions.includes(action)) {
            activeMenuId = 'submenu-contenuti';
        } else if (utentiActions.includes(action)) {
            activeMenuId = 'submenu-utenti';
        } else if (recensioniActions.includes(action)) {
            activeMenuId = 'submenu-recensioni';
        }

        /**
         * Attiva il menu attivo.
         * 
         * @param {string} activeMenuId ID del menu attivo.
         * @returns {void}
         */
        if (activeMenuId) {
            /**
             * Seleziona il menu attivo.
             * @type {HTMLElement|null} Il menu attivo.
             */
            const activeMenu = document.getElementById(activeMenuId);
            if (activeMenu) {
                activeMenu.classList.remove('hidden');
                /**
                 * Seleziona il trigger del menu attivo.
                 * @type {HTMLElement|null} Il trigger del menu attivo.
                 */
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
