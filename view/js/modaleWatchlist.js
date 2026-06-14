


let currentWatchlistContentId = null;


function toggleWatchlistModal(show) {
    const modal = document.getElementById('addToWatchlistModal');
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        currentWatchlistContentId = null;
    }
}


function openAddToWatchlistModal(contentId) {
    currentWatchlistContentId = contentId;
    const container = document.getElementById('watchlistOptionsContainer');
    
    if (!container) return;
    

    container.innerHTML = `
        <div class="flex items-center justify-center gap-2 py-6 text-xs text-purple-400">
            <svg class="animate-spin h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Caricamento watchlist...</span>
        </div>
    `;

    toggleWatchlistModal(true);


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

        
            container.innerHTML = '';
            watchlists.forEach(w => {
                const label = document.createElement('label');
                label.className = `flex items-center justify-between p-3 rounded-xl bg-slate-950 border border-slate-800 hover:border-purple-500/30 hover:bg-slate-900 cursor-pointer transition-all duration-200 select-none`;
                
                label.innerHTML = `
                    <span class="text-xs font-semibold text-slate-200 capitalize">${w.nome}</span>
                    <input type="checkbox" ${w.contains ? 'checked' : ''} 
                        class="w-4 h-4 rounded text-purple-650 bg-slate-900 border-slate-800 focus:ring-purple-500 focus:ring-offset-slate-950 focus:ring-2 accent-purple-500 cursor-pointer"
                    />
                `;

                const checkbox = label.querySelector('input');
                checkbox.addEventListener('change', () => {
                    toggleContentInWatchlist(w.id, checkbox);
                });

                container.appendChild(label);
            });
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = `<div class="text-center py-4 text-xs text-red-500">Errore durante il caricamento delle watchlist.</div>`;
        });
}


function toggleContentInWatchlist(watchlistId, checkbox) {
    if (!currentWatchlistContentId) return;

    
    checkbox.disabled = true;

    const formData = new URLSearchParams();
    formData.append('idContenuto', currentWatchlistContentId);
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

document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('addToWatchlistModal');
        if (e.target === modal) {
            toggleWatchlistModal(false);
        }
    });
});

