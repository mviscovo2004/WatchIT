// Mostra o nasconde il modale delle recensioni
function toggleReviewModal(show) {
    const modal = document.getElementById('reviewModal');
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

// Resetta i dati del modulo e ripristina il colore grigio di base delle stelle
function resetReviewForm() {
    const votoInput = document.getElementById('votoInput');
    const votoVisualizzato = document.getElementById('votoVisualizzato');
    const commento = document.getElementById('testo');
    const stars = document.querySelectorAll('.star-btn');

    if (votoInput) votoInput.value = '';
    if (votoVisualizzato) votoVisualizzato.textContent = 'Nessun voto selezionato';
    if (commento) commento.value = '';

    stars.forEach(star => {
        star.style.color = '#475569'; // Ripristina il grigio nativamente (slate-600)
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star-btn');
    const votoInput = document.getElementById('votoInput');
    const votoVisualizzato = document.getElementById('votoVisualizzato');
    const modal = document.getElementById('reviewModal');

    let selectedRating = 0;

    
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

        
        star.addEventListener('mouseenter', () => {
            colorStars(val);
            if (votoVisualizzato) {
                votoVisualizzato.textContent = `${val} / 10`;
            }
        });

        
        star.addEventListener('mouseleave', () => {
            colorStars(selectedRating);
            if (votoVisualizzato) {
                votoVisualizzato.textContent = selectedRating > 0 ? `${selectedRating} / 10` : 'Nessun voto selezionato';
            }
        });

        
        star.addEventListener('click', () => {
            selectedRating = val;
            if (votoInput) votoInput.value = val;
            colorStars(val);
        });
    });

    
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            toggleReviewModal(false);
        }
    });
});
