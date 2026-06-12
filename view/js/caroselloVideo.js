document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('videoContainer');
    const leftBtn = document.getElementById('slideLeftBtn');
    const rightBtn = document.getElementById('slideRightBtn');

    if (!container || !leftBtn || !rightBtn) return;

    // Determina lo spazio da scorrere (larghezza del primo video + gap)
    const getScrollAmount = () => {
        const firstVideo = container.firstElementChild;
        return firstVideo ? firstVideo.clientWidth + 24 : 400; // 24px è il gap-6
    };

    // Disabilita/Nasconde i pulsanti quando arrivi alla fine o all'inizio
    const updateButtons = () => {
        const scrollLeft = container.scrollLeft;
        const maxScrollLeft = container.scrollWidth - container.clientWidth;

        leftBtn.disabled = (scrollLeft <= 5);
        rightBtn.disabled = (scrollLeft >= maxScrollLeft - 5);
    };

    leftBtn.addEventListener('click', () => {
        container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
    });

    rightBtn.addEventListener('click', () => {
        container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
    });

    container.addEventListener('scroll', updateButtons);
    updateButtons();
    
    // Ricalcolo di sicurezza dopo mezzo secondo per caricamento video lento
    setTimeout(updateButtons, 500);
});
