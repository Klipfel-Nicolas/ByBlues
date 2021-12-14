if (document.querySelector('.submit')) {
    const btnSubmit = document.querySelector('.submit');

    // Create Error message
    const messageError = document.createElement('div');
    const bootstrapClass = ['alert', 'alert-danger', 'errorAuth'];
    messageError.classList.add(...bootstrapClass);

    // Ajax Request
    btnSubmit.addEventListener('click', (e) => {
        e.preventDefault();

        const formLogin = document.querySelector('.loginForm');
        const mail = document.querySelector('#inputEmail').value;
        const password = document.querySelector('#inputPassword').value;

        axios.post('/login', {
            email: mail,
            password,
        })
            .then((resp) => {
                if (resp.request.status === 200) {
                    formLogin.submit();
                }
            })
            .catch((err) => {
                if (err.response.status === 401) {
                    messageError.innerHTML = 'Email ou mot de passe non valide';
                    formLogin.appendChild(messageError);
                } else {
                    messageError.innerHTML.innerHTML = 'Une erreur est survenue, veuillez réessayer plus tard';
                    formLogin.appendChild(messageError);
                }
            });
    });
}
