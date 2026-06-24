/**
 * Mostra o nasconde il modale di modifica watchlist
 * @param {boolean} show true per mostrare, false per nascondere
 */
function toggleEditWatchlistModal(show) {
    /**
     * Seleziona l'elemento HTML del modale di modifica.
     * @type {HTMLElement|null} Il modale di modifica watchlist.
     */
    const modal = document.getElementById('editWatchlistModal');
    /**
     * Mostra o nasconde il modale.
     */
    if (modal) {
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden'); 
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); 
        }
    }
}

/**
 * Mostra o nasconde il modale di creazione watchlist
 * @param {boolean} show true per mostrare, false per nascondere
 */
function toggleCreateWatchlistModal(show) {
    /**
     * Seleziona l'elemento HTML del modale di creazione.
     * @type {HTMLElement|null} Il modale di creazione watchlist.
     */
    const modal = document.getElementById('createWatchlistModal');
    /**
     * Mostra o nasconde il modale.
     */
    if (modal) {
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden'); 
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); 
        }
    }
}

/**
 * Apre il modale di modifica watchlist
 * @param {Event} event Evento del click
 * @param {number} id ID della watchlist
 * @param {string} nome Nome della watchlist
 * @param {string} descrizione Descrizione della watchlist
 * @param {string} visibilita Visibilita della watchlist
 */
function openEditModalFromList(event, id, nome, descrizione, visibilita) {
    /**
     * Ferma la propagazione dell'evento.
     */
    if (event) {
        event.stopPropagation();
    }
    /**
     * Imposta l'input di reindirizzamento.
     */
    const redirectInput = document.getElementById('edit_redirect_to');
    if (redirectInput) {
        redirectInput.value = 'lista';
    }
    /**
     * Seleziona gli elementi HTML del modale di modifica.
     * @type {HTMLElement|null} Il campo del nome della watchlist.
     * @type {HTMLElement|null} Il campo della descrizione della watchlist.
     * @type {HTMLSelectElement|null} Lo select della visibilita della watchlist.
     * @type {HTMLElement|null} Il modale di modifica watchlist.
     */
    const nomeInput = document.getElementById('edit_nome');
    const descrizioneInput = document.getElementById('edit_descrizione');
    const visibilitaSelect = document.getElementById('edit_visibilita');
    const modal = document.getElementById('editWatchlistModal');
    /**
     * Imposta i valori del modale.
     * @type {HTMLFormElement|null} Il form del modale.
     */
    if (nomeInput) nomeInput.value = nome;
    if (descrizioneInput) descrizioneInput.value = descrizione;
    if (visibilitaSelect) visibilitaSelect.value = visibilita;
    /**
     * Imposta l'action del form.
     * @type {HTMLFormElement|null} Il form del modale.
     */
    if (modal) {
        const form = modal.querySelector('form');
        if (form) {
            form.action = `index.php?controller=Watchlist&action=modifica&id=${id}`;
        }
    }

    toggleEditWatchlistModal(true);
}

/**
 * Chiude i modali quando si clicca al di fuori di essi
 */
window.addEventListener('click', function (e) {
    const editModal = document.getElementById('editWatchlistModal');
    const createModal = document.getElementById('createWatchlistModal');
    if (e.target === editModal) {
        toggleEditWatchlistModal(false);
    }
    if (e.target === createModal) {
        toggleCreateWatchlistModal(false);
    }
});

