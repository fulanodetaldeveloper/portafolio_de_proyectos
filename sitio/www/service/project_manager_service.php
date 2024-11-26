<?php 
require_once 'domain/project_manager.php';
require_once 'dao/project_manager_dao.php';


class ProjectManagerService {
    private $projectManagerDAO;

    public function __construct($db) {
        $this->projectManagerDAO = new ProjectManagerDAO($db);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->projectManagerDAO->getById($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Project Manager not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->projectManagerDAO->getAll());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $projectManager = new ProjectManager(
                    null,
                    $data['nombre'],
                    $data['apaterno'],
                    $data['amaterno'],
                    $data['fnacimiento'],
                    $data['activo']
                );
                
                if ($this->projectManagerDAO->insert($projectManager)) {
                    http_response_code(201);
                    return json_encode(["message" => "Project Manager created successfully"]);
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
                
                $projectManager = new ProjectManager(
                    $id,
                    $data['nombre'],
                    $data['apaterno'],
                    $data['amaterno'],
                    $data['fnacimiento'],
                    $data['activo']
                );
                
                if ($this->projectManagerDAO->update($projectManager)) {
                    return json_encode(["message" => "Project Manager updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->projectManagerDAO->delete($id)) {
                    return json_encode(["message" => "Project Manager deleted successfully"]);
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