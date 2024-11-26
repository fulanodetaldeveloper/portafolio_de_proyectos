<?php
class Database {
    private static $instance = null;
    private $connection;
    
    // Configuración de la base de datos
    private $host = "127.0.0.1";
    private $db_name = "bd1";
    private $username = "toor";
    private $password = "1234";
    
    // Constructor privado para prevenir la instanciación directa
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->connection->exec("SET NAMES utf8");
        } catch(PDOException $e) {
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }
    
    // Método para obtener la instancia de la conexión
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Método para obtener la conexión
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevenir la clonación del objeto
    private function __clone() {}
    
    // Prevenir la deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar una instancia de " . get_class($this));
    }
}

?>