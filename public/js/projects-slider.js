document.addEventListener('DOMContentLoaded', () => {

    const slider = document.querySelector('.projects-slider');
    if (!slider) return;

    const track = slider.querySelector('.projects-grid');
    const prevBtn = slider.querySelector('.slider-arrow-left');
    const nextBtn = slider.querySelector('.slider-arrow-right');

    let cards = Array.from(track.children);

    let currentIndex = 0;
    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationID = 0;

    const gap = 24;

    function cardsPerView() {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    function cardWidth() {
        const card = cards[0];
        return card.offsetWidth + gap;
    }

    function maxIndex() {
        return cards.length - cardsPerView();
    }

    function setPosition(animated = true) {

        if (animated) {
            track.style.transition = 'transform 0.45s ease';
        } else {
            track.style.transition = 'none';
        }

        currentTranslate = -(currentIndex * cardWidth());

        track.style.transform =
            `translateX(${currentTranslate}px)`;
    }

    function nextSlide() {

        if (currentIndex >= maxIndex()) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }

        setPosition();
    }

    function prevSlide() {

        if (currentIndex <= 0) {
            currentIndex = maxIndex();
        } else {
            currentIndex--;
        }

        setPosition();
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // =========================
    // DRAG / SWIPE
    // =========================

    function touchStart(index) {

        return function (event) {

            isDragging = true;

            startX = getPositionX(event);

            prevTranslate = currentTranslate;

            track.style.transition = 'none';

            animationID = requestAnimationFrame(animation);
        }
    }

    function touchMove(event) {

        if (!isDragging) return;

        const currentPosition = getPositionX(event);

        const diff = currentPosition - startX;

        currentTranslate = prevTranslate + diff;
    }

    function touchEnd() {

        cancelAnimationFrame(animationID);

        isDragging = false;

        const movedBy = currentTranslate - prevTranslate;

        if (movedBy < -100) {
            nextSlide();
        }
        else if (movedBy > 100) {
            prevSlide();
        }
        else {
            setPosition();
        }
    }

    function getPositionX(event) {
        return event.type.includes('mouse')
            ? event.pageX
            : event.touches[0].clientX;
    }

    function animation() {

        track.style.transform =
            `translateX(${currentTranslate}px)`;

        if (isDragging) {
            requestAnimationFrame(animation);
        }
    }

    // TOUCH EVENTS

    track.addEventListener('touchstart', touchStart());
    track.addEventListener('touchmove', touchMove);
    track.addEventListener('touchend', touchEnd);

    // MOUSE EVENTS

    track.addEventListener('mousedown', touchStart());

    track.addEventListener('mousemove', touchMove);

    track.addEventListener('mouseup', touchEnd);

    track.addEventListener('mouseleave', () => {
        if (isDragging) touchEnd();
    });

    // =========================
    // RESIZE
    // =========================

    window.addEventListener('resize', () => {
        setPosition(false);
    });

    // =========================
    // INIT
    // =========================

    setPosition(false);
});