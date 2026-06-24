/**
 * Funzione per aprire un modale.
 * 
 * @param {string} modalId L'ID del modale da aprire.
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('hidden');
    
    setTimeout(() => {
        const dialog = modal.querySelector('div');
        if (dialog) {
            dialog.classList.remove('scale-95', 'opacity-0');
            dialog.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}


/**
 * Funzione per chiudere un modale.
 * 
 * @param {string} modalId L'ID del modale da chiudere.
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const dialog = modal.querySelector('div');
    if (dialog) {
        dialog.classList.remove('scale-100', 'opacity-100');
        dialog.classList.add('scale-95', 'opacity-0');
    }

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

/**
 * Funzione per alternare i campi del modale in base al tipo di contenuto.
 * 
 * @param {string} prefix Il prefisso del modale.
 */
function toggleTipoCampi(prefix) {
    /**
     * Seleziona l'elemento del tipo di contenuto.
     * @type {HTMLElement|null} L'elemento del tipo di contenuto.
     */
    const tipoSelect = document.getElementById(`${prefix}-tipo`);
    /**
     * Seleziona gli elementi del modale per i film.
     * @type {HTMLElement|null} Gli elementi del modale per i film.
     */
    const campiFilm = document.getElementById(`${prefix}-campi-film`);
    /**
     * Seleziona gli elementi del modale per le serie.
     * @type {HTMLElement|null} Gli elementi del modale per le serie.
     */
    const campiSerie = document.getElementById(`${prefix}-campi-serie`);
    /**
     * Seleziona l'elemento input per la durata.
     * @type {HTMLElement|null} L'elemento input per la durata.
     */
    const inputDurata = document.getElementById(`${prefix}-durata`);
    /**
     * Seleziona l'elemento input per le stagioni.
     * @type {HTMLElement|null} L'elemento input per le stagioni.
     */
    const inputStagioni = document.getElementById(`${prefix}-stagioni`);

    if (!tipoSelect) return;    

    /**
     * Mostra i campi del modale per i film.
     * @param {HTMLElement|null} campiFilm Gli elementi del modale per i film.
     * @param {HTMLElement|null} campiSerie Gli elementi del modale per le serie.
     */
    if (tipoSelect.value === 'film') {
        if (campiFilm) campiFilm.classList.remove('hidden');
        if (campiSerie) campiSerie.classList.add('hidden');
        
        
        if (inputDurata) inputDurata.setAttribute('required', 'required');
        if (inputStagioni) inputStagioni.removeAttribute('required');
    } else {
        if (campiFilm) campiFilm.classList.add('hidden');
        if (campiSerie) campiSerie.classList.remove('hidden');
        

        if (inputDurata) inputDurata.removeAttribute('required');
        if (inputStagioni) inputStagioni.setAttribute('required', 'required');
    }
}

/**
 * Funzione per chiudere il modale quando si clicca al di fuori di esso.
 * 
 * @param {Event} e L'evento di click.
 */
document.addEventListener('DOMContentLoaded', () => {
    toggleTipoCampi('add');

    /**
     * Funzione per chiudere il modale quando si clicca al di fuori di esso.
     * 
     * @param {Event} e L'evento di click.
     */
    window.addEventListener('click', function(e) {
        /**
         * Seleziona i modali attivi.
         * @type {NodeListOf<Element>|null} I modali attivi.
         */
        const activeModals = document.querySelectorAll('.fixed:not(.hidden)');
        
        /**
         * Chiude il modale quando si clicca al di fuori di esso.
         * 
         * @param {Element} modal Il modale da chiudere.
         */
        activeModals.forEach(modal => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
});
