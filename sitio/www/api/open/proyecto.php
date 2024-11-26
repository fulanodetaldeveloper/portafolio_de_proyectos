<?php
// Importaciones
require_once '../../config/proyecto_require.php';
// Configurar las cabeceras para manejar JSON
require_once '../../config/headers.php';



$facade = new ProyectoFacade();
$response = [];

switch ($method) {
    case 'GET':
        http_response_code(200);       
        $response = $facade->listAll();
        break;

    default:
        http_response_code(404);
        $response = [ 'httpCode' => '404', 'httpDescription' => 'El recurso solicitado no existe en el servidor' ];
        break;
}

echo json_encode($response);
?>


