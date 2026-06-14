function eliminaContenuto(id) {
    if (confirm(
            "Sei sicuro di voler eliminare permanentemente questo contenuto? Questa azione rimuoverà anche tutte le visualizzazioni, recensioni, partecipazioni e inserimenti in watchlist ad esso associati."
        )) {
        window.location.href = "?controller=Admin&action=eliminaContenuto&id=" + id;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const contentItems = document.querySelectorAll('.content-item');
    const searchCount = document.getElementById('search-count');
    const totalCount = contentItems.length;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            contentItems.forEach(item => {
                
                const text = item.textContent.toLowerCase();
                
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
