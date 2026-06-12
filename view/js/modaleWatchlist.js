let currentWatchlistContentId = null;

function openAddToWatchlistModal(contentId) {
    currentWatchlistContentId = contentId;
    const container = document.getElementById('watchlistOptionsContainer');
    container.innerHTML =
        '<div class="text-center py-4 text-xs text-slate-500">Caricamento watchlist...</div>';

    // Apri il modale
    toggleWatchlistModal(true);

    // Fetch watchlist in JSON
    fetch(`index.php?controller=Watchlist&action=getWatchlistsJSON&idContenuto=${contentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.watchlists.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-6 text-xs text-slate-500 space-y-3">
                            <p>Non hai ancora creato nessuna watchlist.</p>
                            <a href="index.php?controller=Watchlist&action=mostraTutteWatchlist" 
                                class="inline-block px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white text-[11px] font-bold rounded-lg transition-colors">
                                Crea una Watchlist
                            </a>
                        </div>`;
                    return;
                }

                container.innerHTML = '';
                data.watchlists.forEach(w => {
                    const checked = w.contains ? 'checked' : '';
                    const div = document.createElement('div');
                    div.className =
                        'flex items-center justify-between p-3 rounded-xl bg-slate-950/40 border border-slate-800 hover:bg-slate-950/80 hover:border-slate-750 transition-all';
                    div.innerHTML = `
                        <label class="flex items-center gap-3 cursor-pointer text-sm font-medium text-slate-300 select-none w-full">
                            <input type="checkbox" ${checked} onchange="toggleWatchlistAssociation(this, ${w.id})"
                                class="rounded text-purple-650 focus:ring-purple-500 border-slate-700 bg-slate-950 w-4 h-4 cursor-pointer">
                            <span>${w.nome}</span>
                        </label>
                    `;
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = `<div class="text-center py-4 text-xs text-red-400">Errore: ${data.error}</div>`;
            }
        })
        .catch(err => {
            container.innerHTML =
                '<div class="text-center py-4 text-xs text-red-400">Errore di connessione.</div>';
        });
}

function toggleWatchlistModal(show) {
    const modal = document.getElementById('addToWatchlistModal');
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

function toggleWatchlistAssociation(checkbox, watchlistId) {
    const formData = new FormData();
    formData.append('idContenuto', currentWatchlistContentId);
    formData.append('idWatchlist', watchlistId);

    fetch('index.php?controller=Watchlist&action=toggleContenutoAJAX', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Errore: ' + data.error);
                checkbox.checked = !checkbox.checked; // Ripristina se fallisce
            } else {
                // Aggiorna l'icona + o spunta sulla locandina della pagina (se presente)
                updateWatchlistIconsOnPage(currentWatchlistContentId, data.added);
            }
        })
        .catch(err => {
            alert('Errore di connessione');
            checkbox.checked = !checkbox.checked;
        });
}

function updateWatchlistIconsOnPage(contentId, isAdded) {
    const elements = document.querySelectorAll(`[data-watchlist-content-id="${contentId}"]`);
    elements.forEach(el => {
        if (isAdded) {
            el.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            `;
            el.title = "Rimuovi dalla Watchlist";
        } else {
            el.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            `;
            el.title = "Aggiungi alla Watchlist";
        }
    });
}

// Chiudi il modale cliccando fuori
window.addEventListener('click', function (e) {
    const modal = document.getElementById('addToWatchlistModal');
    if (e.target === modal) {
        toggleWatchlistModal(false);
    }
});
