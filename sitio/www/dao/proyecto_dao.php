<?php
require_once 'database.php';


class ProyectoDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function list() {
        try {
            $sql = "SELECT id, nombre, descripcion, id_project_manager, finicio, ftermino FROM proyecto";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $proyectos = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $projectManager = new ProjectManager();
                $projectManager->setId($row['id_project_manager']);

                $proyecto = new Proyecto();
                $proyecto->setId($row['id']);
                $proyecto->setNombre($row['nombre']);
                $proyecto->setDescripcion($row['descripcion']);
                $proyecto->setProjectManager($projectManager);
                $proyecto->setFinicio($row['finicio']);
                $proyecto->setFtermino($row['ftermino']);
                $proyectos[] = $proyecto;
            }
            
            return $proyectos;
        } catch (Exception $e) {
            error_log("Error en ProyectoDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function add(Proyecto $proyecto) {
        try {
            $sql = "INSERT INTO proyecto (nombre, descripcion, id_project_manager, finicio, ftermino) 
                    VALUES (:nombre, :descripcion, :idProjectManager, :finicio, :ftermino)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $proyecto->getNombre(),
                ':descripcion' => $proyecto->getDescripcion(),
                ':idProjectManager' => $proyecto->getIdProjectManager(),
                ':finicio' => $proyecto->getFinicio(),
                ':ftermino' => $proyecto->getFtermino()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en ProyectoDAO::add: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(Proyecto $proyecto) {
        try {
            $sql = "UPDATE proyecto 
                    SET nombre = :nombre, descripcion = :descripcion, 
                        id_project_manager = :idProjectManager,
                        finicio = :finicio, ftermino = :ftermino 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $proyecto->getNombre(),
                ':descripcion' => $proyecto->getDescripcion(),
                ':idProjectManager' => $proyecto->getIdProjectManager(),
                ':finicio' => $proyecto->getFinicio(),
                ':ftermino' => $proyecto->getFtermino(),
                ':id' => $proyecto->getId()
            ];

            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en ProyectoDAO::update: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($proyecto) {
        try {
            $sql = "DELETE FROM proyecto WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $proyecto->getId()];
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en ProyectoDAO::del: " . $e->getMessage());
            return -1;
        }
    }
}




?>