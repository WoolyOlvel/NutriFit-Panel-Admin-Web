$(document).ready(function(){
    $("#login_form").on("submit", function(event){
        event.preventDefault();

        const email = $("#email").val();
        const password = $("#password-input").val();
        const remember = document.getElementById("auth-remember-check").checked;

        $.ajax({
            url: "http://127.0.0.1:8000/api/login",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                email: email,
                password: password,
                remember: remember,
                is_mobile: false // Explícitamente false para web
            }),
            success: function(response) {
                if (remember && response.remember_token) {
                    document.cookie = `remember_token=${response.remember_token}; path=/; max-age=${60 * 60 * 24 * 15}`;
                }

                // Verificar rol_id antes de redirigir
                if (response.user.rol_id === 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Bienvenido al Panel de Nutriólogos',
                        timer: 2000
                    }).then(() => {
                        window.location.href = `../preloader/preloader.php?token=${response.remember_token}`;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso denegado',
                        text: 'Solo nutriólogos pueden acceder al panel web',
                    });
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.error || "Error desconocido.";
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg,
                });
            }
        });
    });
});