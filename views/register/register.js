document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");
    const passwordInput = document.getElementById("password-input");
    const submitBtn = document.getElementById("submit-btn");

    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();

        // Validación de campos...
        const inputs = form.querySelectorAll("input[required]");
        let valid = true;

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        // Validar contraseña...
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        if (!passwordPattern.test(passwordInput.value)) {
            passwordInput.classList.add("is-invalid");
            valid = false;
        }

        if (!valid) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos o inválidos',
                text: 'Por favor, verifica tu información.',
            });
            return;
        }

        // Crear objeto de datos correctamente
        const userData = {
            nombre: form.querySelector('#nombre').value,
            apellidos: form.querySelector('#apellidos').value,
            email: form.querySelector('#email').value,
            usuario: form.querySelector('#usuario').value,
            password: form.querySelector('#password-input').value
        };

        // Mostrar indicador de carga
        Swal.fire({
            title: 'Registrando...',
            text: 'Por favor espera un momento',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Enviar la petición
        fetch('https://nutrifitplanner.site/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(userData),
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    let translatedErrors = [];

                    // Traducciones comunes
                    const traducciones = {
                        "The email has already been taken.": "El correo electrónico ya está en uso",
                        "The usuario has already been taken.": "El nombre de usuario ya está en uso",
                        "The email field is required.": "El campo correo electrónico es obligatorio",
                        "The usuario field is required.": "El campo nombre de usuario es obligatorio",
                        "The password field is required.": "El campo contraseña es obligatorio"
                    };

                    // Procesar errores si vienen en el formato Laravel (errors: { campo: ["mensaje"] })
                    if (errorData.errors) {
                        Object.values(errorData.errors).forEach(msgList => {
                            msgList.forEach(msg => {
                                translatedErrors.push(traducciones[msg] || msg);
                            });
                        });
                    } else if (errorData.message) {
                        translatedErrors.push(traducciones[errorData.message] || errorData.message);
                    }

                     // Convertir a texto separado por punto
                    const errorText = translatedErrors.join('. ') + '.';
                    throw new Error(errorText);
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: 'Te has unido correctamente.',
                timer: 2000,
                showConfirmButton: false
            });
            form.reset();

            // Redirigir después del mensaje
            setTimeout(() => {
                window.location.href = '../login/login.php';
            }, 2000);
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: error.message || 'Ocurrió un error. Inténtalo más tarde.',
            });
        });
    });
});