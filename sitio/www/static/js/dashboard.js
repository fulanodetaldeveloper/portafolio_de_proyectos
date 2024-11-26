// Archivo: static/js/login.js
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Obtener valores de usuario y contraseña
        var username = $('#username').val();
        var password = $('#password').val();

        // Validación básica de campos
        if (username.trim() === '' || password.trim() === '') {
            alert('Por favor, ingrese usuario y contraseña');
            return;
        }

        // Validamos las credenciales con una peticion asincrona
        $.ajax({
            url: 'api/auth/login.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                password: password
            }),
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta completa:', response);
                if (response.code === 200) {
                    // Login exitoso, redireccionar a página principal o dashboard
                    window.location.href = '/dashboard.php';
                } else {
                    // Login fallido
                    alert('Credenciales incorrectas');
                }
            },
            error: function(xhr, status, error) {
                // Error en la conexión
                var errorMessage = 'Error en la conexión';
                
                // Intentar obtener mensaje de error del servidor
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    // Login fallido si el http_code es 401
                    if (xhr.responseJSON.code === 401) {
                        errorMessage = 'Credenciales incorrectas';
                    }
                }

                alert(errorMessage);
                console.error(error);
            }
        });
    });
});