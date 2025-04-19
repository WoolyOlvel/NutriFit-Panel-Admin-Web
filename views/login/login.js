$(document).ready(function(){
    $("#login_form").on("submit", function(event){
        event.preventDefault();

        const email = $("#email").val();
        const password = $("#password-input").val();
        const remember = document.getElementById("auth-remember-check").checked;

        $.ajax({
            url: "http://127.0.0.1:8000/api/login", // Cambia si tu URL es diferente
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                email: email,
                password: password,
                remember: remember
            }),
            success: function(response) {
                // Guardar el remember_token si se marcó el checkbox
                if (remember && response.remember_token) {
                    // Cookie por 15 días
                    document.cookie = `remember_token=${response.remember_token}; path=/; max-age=${60 * 60 * 24 * 15}`;
                    
                }
               
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Sesión Exitosa. Bienvenido a NutriFit Panel.',
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    window.location.href = `../preloader/preloader.php?token=${response.remember_token}`; // Pasa el token en la URL
                }, 2000);
                
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
