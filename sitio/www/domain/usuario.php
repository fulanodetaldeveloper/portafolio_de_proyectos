<?php 
// Clase Usuario
class Usuario implements JsonSerializable {
    private $id;
    private $name;
    private $password;
    private $idTipo;
    private $apiKey;

    public function __construct($name = null, $password = null, $idTipo = null, $apiKey = "") {
        $this->name = $name;
        $this->password = $password;
        $this->idTipo = $idTipo;
        $this->apiKey = $apiKey;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getPassword() { return $this->password; }
    public function getIdTipo() { return $this->idTipo; }
    public function getApiKey() { return $this->apiKey; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setPassword($password) { $this->password = $password; }
    public function setIdTipo($idTipo) { $this->idTipo = $idTipo; }
    public function setApiKey($apiKey) { $this->apiKey = $apiKey; }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'password' => $this->password,
            'idTipo' => $this->idTipo,
        ];
    }
}

?>