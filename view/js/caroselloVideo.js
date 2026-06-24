/**
 * Gestione del Carosello Video interattivo.
 * 
 * Abilita lo scorrimento orizzontale fluido dei trailer e delle clip di YouTube.
 * Gestisce l'abilitazione e disabilitazione dinamica dei pulsanti di scorrimento laterale
 * in base al raggiungimento dei limiti destro o sinistro del container.
 * 
 * @author Marco Viscovo
 */

document.addEventListener('DOMContentLoaded', () => {
    /**
     * Seleziona gli elementi HTML del carosello e dei pulsanti di navigazione.
     * @type {HTMLElement|null} Container scorrevole del carosello.
     * @type {HTMLElement|null} Pulsante di scorrimento a sinistra.
     * @type {HTMLElement|null} Pulsante di scorrimento a destra.
     */
    const container = document.getElementById('videoContainer');
    const leftBtn = document.getElementById('slideLeftBtn');
    const rightBtn = document.getElementById('slideRightBtn');

    if (!container || !leftBtn || !rightBtn) return;

    /**
     * Aggiorna lo stato di abilitazione dei pulsanti di scorrimento in base alla posizione corrente.
     */
    const updateButtons = () => {
        const scrollLeft = container.scrollLeft;
        const maxScroll = container.scrollWidth - container.clientWidth;

        
        leftBtn.disabled = scrollLeft <= 2;
        
        
        rightBtn.disabled = scrollLeft >= maxScroll - 2;
    };

    /**
     * Determina l'ammontare dello scorrimento basandosi sulla larghezza del primo elemento e sul gap tra elementi.
     * @returns {number} L'ammontare di pixel da scorrere.
     */
    const getScrollAmount = () => {
        const firstChild = container.firstElementChild;
        return firstChild ? firstChild.clientWidth + 24 : 400;
    };

    /**
     * Gestisce lo scorrimento del carosello verso sinistra.
     */
    leftBtn.addEventListener('click', () => {
        container.scrollBy({
            left: -getScrollAmount(),
            behavior: 'smooth'
        });
    });

    /**
     * Gestisce lo scorrimento del carosello verso destra.
     */
    rightBtn.addEventListener('click', () => {
        container.scrollBy({
            left: getScrollAmount(),
            behavior: 'smooth'
        });
    });

    /**
     * Aggiorna lo stato dei pulsanti di scorrimento quando viene effettuato lo scroll del carosello.
     */
    container.addEventListener('scroll', updateButtons);

    /**
     * Aggiorna lo stato dei pulsanti di scorrimento quando viene ridimensionata la finestra.
     */
    window.addEventListener('resize', updateButtons);

    /**
     * Aggiorna lo stato dei pulsanti di scorrimento al caricamento della pagina.
     */
    setTimeout(updateButtons, 100);
});
