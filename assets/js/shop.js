if (document.querySelector('.shop')) {
    const items = document.querySelectorAll('article');

    items.forEach((item) => {
        const bigImg = item.querySelector('.big-image img');
        const images = item.querySelectorAll('.mini-image');

        images.forEach((image) => {
            image.addEventListener('click', () => {
                bigImg.src = image.src;
            });
        });
    });
}
