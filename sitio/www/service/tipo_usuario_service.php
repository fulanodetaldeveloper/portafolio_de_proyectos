<?php 
require_once 'domain/tipo_usuario.php';
require_once 'dao/tipo_usuario_dao.php';


class TipoUsuarioService {
    private $tipoUsuarioDAO;

    public function __construct($db) {
        $this->tipoUsuarioDAO = new TipoUsuarioDAO($db);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->tipoUsuarioDAO->getById($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Tipo Usuario not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->tipoUsuarioDAO->getAll());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $tipoUsuario = new TipoUsuario(
                    null,
                    $data['tipo'],
                    $data['lectura'],
                    $data['escritura']
                );
                
                if ($this->tipoUsuarioDAO->insert($tipoUsuario)) {
                    http_response_code(201);
                    return json_encode(["message" => "Tipo Usuario created successfully"]);
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
                
                $tipoUsuario = new TipoUsuario(
                    $id,
                    $data['tipo'],
                    $data['lectura'],
                    $data['escritura']
                );
                
                if ($this->tipoUsuarioDAO->update($tipoUsuario)) {
                    return json_encode(["message" => "Tipo Usuario updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->tipoUsuarioDAO->delete($id)) {
                    return json_encode(["message" => "Tipo Usuario deleted successfully"]);
                }
                break;

            default:
                http_response_code(405);
                return json_encode(["error" => "Method not allowed"]);
        }
    }

    private function validateData($data) {
        return isset($data['tipo']) && 
               isset($data['lectura']) && 
               isset($data['escritura']);
    }
}

?>