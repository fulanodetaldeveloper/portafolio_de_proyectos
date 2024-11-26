<?php
require_once 'database.php';
require_once 'domain/tipo_usuario.php';



class TipoUsuarioDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function list() {
        try {
            $sql = "SELECT id, tipo, lectura, escritura FROM tipo_usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $tiposUsuario = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tipoUsuario = new TipoUsuario();
                $tipoUsuario->setId($row['id']);
                $tipoUsuario->setTipo($row['tipo']);
                $tipoUsuario->setLectura($row['lectura']);
                $tipoUsuario->setEscritura($row['escritura']);
                $tiposUsuario[] = $tipoUsuario;
            }
            
            return $tiposUsuario;
        } catch (Exception $e) {
            error_log("Error en TipoUsuarioDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function add(TipoUsuario $tipoUsuario) {
        try {
            $sql = "INSERT INTO tipo_usuario (tipo, lectura, escritura) 
                    VALUES (:tipo, :lectura, :escritura)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':tipo' => $tipoUsuario->getTipo(),
                ':lectura' => $tipoUsuario->getLectura(),
                ':escritura' => $tipoUsuario->getEscritura()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en TipoUsuarioDAO::add: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(TipoUsuario $tipoUsuario) {
        try {
            $sql = "UPDATE tipo_usuario 
                    SET tipo = :tipo, lectura = :lectura, escritura = :escritura 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':tipo' => $tipoUsuario->getTipo(),
                ':lectura' => $tipoUsuario->getLectura(),
                ':escritura' => $tipoUsuario->getEscritura(),
                ':id' => $tipoUsuario->getId()
            ];

            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en TipoUsuarioDAO::update: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($tipoUsuario) {
        try {
            $sql = "DELETE FROM tipo_usuario WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $tipoUsuario->getId()];
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en TipoUsuarioDAO::del: " . $e->getMessage());
            return -1;
        }
    }
}



?>