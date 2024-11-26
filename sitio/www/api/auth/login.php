<?php
ini_set('display_errors', 1); // Habilitar la visualización de errores
ini_set('display_startup_errors', 1);

// Importaciones
require_once '../../config/login_require.php';
// Configurar las cabeceras para manejar JSON
require_once '../../config/headers.php';



$facade = new UsuarioFacade();
$response = [];

switch ($method) {
    case 'POST':
        http_response_code(200);  
        // Obtener contenido JSON enviado
        $jsonInput = file_get_contents('php://input');
        
        // Decodificar JSON
        $datos = json_decode($jsonInput, true);
        
        // Validar que se recibieron datos JSON válidos
        if ($datos === null) {
            throw new Exception('JSON inválido', 400);
        }

        // Extraer username y password
        $username = $datos['username'] ?? '';
        $password = $datos['password'] ?? '';

        $user = $facade->validUser($username, $password);
        
        if ($user->getId() == 0) {
            session_start();
            $_SESSION = [];
            $_SESSION['usuario_id'] = 0;
            http_response_code(404);
            $response = [
                'status' => 'error',
                'code' => 401,
                'error' => 'Unauthorized',
                'message' => 'Se requiere autenticación',
                'details' => [
                    'reason' => 'Invalid credentials',
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ];
        } else{
            session_start();
            $_SESSION = [];
            $_SESSION['usuario_id'] = $user->getId();
            $response = [
                'status' => 'success',
                'code' => 200,
                'error' => 'Authorized',
                'message' => 'Se aplico autenticación de forma correcta',
                'details' => [
                    'reason' => 'Credentials Valid',
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ];
        }

        break;

    default:
        http_response_code(404);
        $response = [ 'httpCode' => '404', 'httpDescription' => 'El recurso solicitado no existe en el servidor' ];
        break;
}

echo json_encode($response);
?>


