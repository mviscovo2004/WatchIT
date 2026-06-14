document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('videoContainer');
    const leftBtn = document.getElementById('slideLeftBtn');
    const rightBtn = document.getElementById('slideRightBtn');

    if (!container || !leftBtn || !rightBtn) return;

    
    const updateButtons = () => {
        const scrollLeft = container.scrollLeft;
        const maxScroll = container.scrollWidth - container.clientWidth;

        
        leftBtn.disabled = scrollLeft <= 2;
        
        
        rightBtn.disabled = scrollLeft >= maxScroll - 2;
    };

    
    const getScrollAmount = () => {
        const firstChild = container.firstElementChild;
        return firstChild ? firstChild.clientWidth + 24 : 400;
    };

    
    leftBtn.addEventListener('click', () => {
        container.scrollBy({
            left: -getScrollAmount(),
            behavior: 'smooth'
        });
    });

    
    rightBtn.addEventListener('click', () => {
        container.scrollBy({
            left: getScrollAmount(),
            behavior: 'smooth'
        });
    });

    container.addEventListener('scroll', updateButtons);
    window.addEventListener('resize', updateButtons);

    
    setTimeout(updateButtons, 100);
});
