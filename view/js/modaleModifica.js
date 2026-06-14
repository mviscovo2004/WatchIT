
if (typeof openModal !== 'function') {
    window.openModal = function(modalId) {
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
    };
}

if (typeof closeModal !== 'function') {
    window.closeModal = function(modalId) {
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
    };
}

function openModificaContenutoModal(id) {
    openModal('modalModificaContenuto');
    
    const loader = document.getElementById('editLoader');
    const form = document.getElementById('formModificaContenuto');
    
    if (loader) loader.classList.remove('hidden');
    if (form) form.classList.add('hidden');

    fetch(`index.php?controller=Admin&action=dettagliContenutoAjax&id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Errore nel recupero dati");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                closeModal('modalModificaContenuto');
                return;
            }

            document.getElementById('edit-id').value = data.id;
            document.getElementById('edit-tipo-hidden').value = data.tipo;
            document.getElementById('edit-tipo').value = data.tipo;
            document.getElementById('edit-titolo').value = data.titolo;
            document.getElementById('edit-anno').value = data.anno;
            document.getElementById('edit-valutazione').value = data.valutazioneMedia;
            document.getElementById('edit-locandina').value = data.locandina || '';
            document.getElementById('edit-regista').value = data.regista || '';
            document.getElementById('edit-attori').value = data.attori || '';
            document.getElementById('edit-trama').value = data.trama || '';

            const campiFilm = document.getElementById('edit-campi-film');
            const campiSerie = document.getElementById('edit-campi-serie');
            const inputDurata = document.getElementById('edit-durata');
            const inputStagioni = document.getElementById('edit-stagioni');
            const selectStato = document.getElementById('edit-stato');

            if (data.tipo === 'film') {
                if (campiFilm) campiFilm.classList.remove('hidden');
                if (campiSerie) campiSerie.classList.add('hidden');
                if (inputDurata) {
                    inputDurata.value = data.durataMinuti || '';
                    inputDurata.setAttribute('required', 'required');
                }
                if (inputStagioni) inputStagioni.removeAttribute('required');
            } else {
                if (campiFilm) campiFilm.classList.add('hidden');
                if (campiSerie) campiSerie.classList.remove('hidden');
                if (inputStagioni) {
                    inputStagioni.value = data.numeroStagioni || '';
                    inputStagioni.setAttribute('required', 'required');
                }
                if (selectStato) selectStato.value = data.stato || 'in_corso';
                if (inputDurata) inputDurata.removeAttribute('required');
            }

            const checkboxes = form.querySelectorAll('input[name="generi[]"]');
            checkboxes.forEach(cb => {
                cb.checked = false;
            });

            if (data.generi && Array.isArray(data.generi)) {
                data.generi.forEach(g => {
                    const cb = document.getElementById(`edit-genere-${g.toLowerCase()}`);
                    if (cb) {
                        cb.checked = true;
                    }
                });
            }

            if (loader) loader.classList.add('hidden');
            if (form) form.classList.remove('hidden');
        })
        .catch(err => {
            console.error(err);
            alert("Impossibile caricare i dettagli del contenuto.");
            closeModal('modalModificaContenuto');
        });
}

document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalModificaContenuto');
        if (e.target === modal) {
            closeModal('modalModificaContenuto');
        }
    });
});
