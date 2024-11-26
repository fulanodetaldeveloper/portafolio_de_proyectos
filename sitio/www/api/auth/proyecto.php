<?php
ini_set('display_errors', 1); // Habilitar la visualización de errores
ini_set('display_startup_errors', 1);

// Importaciones
require_once '../../config/proyecto_auth_require.php';
// Configurar las cabeceras para manejar JSON
require_once '../../config/headers.php';



$facade = new ProyectoFacade();
$response = [];

switch ($method) {
    case 'GET':
        http_response_code(200);  
        $apiKey = isset($_SERVER['HTTP_APIKEY']) ? $_SERVER['HTTP_APIKEY'] : "";
        $response = $facade->listAllAuth($apiKey);
        
        if (empty($response)) {
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
        } 

        break;

    default:
        http_response_code(404);
        $response = [ 'httpCode' => '404', 'httpDescription' => 'El recurso solicitado no existe en el servidor' ];
        break;
}

echo json_encode($response);
?>


