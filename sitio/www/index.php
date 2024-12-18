<?php
session_start();
$_SESSION = [];
$_SESSION['usuario_id'] = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="/static/css/lib/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
    <script src="/static/js/lib/jquery-3.7.1.min.js"></script>
    <script src="/static/js/login.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>
                    <form id="loginForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" placeholder="Ingresa tu usuario">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS (opcional, pero necesario para algunas funciones) -->
    
    <script src="/static/js/lib/popper.min.js"></script>
    <script src="/static/js/lib/bootstrap.min.js"></script>
</body>
</html>
