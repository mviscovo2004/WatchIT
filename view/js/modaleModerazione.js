
function openBanModal(userId, username) {
    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');
    const targetName = document.getElementById('banTargetName');
    const userIdInput = document.getElementById('banUserId');

    if (!modal || !container) return;

    if (targetName) targetName.textContent = username;
    if (userIdInput) userIdInput.value = userId;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeBanModal() {
    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');
    const motivoTextarea = document.getElementById('banMotivo');

    if (!modal || !container) return;

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        if (motivoTextarea) motivoTextarea.value = '';
    }, 300);
}

function submitBanForm(event) {
    event.preventDefault();
    const form = document.getElementById('banForm');
    const userId = document.getElementById('banUserId').value;
    const durata = document.getElementById('banDurata').value;

    if (form && userId && durata) {

        form.action = `index.php?controller=Admin&action=banUtente&idUtente=${userId}&durata=${durata}`;
        form.submit();
    }
}


function openUnbanModal(userId, username) {
    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');
    const targetName = document.getElementById('unbanTargetName');
    const confirmBtn = document.getElementById('unbanConfirmBtn');

    if (!modal || !container) return;

    if (targetName) targetName.textContent = username;
    if (confirmBtn) {
        confirmBtn.href = `index.php?controller=Admin&action=unbanUtente&idUtente=${userId}`;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeUnbanModal() {
    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');

    if (!modal || !container) return;

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('click', function(e) {
        const banModal = document.getElementById('banModal');
        const unbanModal = document.getElementById('unbanModal');

        if (e.target === banModal) {
            closeBanModal();
        }
        if (e.target === unbanModal) {
            closeUnbanModal();
        }
    });
});
