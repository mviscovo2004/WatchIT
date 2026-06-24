/**
 * Funzione per aggiornare la vista quando viene selezionata una stagione.
 * 
 * @param {string} selectedValue Il valore della stagione selezionata.
 * @param {Array<Object>} episodes Gli episodi da mostrare.
 * @param {HTMLElement} prevBtn Il pulsante di navigazione precedente.
 * @param {HTMLElement} nextBtn Il pulsante di navigazione successivo.
 */
document.addEventListener('DOMContentLoaded', () => {
    /**
     * Seleziona l'elemento del carosello e dei pulsanti di navigazione.
     * @type {HTMLElement|null} Elemento del carosello.
     * @type {HTMLElement|null} Pulsante di navigazione precedente.
     * @type {HTMLElement|null} Pulsante di navigazione successivo.
     */
    const seasonSelect = document.getElementById('seasonSelect');
    /**
     * Seleziona il pulsante di navigazione precedente.
     * @type {HTMLElement|null} Pulsante di navigazione precedente.
     */
    const prevBtn = document.getElementById('prevSeasonBtn');
    /**
     * Seleziona il pulsante di navigazione successivo.
     * @type {HTMLElement|null} Pulsante di navigazione successivo.
     */
    const nextBtn = document.getElementById('nextSeasonBtn');
    /**
     * Seleziona tutti gli episodi del carosello.
     * @type {NodeListOf<Element>|null} Gli episodi del carosello.
     */
    const episodes = document.querySelectorAll('.episode-card');

    if (!seasonSelect || !prevBtn || !nextBtn) return;

    /**
     * Aggiorna la vista per mostrare gli episodi della stagione selezionata.
     * 
     * @param {string} selectedValue Il valore della stagione selezionata.
     * @param {Array<Object>} episodes Gli episodi da mostrare.
     * @param {HTMLElement} prevBtn Il pulsante di navigazione precedente.
     * @param {HTMLElement} nextBtn Il pulsante di navigazione successivo.
     */
    function updateView() {
        /**
         * Valore della stagione selezionata.
         * @type {string} Il valore della stagione selezionata.
         */
        const selectedValue = seasonSelect.value;

        
        episodes.forEach(episode => {
            /**
             * Stagione dell'episodio corrente.
             * @type {string} La stagione dell'episodio corrente.
             */
            const season = episode.getAttribute('data-season');
            if (season === selectedValue) {
                episode.classList.remove('hidden');
                
                setTimeout(() => {
                    episode.classList.remove('opacity-0', 'scale-95');
                    episode.classList.add('opacity-100', 'scale-100');
                }, 50);
            } else {
                episode.classList.add('hidden', 'opacity-0', 'scale-95');
                episode.classList.remove('opacity-100', 'scale-100');
            }
        });

        
        const currentIndex = seasonSelect.selectedIndex;
        const totalOptions = seasonSelect.options.length;

        
        prevBtn.disabled = (currentIndex === 0);

        
        nextBtn.disabled = (currentIndex === totalOptions - 1);
    }

    
    seasonSelect.addEventListener('change', updateView);

    /**
     * Gestisce il click sul pulsante di navigazione precedente.
     * @param {Event} e L'evento di click.
     */
    prevBtn.addEventListener('click', () => {
        if (seasonSelect.selectedIndex > 0) {
            seasonSelect.selectedIndex--;
            updateView();
        }
    });

    /**
     * Gestisce il click sul pulsante di navigazione successivo.
     * @param {Event} e L'evento di click.
     */
    nextBtn.addEventListener('click', () => {
        if (seasonSelect.selectedIndex < seasonSelect.options.length - 1) {
            seasonSelect.selectedIndex++;
            updateView();
        }
    });

    
    updateView();
});
