<?php
require_once 'database.php';


class EquipoDAO {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function listByIdProject($idP) {
        try {
            $sql = "SELECT id, id_desarrollador, horas_asignadas_por_dia, id_proyecto FROM equipo
                    WHERE id_proyecto = :idP";
            $stmt = $this->conn->prepare($sql);
            $params = [':idP' => $idP];
            $stmt->execute($params);

            $equipos = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $desa = new Desarrollador();
                $desa->setId($row['id_desarrollador']);

                $equipo = new Equipo();
                $equipo->setId($row['id']);
                $equipo->setDesarrollador($desa);
                $equipo->setHorasAsignadasPorDia($row['horas_asignadas_por_dia']);
                $equipo->setIdProyecto($row['id_proyecto']);
                $equipos[] = $equipo;
            }
            
            return $equipos;
        } catch (Exception $e) {
            error_log("Error en EquipoDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function list() {
        try {
            $sql = "SELECT id, id_desarrollador, horas_asignadas_por_dia, id_proyecto FROM equipo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $equipos = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equipo = new Equipo();
                $equipo->setId($row['id']);
                $equipo->setIdDesarrollador($row['id_desarrollador']);
                $equipo->setHorasAsignadasPorDia($row['horas_asignadas_por_dia']);
                $equipo->setIdProyecto($row['id_proyecto']);
                $equipos[] = $equipo;
            }
            
            return $equipos;
        } catch (Exception $e) {
            error_log("Error en EquipoDAO::list: " . $e->getMessage());
            return array();
        } 
    }

    public function add(Equipo $equipo) {
        try {
            $sql = "INSERT INTO equipo (id_desarrollador, horas_asignadas_por_dia, id_proyecto) 
                    VALUES (:idDesarrollador, :horasAsignadasPorDia, :idProyecto)";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':idDesarrollador' => $equipo->getIdDesarrollador(),
                ':horasAsignadasPorDia' => $equipo->getHorasAsignadasPorDia(),
                ':idProyecto' => $equipo->getIdProyecto()
            ];

            if ($stmt->execute($params)) {
                return $this->conn->lastInsertId();
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error en EquipoDAO::add: " . $e->getMessage());
            return -1;
        } 
    }

    public function update(Equipo $equipo) {
        try {
            $sql = "UPDATE equipo 
                    SET id_desarrollador = :idDesarrollador, 
                        horas_asignadas_por_dia = :horasAsignadasPorDia, 
                        id_proyecto = :idProyecto 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $params = [
                ':idDesarrollador' => $equipo->getIdDesarrollador(),
                ':horasAsignadasPorDia' => $equipo->getHorasAsignadasPorDia(),
                ':idProyecto' => $equipo->getIdProyecto(),
                ':id' => $equipo->getId()
            ];

            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en EquipoDAO::update: " . $e->getMessage());
            return -1;
        } 
    }

    public function del($equipo) {
        try {
            $sql = "DELETE FROM equipo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $params = [':id' => $equipo->getId()];
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (Exception $e) {
            error_log("Error en EquipoDAO::del: " . $e->getMessage());
            return -1;
        }
    }
}


?>