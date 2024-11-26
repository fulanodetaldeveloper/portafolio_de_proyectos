<?php
require_once 'database.php';




class UsuarioDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function findByPass($user, $pass) {
        try {
             // Hashear el password por seguridad
             $hash = hash('sha256', $pass, true); 
             $passwordHash = bin2hex($hash);
 
            // Preparar la consulta SQL
            $sql = "SELECT id, name, password, id_tipo, api_key FROM usuario
                    WHERE password = :pass AND name = :user";
            $stmt = $this->conn->prepare($sql);
            $params = [':pass' => $passwordHash, ':user' => $user];
            $stmt->execute($params);

            $usuario = new Usuario();
            $usuario->setId(0);
            // Recorrer el resultado fila por fila
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario->setId($row['id']);
                $usuario->setName($row['name']);
                $usuario->setPassword($row['password']);
                $usuario->setIdTipo($row['id_tipo']);
                $usuario->setApiKey($row['api_key']);
            }
            
            return $usuario;
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::listarTodos: " . $e->getMessage());
            return array();
        } 
    }

    public function findByApiKey($apiKey) {
        try {
            // Preparar la consulta SQL
            $sql = "SELECT id, name, password, id_tipo, api_key FROM usuario
                    WHERE api_key = :apiKey";
            $stmt = $this->conn->prepare($sql);
            $params = [':apiKey' => $apiKey];
            $stmt->execute($params);

            $usuario = new Usuario();
            $usuario->setId(0);
            // Recorrer el resultado fila por fila
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario->setId($row['id']);
                $usuario->setName($row['name']);
                $usuario->setPassword($row['password']);
                $usuario->setIdTipo($row['id_tipo']);
                $usuario->setApiKey($row['api_key']);
            }
            
            return $usuario;
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::listarTodos: " . $e->getMessage());
            return array();
        } 
    }

    public function list() {
        try {
            // Preparar la consulta SQL
            $sql = "SELECT id, name, password, id_tipo, api_key FROM usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // Crear un array para almacenar los objetos Usuario
            $usuarios = array();
            // Recorrer el resultado fila por fila
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario = new Usuario();
                $usuario->setId($row['id']);
                $usuario->setName($row['name']);
                $usuario->setPassword($row['password']);
                $usuario->setIdTipo($row['id_tipo']);
                $usuarios[] = $usuario;
            }
            
            return $usuarios;
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::listarTodos: " . $e->getMessage());
            return array();
        } 
    }

    public function add(Usuario $usuario) {
        try {
            // Hashear el password por seguridad
            $coste = ['cost' => 12]; 
            $passwordHash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT, $coste);

            $sql = "INSERT INTO usuario (name, password, id_tipo) 
                                VALUES (:name, :password, :idTipo)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':name' => $usuario->getName(),
                ':password' => $passwordHash,
                ':idTipo' => $usuario->getIdTipo()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::crear: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(Usuario $usuario) {
        try {
            // Hashear el password por seguridad
            $coste = ['cost' => 12]; 
            $passwordHash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT, $coste);

            $sql = "UPDATE usuario 
                 SET name = :name, password = :password, id_tipo = :idTipo 
                 WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':name' => $usuario->getName(),
                ':password' => $passwordHash,
                ':idTipo' => $usuario->getIdTipo(),
                ':id' => $usuario->getId()

            ];
            $stmt->execute($params);

            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::actualizar: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($usuario) {
        try {
            $sql = "DELETE FROM usuario WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id' => $usuario->getId()
            ];
            $stmt->execute($params);

            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en UsuarioDAO::eliminar: " . $e->getMessage());
            return -1;
        }
    }
}
?>