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

        // Llamada AJAX para validación
        $.ajax({
            url: '/api/auth.php',
            method: 'POST',
            dataType: 'json',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                if (response.success) {
                    // Login exitoso
                    alert('Inicio de sesión correcto');
                    // Redireccionar a página principal o dashboard
                    window.location.href = '/dashboard.php';
                } else {
                    // Login fallido
                    alert(response.message || 'Credenciales incorrectas');
                }
            },
            error: function(xhr, status, error) {
                // Error en la conexión
                alert('Error en la conexión. Intente nuevamente.');
                console.error(error);
            }
        });
    });
});