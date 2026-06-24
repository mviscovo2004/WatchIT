/**
 * Apri il modale per bannare un utente.
 * @param {number} userId L'ID dell'utente da bannare.
 * @param {string} username Il nome utente dell'utente da bannare.
 * @returns {void}
 */
function openBanModal(userId, username) {
    /**
     * Seleziona gli elementi HTML del modale di ban.
     * @type {HTMLElement|null} Il modale di ban.
     * @type {HTMLElement|null} Il container del modale di ban.
     * @type {HTMLElement|null} Il nome dell'utente da bannare.
     * @type {HTMLElement|null} L'input dell'ID utente da bannare.
     */
    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');
    const targetName = document.getElementById('banTargetName');
    const userIdInput = document.getElementById('banUserId');

    if (!modal || !container) return;

    if (targetName) targetName.textContent = username;
    if (userIdInput) userIdInput.value = userId;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

/**
 * Chiudi il modale di ban.
 * 
 * @returns {void}
 */
function closeBanModal() {
    /**
     * Seleziona gli elementi HTML del modale di ban.
     * @type {HTMLElement|null} Il modale di ban.
     * @type {HTMLElement|null} Il container del modale di ban.
     * @type {HTMLElement|null} La textarea del motivo del ban.
     */
    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');
    const motivoTextarea = document.getElementById('banMotivo');

    if (!modal || !container) return;

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        if (motivoTextarea) motivoTextarea.value = '';
    }, 300);
}

/**
 * Sottometti il form di ban.
 * 
 * @param {Event} event L'evento di submit del form.
 * @returns {void}
 */
function submitBanForm(event) {
    event.preventDefault();
    /**
     * Seleziona gli elementi HTML del form di ban.
     * @type {HTMLElement|null} Il form di ban.
     * @type {string|null} L'ID dell'utente da bannare.
     * @type {string|null} La durata del ban.
     */
    const form = document.getElementById('banForm');
    const userId = document.getElementById('banUserId').value;
    const durata = document.getElementById('banDurata').value;

    if (form && userId && durata) {

        form.action = `index.php?controller=Admin&action=banUtente&idUtente=${userId}&durata=${durata}`;
        form.submit();
    }
}

/**
 * Apri il modale per sbannare un utente.
 * 
 * @param {number} userId L'ID dell'utente da sbannare.
 * @param {string} username Il nome utente dell'utente da sbannare.
 * @returns {void}
 */
function openUnbanModal(userId, username) {
    /**
     * Seleziona gli elementi HTML del modale di unban.
     * @type {HTMLElement|null} Il modale di unban.
     * @type {HTMLElement|null} Il container del modale di unban.
     * @type {HTMLElement|null} Il nome dell'utente da sbannare.
     * @type {HTMLElement|null} Il pulsante di conferma del unban.
     */
    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');
    const targetName = document.getElementById('unbanTargetName');
    const confirmBtn = document.getElementById('unbanConfirmBtn');
    /**
     * Controlla che il modale e il container siano stati trovati.
     */
    if (!modal || !container) return;
    /**
     * Inserisce il nome dell'utente da sbannare nel modale.
     */
    if (targetName) targetName.textContent = username;
    /**
     * Inserisce il link per sbannare l'utente nel pulsante di conferma.
     */
    if (confirmBtn) {
        confirmBtn.href = `index.php?controller=Admin&action=unbanUtente&idUtente=${userId}`;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    /**
     * Aggiunge le classi per animare l'apertura del modale.
     */
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

/**
 * Chiudi il modale di unban.
 * 
 * @returns {void}
 */
function closeUnbanModal() {
    /**
     * Seleziona gli elementi HTML del modale di unban.
     * @type {HTMLElement|null} Il modale di unban.
     * @type {HTMLElement|null} Il container del modale di unban.
     */
    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');
    /**
     * Controlla che il modale e il container siano stati trovati.
     */
    if (!modal || !container) return;

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    /**
     * Aggiunge le classi per animare la chiusura del modale.
     */
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

/**
 * Gestisce la chiusura dei modali di ban e unban quando l'utente clicca fuori da essi.
 * 
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', () => {
    /**
     * Aggiunge un event listener per il click sul documento.
     * Chiude il modale di ban o unban se l'utente clicca fuori da esso.
     * 
     * @param {MouseEvent} e L'evento del click.
     * @returns {void}
     */
    window.addEventListener('click', function(e) {
        const banModal = document.getElementById('banModal');
        const unbanModal = document.getElementById('unbanModal');

        if (e.target === banModal) {
            closeBanModal();
        }
        if (e.target === unbanModal) {
            closeUnbanModal();
        }
    });
});
