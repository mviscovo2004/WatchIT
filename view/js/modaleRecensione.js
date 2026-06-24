/**
 * Mostra o nasconde il modale di modifica watchlist
 * @param {boolean} show true per mostrare, false per nascondere
 */
function toggleReviewModal(show) {
    /**
     * Seleziona l'elemento HTML del modale di modifica.
     * @type {HTMLElement|null} Il modale di modifica watchlist.
     */
    const modal = document.getElementById('reviewModal');
    /**
     * Mostra o nasconde il modale.
     */
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        resetReviewForm();
    }
}

/**
 * Resetta i dati del modulo e ripristina il colore grigio di base delle stelle.
 */
function resetReviewForm() {
    /**
     * Seleziona gli elementi HTML del modale di recensione.
     * @type {HTMLInputElement|null} Il campo del voto.
     * @type {HTMLElement|null} Il campo della visualizzazione del voto.
     * @type {HTMLElement|null} Il campo del commento.
     * @type {NodeList<HTMLElement>} La lista delle stelle.
     */
    const votoInput = document.getElementById('votoInput');
    const votoVisualizzato = document.getElementById('votoVisualizzato');
    const commento = document.getElementById('testo');
    const stars = document.querySelectorAll('.star-btn');
    
    /**
     * Imposta il valore del voto a vuoto.
     */
    if (votoInput) votoInput.value = '';
    /**
     * Imposta il testo della visualizzazione del voto a vuoto.
     */
    if (votoVisualizzato) votoVisualizzato.textContent = 'Nessun voto selezionato';
    /**
     * Imposta il valore del commento a vuoto.
     */
    if (commento) commento.value = '';

    /**
     * Imposta il colore delle stelle a grigio.
     */
    stars.forEach(star => {
        star.style.color = '#475569';   
    });
}

/**
 * Evento di caricamento del DOM.
 */
document.addEventListener('DOMContentLoaded', () => {
    /**
     * Seleziona gli elementi HTML del modale di recensione.
     * @type {NodeList<HTMLElement>} La lista delle stelle.
     * @type {HTMLInputElement|null} Il campo del voto.
     * @type {HTMLElement|null} Il campo della visualizzazione del voto.
     * @type {HTMLElement|null} Il modale di recensione.
     */
    const stars = document.querySelectorAll('.star-btn');
    const votoInput = document.getElementById('votoInput');
    const votoVisualizzato = document.getElementById('votoVisualizzato');
    const modal = document.getElementById('reviewModal');

    /**
     * Valore selezionato delle stelle.
     */
    let selectedRating = 0;

    /**
     * Imposta il colore delle stelle in base al voto.
     * @param {number} rating Voto selezionato.
     */
    const colorStars = (rating) => {
        stars.forEach(star => {
            const val = parseInt(star.getAttribute('data-value'));
            if (val <= rating) {
                star.style.color = '#f59e0b'; 
            } else {
                star.style.color = '#475569'; 
            }
        });
    };

    stars.forEach(star => {
        const val = parseInt(star.getAttribute('data-value'));

        /**
         * Evento quando il mouse entra nella stella.
         */
        star.addEventListener('mouseenter', () => {
            colorStars(val);
            /**
             * Imposta il testo della visualizzazione del voto.
             */
            if (votoVisualizzato) {
                votoVisualizzato.textContent = `${val} / 10`;
            }
        });

        /**
         * Evento quando il mouse esce dalla stella.
         */
        star.addEventListener('mouseleave', () => {
            colorStars(selectedRating);
            /**
             * Imposta il testo della visualizzazione del voto.
             */
            if (votoVisualizzato) {
                votoVisualizzato.textContent = selectedRating > 0 ? `${selectedRating} / 10` : 'Nessun voto selezionato';
            }
        });

        /**
         * Evento quando il mouse clicca sulla stella.
         */
        star.addEventListener('click', () => {
            selectedRating = val;
            /**
             * Imposta il valore del voto.
             */
            if (votoInput) votoInput.value = val;
            /**
             * Imposta il colore delle stelle.
             */
            colorStars(val);
        });
    });

    /**
     * Evento quando il mouse clicca fuori dal modale.
     */
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            toggleReviewModal(false);
        }
    });
});
