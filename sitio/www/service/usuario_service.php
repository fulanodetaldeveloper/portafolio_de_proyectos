<?php 
require_once 'domain/usuario.php';
require_once 'dao/usuario_dao.php';



class UsuarioService {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function handleRequest($method, $id = null) {
        echo "ask";
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->usuarioDAO->list($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Usuario not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->usuarioDAO->list());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $usuario = new Usuario(
                    null,
                    $data['name'],
                    password_hash($data['password'], PASSWORD_DEFAULT),
                    $data['id_tipo']
                );
                
                if ($this->usuarioDAO->insert($usuario)) {
                    http_response_code(201);
                    return json_encode(["message" => "Usuario created successfully"]);
                }
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for update"]);
                }
                
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateUpdateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $usuario = new Usuario(
                    $id,
                    $data['name'],
                    isset($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null,
                    $data['id_tipo']
                );
                
                if ($this->usuarioDAO->update($usuario)) {
                    return json_encode(["message" => "Usuario updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->usuarioDAO->delete($id)) {
                    return json_encode(["message" => "Usuario deleted successfully"]);
                }
                break;

            default:
                http_response_code(405);
                return json_encode(["error" => "Method not allowed"]);
        }
    }

    private function validateData($data) {
        return isset($data['name']) && 
               isset($data['password']) && 
               isset($data['id_tipo']);
    }

    private function validateUpdateData($data) {
        return isset($data['name']) && 
               isset($data['id_tipo']);
    }
}








?>