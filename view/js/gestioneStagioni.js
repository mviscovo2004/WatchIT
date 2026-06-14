document.addEventListener('DOMContentLoaded', () => {
    const seasonSelect = document.getElementById('seasonSelect');
    const prevBtn = document.getElementById('prevSeasonBtn');
    const nextBtn = document.getElementById('nextSeasonBtn');
    const episodes = document.querySelectorAll('.episode-card');

    if (!seasonSelect || !prevBtn || !nextBtn) return;

    function updateView() {
        const selectedValue = seasonSelect.value;

        
        episodes.forEach(episode => {
            const season = episode.getAttribute('data-season');
            if (season === selectedValue) {
                episode.classList.remove('hidden');
                
                setTimeout(() => {
                    episode.classList.remove('opacity-0', 'scale-95');
                    episode.classList.add('opacity-100', 'scale-100');
                }, 50);
            } else {
                episode.classList.add('hidden', 'opacity-0', 'scale-95');
                episode.classList.remove('opacity-100', 'scale-100');
            }
        });

        
        const currentIndex = seasonSelect.selectedIndex;
        const totalOptions = seasonSelect.options.length;

        
        prevBtn.disabled = (currentIndex === 0);

        
        nextBtn.disabled = (currentIndex === totalOptions - 1);
    }

    
    seasonSelect.addEventListener('change', updateView);

    
    prevBtn.addEventListener('click', () => {
        if (seasonSelect.selectedIndex > 0) {
            seasonSelect.selectedIndex--;
            updateView();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (seasonSelect.selectedIndex < seasonSelect.options.length - 1) {
            seasonSelect.selectedIndex++;
            updateView();
        }
    });

    
    updateView();
});
