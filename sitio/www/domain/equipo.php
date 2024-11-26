<?php 
// Clase Equipo
class Equipo  implements JsonSerializable {
    private $id;
    private $desarrollador;
    private $horasAsignadasPorDia;
    private $idProyecto;

    public function __construct($desarrollador = null, $horasAsignadasPorDia = null, $idProyecto = null) {
        $this->desarrollador = $desarrollador;
        $this->horasAsignadasPorDia = $horasAsignadasPorDia;
        $this->idProyecto = $idProyecto;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getDesarrollador() { return $this->desarrollador; }
    public function getHorasAsignadasPorDia() { return $this->horasAsignadasPorDia; }
    public function getIdProyecto() { return $this->idProyecto; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setDesarrollador($desarrollador) { $this->desarrollador = $desarrollador; }
    public function setHorasAsignadasPorDia($horasAsignadasPorDia) { $this->horasAsignadasPorDia = $horasAsignadasPorDia; }
    public function setIdProyecto($idProyecto) { $this->idProyecto = $idProyecto; }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'desarrollador' => $this->desarrollador,
            'horasAsignadasPorDia' => $this->horasAsignadasPorDia,
            'idProyecto' => $this->idProyecto,
        ];
    }
}


?>