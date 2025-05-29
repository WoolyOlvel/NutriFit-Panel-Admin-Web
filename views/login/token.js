
document.addEventListener("DOMContentLoaded", () => {
    const cookies = document.cookie.split('; ');
    const tokenCookie = cookies.find(row => row.startsWith('remember_token='));

    if (tokenCookie) {
        const token = tokenCookie.split('=')[1];

        fetch('http://nutrifitplanner.site/api/auto-login', {
            method: 'GET',
            headers: {
                'remember-token': token
            }
            
        })
        .then(res => res.json())
        .then(data => {
            if (data.user) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sesión automática',
                    text: `Bienvenido de nuevo, ${data.user.nombre}.`,
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    window.location.href = `../preloader/preloader.php?token=${token}`; // o la ruta que uses
                }, 2000);
            }
        })
        .catch(() => {
            console.log("No se pudo iniciar sesión automática.");
        });
    }
});

