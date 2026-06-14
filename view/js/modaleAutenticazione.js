
function toggleModal(modalId, show) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
}


function switchModal(fromModalId, toModalId) {
    toggleModal(fromModalId, false);
    toggleModal(toModalId, true);
}


document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const activeModals = document.querySelectorAll('.fixed:not(.hidden)');
        activeModals.forEach(modal => {
            
            if (e.target === modal) {
                toggleModal(modal.id, false);
            }
        });
    });
});
