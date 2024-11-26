<?php 
require_once 'domain/equipo.php';
require_once 'dao/equipo_dao.php';



class EquipoService {
    private $equipoDAO;

    public function __construct($db) {
        $this->equipoDAO = new EquipoDAO($db);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->equipoDAO->getById($id);
                    if (!$result) {
                        http_response_code(404);
                        return json_encode(["error" => "Equipo not found"]);
                    }
                    return json_encode($result);
                } else {
                    return json_encode($this->equipoDAO->getAll());
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$this->validateData($data)) {
                    http_response_code(400);
                    return json_encode(["error" => "Invalid data provided"]);
                }
                
                $equipo = new Equipo(
                    null,
                    $data['id_desarrollador'],
                    $data['horas_asignadas_por_dia'],
                    $data['id_proyecto']
                );
                
                if ($this->equipoDAO->insert($equipo)) {
                    http_response_code(201);
                    return json_encode(["message" => "Equipo created successfully"]);
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
                
                $equipo = new Equipo(
                    $id,
                    $data['id_desarrollador'],
                    $data['horas_asignadas_por_dia'],
                    $data['id_proyecto']
                );
                
                if ($this->equipoDAO->update($equipo)) {
                    return json_encode(["message" => "Equipo updated successfully"]);
                }
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    return json_encode(["error" => "ID is required for delete"]);
                }
                
                if ($this->equipoDAO->delete($id)) {
                    return json_encode(["message" => "Equipo deleted successfully"]);
                }
                break;

            default:
                http_response_code(405);
                return json_encode(["error" => "Method not allowed"]);
        }
    }

    private function validateData($data) {
        return isset($data['id_desarrollador']) && 
               isset($data['horas_asignadas_por_dia']) && 
               isset($data['id_proyecto']);
    }
}


?>