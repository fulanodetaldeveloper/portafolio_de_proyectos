<?php 
require_once 'domain/proyecto.php';
require_once 'dao/proyecto_dao.php';

class ProyectoService {
    private $proyectoDAO;

    public function __construct($db) {
        $this->proyectoDAO = new ProyectoDAO($db);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->proyectoDAO->getById($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Proyecto not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->proyectoDAO->getAll());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $proyecto = new Proyecto(
                    null,
                    $data['nombre'],
                    $data['descripcion'],
                    $data['id_project_manager'],
                    $data['finicio'],
                    $data['ftermino']
                );
                
                if ($this->proyectoDAO->insert($proyecto)) {
                    http_response_code(201);
                    return json_encode(["message" => "Proyecto created successfully"]);
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
                
                $proyecto = new Proyecto(
                    $id,
                    $data['nombre'],
                    $data['descripcion'],
                    $data['id_project_manager'],
                    $data['finicio'],
                    $data['ftermino']
                );
                
                if ($this->proyectoDAO->update($proyecto)) {
                    return json_encode(["message" => "Proyecto updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->proyectoDAO->delete($id)) {
                    return json_encode(["message" => "Proyecto deleted successfully"]);
                }
                break;

            default:
                http_response_code(405);
                return json_encode(["error" => "Method not allowed"]);
        }
    }

    private function validateData($data) {
        return isset($data['nombre']) && 
               isset($data['descripcion']) && 
               isset($data['id_project_manager']) && 
               isset($data['finicio']) && 
               isset($data['ftermino']);
    }
}

?>