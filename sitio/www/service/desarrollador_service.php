<?php 
require_once 'domain/desarrollador.php';
require_once 'dao/desarrollador_dao.php';

class DesarrolladorService {
    private $desarrolladorDAO;

    public function __construct($db) {
        $this->desarrolladorDAO = new DesarrolladorDAO($db);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->desarrolladorDAO->getById($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Desarrollador not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->desarrolladorDAO->getAll());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $desarrollador = new Desarrollador(
                    null,
                    $data['nombre'],
                    $data['apaterno'],
                    $data['amaterno'],
                    $data['fnacimiento'],
                    $data['activo']
                );
                
                if ($this->desarrolladorDAO->insert($desarrollador)) {
                    http_response_code(201);
                    return json_encode(["message" => "Desarrollador created successfully"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for update"]);
                }
                
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $desarrollador = new Desarrollador(
                    $id,
                    $data['nombre'],
                    $data['apaterno'],
                    $data['amaterno'],
                    $data['fnacimiento'],
                    $data['activo']
                );
                
                if ($this->desarrolladorDAO->update($desarrollador)) {
                    return json_encode(["message" => "Desarrollador updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->desarrolladorDAO->delete($id)) {
                    return json_encode(["message" => "Desarrollador deleted successfully"]);
                }
                break;

            default:
                http_response_code(405);
                return json_encode(["error" => "Method not allowed"]);
        }
    }

    private function validateData($data) {
        return isset($data['nombre']) && 
               isset($data['apaterno']) && 
               isset($data['amaterno']) && 
               isset($data['fnacimiento']) && 
               isset($data['activo']);
    }
}



?>