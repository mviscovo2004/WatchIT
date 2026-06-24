/**
 * Apri il modale di modifica per un contenuto.
 * 
 * @param {string} modalId L'ID del modale da aprire.
 * @returns {void}
 */
if (typeof openModal !== 'function') {
    window.openModal = function(modalId) {
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
    };
}

/**
 * Chiudi il modale di modifica.
 * 
 * @param {string} modalId L'ID del modale da chiudere.
 * @returns {void}
 */
if (typeof closeModal !== 'function') {
    window.closeModal = function(modalId) {
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
    };
}

/**
 * Apri il modale di modifica per un contenuto.
 * 
 * @param {number} id L'ID del contenuto da modificare.
 * @returns {void}
 */
function openModificaContenutoModal(id) {
    /**
     * Apri il modale di modifica.
     */
    openModal('modalModificaContenuto');
    
    /**
     * Seleziona gli elementi HTML del modale di modifica.
     * @type {HTMLElement|null} Il loader del modale.
     * @type {HTMLElement|null} Il form del modale.
     */
    const loader = document.getElementById('editLoader');
    const form = document.getElementById('formModificaContenuto');
    
    /**
     * Mostra il loader e nasconde il form.
     */
    if (loader) loader.classList.remove('hidden');
    if (form) form.classList.add('hidden');

    fetch(`index.php?controller=Admin&action=dettagliContenutoAjax&id=${id}`)
        .then(response => {
            /**
             * Controlla che la risposta sia andata a buon fine.
             */
            if (!response.ok) {
                throw new Error("Errore nel recupero dati");
            }
            /**
             * Converte la risposta in JSON.
             * @type {object} I dati del contenuto.
             * @returns {Promise<object>} La promise con i dati del contenuto.
             */
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                closeModal('modalModificaContenuto');
                return;
            }
            /**
             * Inserisce i dati del contenuto nei campi del modale.
             */
            document.getElementById('edit-id').value = data.id;
            document.getElementById('edit-tipo-hidden').value = data.tipo;
            document.getElementById('edit-tipo').value = data.tipo;
            document.getElementById('edit-titolo').value = data.titolo;
            document.getElementById('edit-anno').value = data.anno;
            document.getElementById('edit-valutazione').value = data.valutazioneMedia;
            document.getElementById('edit-locandina').value = data.locandina || '';
            document.getElementById('edit-regista').value = data.regista || '';
            document.getElementById('edit-attori').value = data.attori || '';
            document.getElementById('edit-trama').value = data.trama || '';

            /**
             * Seleziona gli elementi HTML del modale di modifica.
             * @type {HTMLElement|null} I campi del modale dedicati ai film.
             * @type {HTMLElement|null} I campi del modale dedicati alle serie TV.
             * @type {HTMLElement|null} L'input della durata per i film.
             * @type {HTMLElement|null} L'input del numero di stagioni per le serie TV.
             * @type {HTMLSelectElement|null} Lo select dello stato per le serie TV.
             */
            const campiFilm = document.getElementById('edit-campi-film');
            const campiSerie = document.getElementById('edit-campi-serie');
            const inputDurata = document.getElementById('edit-durata');
            const inputStagioni = document.getElementById('edit-stagioni');
            const selectStato = document.getElementById('edit-stato');

            /**
             * Mostra i campi del modale dedicati ai film e nasconde quelli dedicati alle serie TV.
             */
            if (data.tipo === 'film') {
                if (campiFilm) campiFilm.classList.remove('hidden');
                if (campiSerie) campiSerie.classList.add('hidden');
                /**
                 * Inserisce la durata del film nel campo del modale.
                 */
                if (inputDurata) {
                    inputDurata.value = data.durataMinuti || '';
                    inputDurata.setAttribute('required', 'required');
                }
                if (inputStagioni) inputStagioni.removeAttribute('required');
            } else {
                if (campiFilm) campiFilm.classList.add('hidden');
                if (campiSerie) campiSerie.classList.remove('hidden');
                if (inputStagioni) {
                    inputStagioni.value = data.numeroStagioni || '';
                    inputStagioni.setAttribute('required', 'required');
                }
                if (selectStato) selectStato.value = data.stato || 'in_corso';
                if (inputDurata) inputDurata.removeAttribute('required');
            }

            /**
             * Deseleziona tutti i checkbox dei generi.
             */
            const checkboxes = form.querySelectorAll('input[name="generi[]"]');
            checkboxes.forEach(cb => {
                cb.checked = false;
            });

            /**
             * Seleziona i checkbox dei generi corrispondenti ai generi del contenuto.
             */
            if (data.generi && Array.isArray(data.generi)) {
                data.generi.forEach(g => {
                    const cb = document.getElementById(`edit-genere-${g.toLowerCase()}`);
                    if (cb) {
                        cb.checked = true;
                    }
                });
            }

            /**
             * Nasconde il loader e mostra il form.
             */
            if (loader) loader.classList.add('hidden');
            if (form) form.classList.remove('hidden');
        })
        .catch(err => {
            /**
             * Mostra un messaggio di errore se i dettagli del contenuto non possono essere caricati.
             */
            console.error(err);
            alert("Impossibile caricare i dettagli del contenuto.");
            closeModal('modalModificaContenuto');
        });
}

/**
 * Chiudi il modale di modifica quando si clicca al di fuori del modale.
 */
document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalModificaContenuto');
        if (e.target === modal) {
            closeModal('modalModificaContenuto');
        }
    });
});
