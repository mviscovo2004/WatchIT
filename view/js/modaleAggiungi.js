function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('hidden');
    
    setTimeout(() => {
        const dialog = modal.querySelector('div');
        if (dialog) {
            dialog.classList.remove('scale-95', 'opacity-0');
            dialog.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}


function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const dialog = modal.querySelector('div');
    if (dialog) {
        dialog.classList.remove('scale-100', 'opacity-100');
        dialog.classList.add('scale-95', 'opacity-0');
    }

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function toggleTipoCampi(prefix) {
    const tipoSelect = document.getElementById(`${prefix}-tipo`);
    const campiFilm = document.getElementById(`${prefix}-campi-film`);
    const campiSerie = document.getElementById(`${prefix}-campi-serie`);
    const inputDurata = document.getElementById(`${prefix}-durata`);
    const inputStagioni = document.getElementById(`${prefix}-stagioni`);

    if (!tipoSelect) return;

    if (tipoSelect.value === 'film') {
        if (campiFilm) campiFilm.classList.remove('hidden');
        if (campiSerie) campiSerie.classList.add('hidden');
        
        
        if (inputDurata) inputDurata.setAttribute('required', 'required');
        if (inputStagioni) inputStagioni.removeAttribute('required');
    } else {
        if (campiFilm) campiFilm.classList.add('hidden');
        if (campiSerie) campiSerie.classList.remove('hidden');
        

        if (inputDurata) inputDurata.removeAttribute('required');
        if (inputStagioni) inputStagioni.setAttribute('required', 'required');
    }
}


document.addEventListener('DOMContentLoaded', () => {
    toggleTipoCampi('add');

    
    window.addEventListener('click', function(e) {
        const activeModals = document.querySelectorAll('.fixed:not(.hidden)');
        activeModals.forEach(modal => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
});
