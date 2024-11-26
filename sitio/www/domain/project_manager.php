<?php 
// Clase ProjectManager
class ProjectManager  implements JsonSerializable  {
    private $id;
    private $nombre;
    private $apaterno;
    private $amaterno;
    private $fnacimiento;
    private $activo;

    public function __construct($nombre = null, $apaterno = null, $amaterno = null, $fnacimiento = null, $activo = null) {
        $this->nombre = $nombre;
        $this->apaterno = $apaterno;
        $this->amaterno = $amaterno;
        $this->fnacimiento = $fnacimiento;
        $this->activo = $activo;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getApaterno() { return $this->apaterno; }
    public function getAmaterno() { return $this->amaterno; }
    public function getFnacimiento() { return $this->fnacimiento; }
    public function getActivo() { return $this->activo; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApaterno($apaterno) { $this->apaterno = $apaterno; }
    public function setAmaterno($amaterno) { $this->amaterno = $amaterno; }
    public function setFnacimiento($fnacimiento) { $this->fnacimiento = $fnacimiento; }
    public function setActivo($activo) { $this->activo = $activo; }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apaterno' => $this->apaterno,
            'amaterno' => $this->amaterno,
            'fnacimiento' => $this->fnacimiento,
            'activo' => $this->activo,
        ];
    }
}


?>