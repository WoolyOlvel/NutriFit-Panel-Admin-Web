$(document).ready(function(){
    $("#login_form").on("submit", function(event){
        event.preventDefault(); // 🔴 Evita la recarga del formulario

        // Mostrar SweetAlert2 con preloader
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'Sesión Exitosa. Bienvenido A NutriFit Panel.',
            showConfirmButton: false, // ❌ No mostrar botón de confirmación
            timer: 2000 // ⏳ Se cierra en 2 segundos
        });

        // Redirigir después de 2 segundos
        setTimeout(() => {
            window.location.href = "../preloader/preloader.php";
        }, 2000);
    });
});
