
function toggleEditWatchlistModal(show) {
    const modal = document.getElementById('editWatchlistModal');
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


function toggleCreateWatchlistModal(show) {
    const modal = document.getElementById('createWatchlistModal');
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

function openEditModalFromList(event, id, nome, descrizione, visibilita) {
    if (event) {
        event.stopPropagation();
    }

    const redirectInput = document.getElementById('edit_redirect_to');
    if (redirectInput) {
        redirectInput.value = 'lista';
    }

    const nomeInput = document.getElementById('edit_nome');
    const descrizioneInput = document.getElementById('edit_descrizione');
    const visibilitaSelect = document.getElementById('edit_visibilita');
    const modal = document.getElementById('editWatchlistModal');

    if (nomeInput) nomeInput.value = nome;
    if (descrizioneInput) descrizioneInput.value = descrizione;
    if (visibilitaSelect) visibilitaSelect.value = visibilita;
    if (modal) {
        const form = modal.querySelector('form');
        if (form) {
            form.action = `index.php?controller=Watchlist&action=modifica&id=${id}`;
        }
    }

    toggleEditWatchlistModal(true);
}

window.addEventListener('click', function (e) {
    const editModal = document.getElementById('editWatchlistModal');
    const createModal = document.getElementById('createWatchlistModal');
    if (e.target === editModal) {
        toggleEditWatchlistModal(false);
    }
    if (e.target === createModal) {
        toggleCreateWatchlistModal(false);
    }
});

