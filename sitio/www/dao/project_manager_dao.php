<?php
require_once 'database.php';


class ProjectManagerDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function findById($id) {
        try {
            $sql = "SELECT id, nombre, apaterno, amaterno, fnacimiento, activo FROM project_manager 
                     WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $id];
            $stmt->execute($params);

            $manager = new ProjectManager();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $manager->setId($row['id']);
                $manager->setNombre($row['nombre']);
                $manager->setApaterno($row['apaterno']);
                $manager->setAmaterno($row['amaterno']);
                $manager->setFnacimiento($row['fnacimiento']);
                $manager->setActivo($row['activo']);
            }
            
            return $manager;
        } catch (Exception $e) {
            error_log("Error en ProjectManagerDAO::findById: " . $e->getMessage());
            return array();
        } 
    }


    public function list() {
        try {
            $sql = "SELECT id, nombre, apaterno, amaterno, fnacimiento, activo FROM project_manager";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $managers = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $manager = new ProjectManager();
                $manager->setId($row['id']);
                $manager->setNombre($row['nombre']);
                $manager->setApaterno($row['apaterno']);
                $manager->setAmaterno($row['amaterno']);
                $manager->setFnacimiento($row['fnacimiento']);
                $manager->setActivo($row['activo']);
                $managers[] = $manager;
            }
            
            return $managers;
        } catch (Exception $e) {
            error_log("Error en ProjectManagerDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function add(ProjectManager $manager) {
        try {
            $sql = "INSERT INTO project_manager (nombre, apaterno, amaterno, fnacimiento, activo) 
                    VALUES (:nombre, :apaterno, :amaterno, :fnacimiento, :activo)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $manager->getNombre(),
                ':apaterno' => $manager->getApaterno(),
                ':amaterno' => $manager->getAmaterno(),
                ':fnacimiento' => $manager->getFnacimiento(),
                ':activo' => $manager->getActivo()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en ProjectManagerDAO::add: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(ProjectManager $manager) {
        try {
            $sql = "UPDATE project_manager 
                    SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno,
                        fnacimiento = :fnacimiento, activo = :activo 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $manager->getNombre(),
                ':apaterno' => $manager->getApaterno(),
                ':amaterno' => $manager->getAmaterno(),
                ':fnacimiento' => $manager->getFnacimiento(),
                ':activo' => $manager->getActivo(),
                ':id' => $manager->getId()
            ];

            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en ProjectManagerDAO::update: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($manager) {
        try {
            $sql = "DELETE FROM project_manager WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $manager->getId()];
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en ProjectManagerDAO::del: " . $e->getMessage());
            return -1;
        }
    }
}


?>