window.fbAsyncInit = function () {
    FB.init({
        appId: '1584426825580399',
        cookie: true,
        xfbml: true,
        version: 'v18.0'
    });
};

function loginWithFacebook() {
    FB.login(function (response) {
        if (response.authResponse) {
            FB.api('/me', { fields: 'name,email' }, function (userData) {
                const accessToken = response.authResponse.accessToken;

                fetch("http://localhost:8000/social-login/facebook", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ accessToken: accessToken })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.cookie = `remember_token=${data.token}; path=/`;
                        window.location.href = "../preloader/preloader.php?token=" + data.token; // Pasa el token en la URL
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                });
            });
        } else {
            Swal.fire("Error", "No se pudo autenticar con Facebook", "error");
        }
    }, { scope: 'email' });
}
