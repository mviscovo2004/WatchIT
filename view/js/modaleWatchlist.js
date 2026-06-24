
let currentWatchlistContentId = null;

/**
 * Mostra o nasconde il modale di watchlist.
 * 
 * @param {boolean} show True se mostrare il modale, false altrimenti.
 */
function toggleWatchlistModal(show) {
    /**
     * Seleziona gli elementi HTML del modale di watchlist.
     * @type {HTMLElement|null} Il modale di watchlist.
     * @type {HTMLElement|null} Il container del modale di watchlist.
     */
    const modal = document.getElementById('addToWatchlistModal');
    if (!modal) return;

    /**
     * Se la variabile booleana 'show' è vera, mostra il modale di watchlist.
     */
    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');    
    } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden'); 
        currentWatchlistContentId = null;
    }
}


/** 
 * Apre il modale di watchlist.
 * 
 * @param {number} contentId L'ID del contenuto da aggiungere alla watchlist.
 */
function openAddToWatchlistModal(contentId) {
    currentWatchlistContentId = contentId;
    /**
     * Seleziona il container del modale di watchlist.
     * @type {HTMLElement|null} Il container del modale di watchlist.
     */
    const container = document.getElementById('watchlistOptionsContainer');
    
    if (!container) return;
    
    /**
     * Inserisce l'HTML del modale di watchlist nel container.
     * 
     * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
     * @returns {void}
     */
    container.innerHTML = `
        <div class="flex items-center justify-center gap-2 py-6 text-xs text-purple-400">
            <svg class="animate-spin h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Caricamento watchlist...</span>
        </div>
    `;
    
    /**
     * Apre il modale di watchlist.
     */
    toggleWatchlistModal(true);

    /**
     * Recupera le watchlist dell'utente tramite una richiesta asincrona.
     * 
     * @param {number} contentId L'ID del contenuto da aggiungere alla watchlist.
     * @returns {Promise<void>}
     */
    fetch(`index.php?controller=Watchlist&action=getWatchlistsJSON&idContenuto=${contentId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Errore durante il recupero delle watchlist");
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                container.innerHTML = `<div class="text-center py-4 text-xs text-red-500">${data.error}</div>`;
                return;
            }
            
            const watchlists = data.watchlists;
            
            /**
             * Inserisce l'HTML del modale di watchlist nel container.
             * 
             * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
             * @returns {void}
             */
            if (!watchlists || watchlists.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4 space-y-2">
                        <p class="text-xs text-slate-500">Non hai ancora creato nessuna watchlist.</p>
                        <a href="index.php?controller=Watchlist&action=mostraTutteWatchlist" class="inline-block text-xs font-bold text-purple-400 hover:text-purple-300">
                            Crea la tua prima watchlist &rarr;
                        </a>
                    </div>
                `;
                return;
            }

            /**
             * Inserisce l'HTML del modale di watchlist nel container.
             * 
             * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
             * @returns {void}
             */
            container.innerHTML = '';
            watchlists.forEach(w => {
                /**
                 * Seleziona gli elementi HTML del modale di watchlist.
                 * @type {HTMLElement|null} Il modale di watchlist.
                 * @type {HTMLElement|null} Il container del modale di watchlist.
                 */
                const label = document.createElement('label');
                /**
                 * Assegna la classe del modale di watchlist.
                 * 
                 * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
                 * @returns {void}
                 */
                label.className = `flex items-center justify-between p-3 rounded-xl bg-slate-950 border border-slate-800 hover:border-purple-500/30 hover:bg-slate-900 cursor-pointer transition-all duration-200 select-none`;
                
                /**
                 * Inserisce l'HTML del modale di watchlist nel container.
                 * 
                 * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
                 * @returns {void}
                 */
                label.innerHTML = `
                    <span class="text-xs font-semibold text-slate-200 capitalize">${w.nome}</span>
                    <input type="checkbox" ${w.contains ? 'checked' : ''} 
                        class="w-4 h-4 rounded text-purple-650 bg-slate-900 border-slate-800 focus:ring-purple-500 focus:ring-offset-slate-950 focus:ring-2 accent-purple-500 cursor-pointer"
                    />
                `;

                /**
                 * Seleziona gli elementi HTML del modale di watchlist.
                 * @type {HTMLElement|null} Il modale di watchlist.
                 * @type {HTMLElement|null} Il container del modale di watchlist.
                 */
                const checkbox = label.querySelector('input');
                /**
                 * Aggiunge un event listener al checkbox per il toggle del contenuto nella watchlist.
                 * 
                 * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
                 * @returns {void}
                 */
                checkbox.addEventListener('change', () => {
                    toggleContentInWatchlist(w.id, checkbox);
                });

                /**
                 * Aggiunge il label al container del modale di watchlist.
                 * 
                 * @param {string} contentId L'ID del contenuto da aggiungere alla watchlist.
                 * @returns {void}
                 */
                container.appendChild(label);
            });
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = `<div class="text-center py-4 text-xs text-red-500">Errore durante il caricamento delle watchlist.</div>`;
        });
}

/**
 * Attiva o disattiva il contenuto nella watchlist.
 * 
 * @param {number} watchlistId L'ID della watchlist.
 * @param {HTMLInputElement} checkbox Il checkbox.
 * @returns {void}
 */
function toggleContentInWatchlist(watchlistId, checkbox) {
    if (!currentWatchlistContentId) return;
    /**
     * Disabilita il checkbox per prevenire click multipli.
     */
    checkbox.disabled = true;
    /**
     * Crea un FormData per la richiesta asincrona.
     * 
     * @param {number} watchlistId L'ID della watchlist.
     * @param {HTMLInputElement} checkbox Il checkbox.
     * @returns {void}
     */
    const formData = new URLSearchParams();
    /**
     * Aggiunge l'ID del contenuto al FormData.
     * 
     * @param {number} contentId L'ID del contenuto da aggiungere alla watchlist.
     * @returns {void}
     */
    formData.append('idContenuto', currentWatchlistContentId);
    /**
     * Aggiunge l'ID della watchlist al FormData.
     * 
     * @param {number} watchlistId L'ID della watchlist.
     * @returns {void}
     */
    formData.append('idWatchlist', watchlistId);

    fetch('index.php?controller=Watchlist&action=toggleContenutoAJAX', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Errore di rete");
        }
        return response.json();
    })
    .then(data => {
        checkbox.disabled = false;
        if (data.success) {
            checkbox.checked = data.added;
        } else {

            checkbox.checked = !checkbox.checked;
            alert(data.error || "Impossibile aggiornare la watchlist.");
        }
    })
    .catch(err => {
        console.error(err);
        checkbox.disabled = false;

        checkbox.checked = !checkbox.checked;
        alert("Errore di connessione. Riprova più tardi.");
    });
}

/**
 * Gestisce l'evento DOMContentLoaded.
 * 
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', () => {
    /**
     * Aggiunge un event listener per il click sul documento.
     * Chiude il modale di watchlist se l'utente clicca fuori da esso.
     * 
     * @param {MouseEvent} e L'evento del click.
     * @returns {void}
     */
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('addToWatchlistModal');
        if (e.target === modal) {
            toggleWatchlistModal(false);
        }
    });
});

