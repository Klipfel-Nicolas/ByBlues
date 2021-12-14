// Si class rating dans le DOM de la page
if (document.querySelector('.rating')) {
    // Selection des éléments bouton, div.rating et input.rate
    const btn = document.querySelector('#btn');
    const rating = document.querySelector('.rating');
    const stars = document.querySelectorAll('.rating input');

    if (rating) {
        /**
         * event listener change dans la div.rating
         * e => event
         */
        rating.addEventListener(
            'change', (e) => {
            /**
             * Si Rating possède déjas un element (input.stars)
             * ayant la class .active, on remove la class
             */
                if (rating.querySelector('.active')) {
                    rating.querySelector('.active').classList.remove('active');
                }
                /**
                 * On donne la class .active à l'element changé (.stars)
                 * Voir .active dans le CSS
                 */
                e.target.classList.add('active');
            },
        );
    }

    /**
     * event listener click
     * on récupère la valeur de l input cliker
     */
    let valueRating = '';
    stars.forEach((star) => {
        star.addEventListener('click', (e) => {
            valueRating = e.target.value;
        });
    });

    /**
     * envoie des valeurs en Ajax
     */
    btn.addEventListener('click', (event) => {
        // empeche  l'envoie du formulaire par défaut
        event.preventDefault();

        // Valeur du commentaire rempli par l'utilisateur
        const userReview = document.querySelector('#user_review_review').value;

        // Envoie de manière asynchrone la requête
        (async () => {
            const rawResponse = await fetch('/user/review/ajax', {
                method: 'POST',
                // defini le format envoyé
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
                // les données a envoyer
                body: JSON.stringify({ rate: valueRating, review: userReview }),
            });
            const content = await rawResponse.json();

            // Une fois la requêttes exécuté, redirection sur la page review
            document.location.href = '/user/review/';
        })();
    });
}
