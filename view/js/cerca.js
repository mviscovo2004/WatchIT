/**
 * Funzione per eliminare un contenuto dal database.
 * 
 * @param {number} id L'ID del contenuto da eliminare.
 */
function eliminaContenuto(id) {
    if (confirm(
            "Sei sicuro di voler eliminare permanentemente questo contenuto? Questa azione rimuoverà anche tutte le visualizzazioni, recensioni, partecipazioni e inserimenti in watchlist ad esso associati."
        )) {
        window.location.href = "?controller=Admin&action=eliminaContenuto&id=" + id;
    }
}

/**
 * Funzione per cercare contenuti nel DOM.
 * 
 * @param {string} query La query di ricerca.
 * @param {Array<Object>} contentItems Gli elementi da cercare.
 * @param {HTMLElement} searchCount L'elemento dove mostrare il conteggio.
 * @param {number} totalCount Il conteggio totale.
 */
document.addEventListener('DOMContentLoaded', function () {

    /**
     * Seleziona l'elemento di input per la ricerca.
     * @type {HTMLElement|null} L'elemento di input per la ricerca.
     */
    const searchInput = document.getElementById('search-input');
    /**
     * Seleziona tutti gli elementi del carosello.
     * @type {NodeListOf<Element>|null} Gli elementi del carosello.
     */
    const contentItems = document.querySelectorAll('.content-item');
    /**
     * Seleziona l'elemento dove mostrare il conteggio.
     * @type {HTMLElement|null} L'elemento dove mostrare il conteggio.
     */
    const searchCount = document.getElementById('search-count');
    /**
     * Conteggio totale degli elementi del carosello.
     * @type {number} Il conteggio totale degli elementi del carosello.
     */
    const totalCount = contentItems.length;

    if (searchInput) {
        /**
         * Gestisce l'input dell'utente nel campo di ricerca.
         * @param {Event} e L'evento di input.
         */
        searchInput.addEventListener('input', function () {
            /**
             * Query di ricerca.
             * @type {string} La query di ricerca.
             */
            const query = this.value.toLowerCase().trim();
            /**
             * Conteggio degli elementi visibili.
             * @type {number} Il conteggio degli elementi visibili.
             */
            let visibleCount = 0;

            /**
             * Itera su tutti gli elementi del carosello.
             * @param {Element} item L'elemento corrente del carosello.
             */
            contentItems.forEach(item => {
                
                /**
                 * Testo dell'elemento corrente del carosello.
                 * @type {string} Il testo dell'elemento corrente del carosello.
                 */
                const text = item.textContent.toLowerCase();
                
                /**
                 * Controlla se il testo dell'elemento corrente contiene la query di ricerca.
                 * @param {string} query La query di ricerca.
                 * @returns {boolean} True se il testo contiene la query di ricerca, false altrimenti.
                 */
                if (text.includes(query)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            
            if (searchCount) {
                if (query === "") {
                    searchCount.textContent = `Totale: ${totalCount}`;
                } else {
                    searchCount.textContent = `Trovati: ${visibleCount} di ${totalCount}`;
                }
            }
        });
    }
});
