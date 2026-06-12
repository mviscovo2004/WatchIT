function toggleReviewModal(show) {
    const modal = document.getElementById('reviewModal');
    if (modal) {
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden'); // Blocca lo scroll del body
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Sblocca lo scroll del body
            resetStars(); // Resetta lo stato delle stelle se si chiude il modale
        }
    }
}

// Chiude il modale se l'utente clicca fuori dal box della recensione
window.addEventListener('click', function(e) {
    const reviewModal = document.getElementById('reviewModal');
    if (e.target === reviewModal) {
        toggleReviewModal(false);
    }
});

// LOGICA INTERATTIVA DELLE STELLINE
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star-btn');
    const votoInput = document.getElementById('votoInput');
    const votoVisualizzato = document.getElementById('votoVisualizzato');
    let selectedRating = 0;

    stars.forEach(star => {
        const value = parseInt(star.getAttribute('data-value'));

        // 1. Hover (mouseenter): illumina temporaneamente le stelle
        star.addEventListener('mouseenter', () => {
            highlightStars(value);
            votoVisualizzato.textContent = `★ ${value} / 10`;
        });

        // 2. Fine Hover (mouseleave): ripristina lo stato dell'ultimo voto confermato
        star.addEventListener('mouseleave', () => {
            highlightStars(selectedRating);
            if (selectedRating > 0) {
                votoVisualizzato.textContent = `★ ${selectedRating} / 10`;
            } else {
                votoVisualizzato.textContent = 'Nessun voto selezionato';
            }
        });

        // 3. Click: conferma la selezione del voto
        star.addEventListener('click', () => {
            selectedRating = value;
            votoInput.value = value;
            highlightStars(value);
            votoVisualizzato.textContent = `★ ${value} / 10`;
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            if (starValue <= rating) {
                star.classList.remove('text-slate-600');
                star.classList.add('text-amber-500');
            } else {
                star.classList.remove('text-amber-500');
                star.classList.add('text-slate-600');
            }
        });
    }

    // Esponiamo la funzione di reset per quando il modale viene chiuso
    window.resetStars = function() {
        selectedRating = 0;
        if (votoInput) votoInput.value = '';
        if (votoVisualizzato) votoVisualizzato.textContent = 'Nessun voto selezionato';
        highlightStars(0);
    }
});    