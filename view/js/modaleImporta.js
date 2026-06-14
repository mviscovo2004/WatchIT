function showImportLoading() {
    const loadingDiv = document.getElementById('importLoading');
    const form = document.getElementById('formImportaTMDB');
    
    if (loadingDiv) {
        loadingDiv.classList.remove('hidden');
        loadingDiv.classList.add('flex');
    }

    if (form) {
        const buttons = form.querySelectorAll('button');
        buttons.forEach(button => {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
        });
    }
}
