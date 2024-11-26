<?php 
require_once 'database.php';

class DesarrolladorDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function findById($id) {
        try {
            $sql = "SELECT id, nombre, apaterno, amaterno, fnacimiento, activo FROM desarrollador
                    WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $id];
            $stmt->execute($params);

            $desarrollador = new Desarrollador();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $desarrollador->setId($row['id']);
                $desarrollador->setNombre($row['nombre']);
                $desarrollador->setApaterno($row['apaterno']);
                $desarrollador->setAmaterno($row['amaterno']);
                $desarrollador->setFnacimiento($row['fnacimiento']);
                $desarrollador->setActivo($row['activo']);
            }
            
            return $desarrollador;
        } catch (Exception $e) {
            error_log("Error en DesarrolladorDAO::findById: " . $e->getMessage());
            return array();
        } 
    }

    public function list() {
        try {
            $sql = "SELECT id, nombre, apaterno, amaterno, fnacimiento, activo FROM desarrollador";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $desarrolladores = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $desarrollador = new Desarrollador();
                $desarrollador->setId($row['id']);
                $desarrollador->setNombre($row['nombre']);
                $desarrollador->setApaterno($row['apaterno']);
                $desarrollador->setAmaterno($row['amaterno']);
                $desarrollador->setFnacimiento($row['fnacimiento']);
                $desarrollador->setActivo($row['activo']);
                $desarrolladores[] = $desarrollador;
            }
            
            return $desarrolladores;
        } catch (Exception $e) {
            error_log("Error en DesarrolladorDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function add(Desarrollador $desarrollador) {
        try {
            $sql = "INSERT INTO desarrollador (nombre, apaterno, amaterno, fnacimiento, activo) 
                    VALUES (:nombre, :apaterno, :amaterno, :fnacimiento, :activo)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $desarrollador->getNombre(),
                ':apaterno' => $desarrollador->getApaterno(),
                ':amaterno' => $desarrollador->getAmaterno(),
                ':fnacimiento' => $desarrollador->getFnacimiento(),
                ':activo' => $desarrollador->getActivo()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en DesarrolladorDAO::add: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(Desarrollador $desarrollador) {
        try {
            $sql = "UPDATE desarrollador 
                    SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, 
                        fnacimiento = :fnacimiento, activo = :activo 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':nombre' => $desarrollador->getNombre(),
                ':apaterno' => $desarrollador->getApaterno(),
                ':amaterno' => $desarrollador->getAmaterno(),
                ':fnacimiento' => $desarrollador->getFnacimiento(),
                ':activo' => $desarrollador->getActivo(),
                ':id' => $desarrollador->getId()
            ];

            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en DesarrolladorDAO::update: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($desarrollador) {
        try {
            $sql = "DELETE FROM desarrollador WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $desarrollador->getId()];
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en DesarrolladorDAO::del: " . $e->getMessage());
            return -1;
        }
    }
}

?>