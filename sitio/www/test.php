<?php 
ini_set('display_errors', 1); // Habilitar la visualización de errores
ini_set('display_startup_errors', 1);

// Hashear el password por seguridad
$password="1111";
#$password="2222";



$hash = hash('sha256', $password, true); 
$hashHex = bin2hex($hash);

/*** 
 * $dao = new UsuarioDAO();
$usuario->setIdTipo(1);
$id = $dao->add($usuario);


$list = $dao->list();
echo json_encode($list);

$usuario->setId($id);
$usuario->setName("vvvvvv");
$id = $dao->update($usuario);
echo $id."  ================ ";

$id = $dao->del($usuario);
echo $id."  +++++++++++++++    ";


$list = $dao->list();  ***/ 

echo json_encode($hashHex);
?>