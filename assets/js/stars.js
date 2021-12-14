function starsRandom() {
    const count = 600;
    const skySection = document.querySelector('.starsSection');
    let i = 0;

    while (i < count) {
        const star = document.createElement('i');
        const x = Math.floor(Math.random() * skySection.clientWidth);
        const y = Math.floor(Math.random() * skySection.clientHeight);
        const duration = Math.random() * 10;
        const size = Math.random() * 2;

        star.style.left = `${x}px`;
        star.style.top = `${y}px`;
        star.style.width = `${1 + size}px`;
        star.style.height = `${1 + size}px`;
        star.style.animationDuration = `${5 + duration}s`;
        star.style.animationDelay = `${duration}s`;

        star.classList.add('sky-star');
        star.setAttribute('data-speed', `${Math.random() * (0.7 - 0.4) + 0.4}`);

        skySection.appendChild(star);
        i += 1;
    }
}

if (document.querySelector('.starsSection')) {
    starsRandom();

    window.addEventListener('scroll', () => {
        const stars = document.querySelectorAll('.sky-star');
        const scroll = window.pageYOffset;

        stars.forEach((star) => {
            const speed = star.getAttribute('data-speed');
            star.style.transform = `translateY(${scroll * speed}px)`;
        });
    });
}
