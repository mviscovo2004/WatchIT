/**
 * Funzione per mostrare o nascondere un modale.
 * 
 * @param {string} modalId L'ID del modale da mostrare o nascondere.
 * @param {boolean} show True per mostrare il modale, false per nasconderlo.
 * @returns {void}
 */
function toggleModal(modalId, show) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
}

/**
 * Funzione per passare da un modale all'altro.
 * 
 * @param {string} fromModalId L'ID del modale da cui passare.
 * @param {string} toModalId L'ID del modale a cui passare.
 * @returns {void}
 */
function switchModal(fromModalId, toModalId) {
    toggleModal(fromModalId, false);
    toggleModal(toModalId, true);
}



/**
 * Funzione per chiudere i modali al click esterno.
 * 
 * @param {Event} e L'evento di click.
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const activeModals = document.querySelectorAll('.fixed:not(.hidden)');
        activeModals.forEach(modal => {
            
            if (e.target === modal) {
                toggleModal(modal.id, false);
            }
        });
    });
});
