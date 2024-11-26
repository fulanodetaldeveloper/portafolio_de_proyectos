<?php 
// Clase TipoUsuario
class TipoUsuario implements JsonSerializable {
    private $id;
    private $tipo;
    private $lectura;
    private $escritura;

    public function __construct($tipo = null, $lectura = null, $escritura = null) {
        $this->tipo = $tipo;
        $this->lectura = $lectura;
        $this->escritura = $escritura;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTipo() { return $this->tipo; }
    public function getLectura() { return $this->lectura; }
    public function getEscritura() { return $this->escritura; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    public function setLectura($lectura) { $this->lectura = $lectura; }
    public function setEscritura($escritura) { $this->escritura = $escritura; }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'lectura' => $this->lectura,
            'escritura' => $this->escritura,
        ];
    }
}

?>