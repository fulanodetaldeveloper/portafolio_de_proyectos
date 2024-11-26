<?php 
// Clase Proyecto
class Proyecto implements JsonSerializable  {
    private $id;
    private $nombre;
    private $descripcion;
    private $projectManager;
    private $finicio;
    private $ftermino;
    private $desarrolladores;


    public function __construct($nombre = null, $descripcion = null, $projectManager = null, $finicio = null, $ftermino = null, $desarrolladores = []) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->projectManager = $projectManager;
        $this->finicio = $finicio;
        $this->ftermino = $ftermino;
        $this->desarrolladores = $desarrolladores;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getProjectManager() { return $this->projectManager; }
    public function getFinicio() { return $this->finicio; }
    public function getFtermino() { return $this->ftermino; }
    public function getDesarrolladores() { return $this->desarrolladores; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setProjectManager($projectManager) { $this->projectManager = $projectManager; }
    public function setFinicio($finicio) { $this->finicio = $finicio; }
    public function setFtermino($ftermino) { $this->ftermino = $ftermino; }
    public function setDesarrolladores($desarrolladores) { $this->desarrolladores = $desarrolladores; }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'projectManager' => $this->projectManager,
            'finicio' => $this->finicio,
            'ftermino' => $this->ftermino,
            'desarrolladores' => $this->desarrolladores,
        ];
    }
}


?>