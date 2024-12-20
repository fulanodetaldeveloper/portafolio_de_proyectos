<?php 


class UsuarioFacade {
    private $proyectoDAO;
    private $managerDAO;
    private $teamDAO;
    private $devDAO;
    private $userDAO;

    public function __construct() {
        $this->proyectoDAO = new ProyectoDAO();
        $this->managerDAO = new ProjectManagerDAO();
        $this->teamDAO = new EquipoDAO();
        $this->devDAO = new DesarrolladorDAO();
        $this->userDAO = new UsuarioDAO();
    }

    public function listAll() {
        $proyectos = $this->proyectoDAO->list();
        
        foreach ($proyectos as $p) {
            $desarrolladores = array();
            $id = $p->getProjectManager()->getId();
            $manager = $this->managerDAO->findById($id);
            $p->setProjectManager($manager);
            $team = $this->teamDAO->listByIdProject($p->getId());
            foreach ($team as $t){
                $dev = $this->devDAO->findById($t->getDesarrollador()->getId());

                $desarrolladores[] = $dev;
            }
            $p->setDesarrolladores($desarrolladores);
        }
        
        return $proyectos;
    }


    public function validUser($user, $pass) {
        $auth = $this->userDAO->findByPass($user, $pass);
        if($auth->getId() == 0){
            
        }
        
        return $auth;
    }

}

?>