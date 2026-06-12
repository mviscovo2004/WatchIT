// Gestione Ban Modal
function openBanModal(userId, userFullName) {
    document.getElementById('banUserId').value = userId;
    document.getElementById('banTargetName').textContent = userFullName;
    document.getElementById('banMotivo').value = '';
    document.getElementById('banDurata').value = '1';

    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(function() {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeBanModal() {
    const modal = document.getElementById('banModal');
    const container = document.getElementById('banModalContainer');

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    setTimeout(function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

function submitBanForm(event) {
    event.preventDefault();
    const userId = document.getElementById('banUserId').value;
    const durata = document.getElementById('banDurata').value;
    const form = document.getElementById('banForm');

    form.action = 'index.php?controller=Admin&action=banUtente&idUtente=' + userId + '&durata=' + durata;
    form.submit();
}

// Gestione Unban Modal
function openUnbanModal(userId, userFullName) {
    document.getElementById('unbanTargetName').textContent = userFullName;
    document.getElementById('unbanConfirmBtn').href = 'index.php?controller=Admin&action=unbanUtente&idUtente=' + userId;

    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(function() {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeUnbanModal() {
    const modal = document.getElementById('unbanModal');
    const container = document.getElementById('unbanModalContainer');

    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');

    setTimeout(function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

// Chiudi i modali cliccando sullo sfondo
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
