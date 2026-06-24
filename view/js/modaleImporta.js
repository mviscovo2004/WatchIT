/**
 * Mostra la schermata di caricamento per l'importazione da TMDB.
 * 
 * @returns {void}
 */
function showImportLoading() {
    /**
     * Seleziona il div di caricamento.
     * @type {HTMLElement|null} Il div di caricamento.
     */
    const loadingDiv = document.getElementById('importLoading');
    /**
     * Seleziona il form di importazione.
     * @type {HTMLElement|null} Il form di importazione.
     */
    const form = document.getElementById('formImportaTMDB');
    
    if (loadingDiv) {
        loadingDiv.classList.remove('hidden');
        loadingDiv.classList.add('flex');
    }

    if (form) {
        const buttons = form.querySelectorAll('button');
        buttons.forEach(button => {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
        });
    }
}
